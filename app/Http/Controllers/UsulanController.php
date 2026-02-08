<?php

namespace App\Http\Controllers;

use App\Models\Usulan;
use App\Models\Notifikasi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UsulanController extends Controller
{
    /**
     * Display a listing of the resource (Index)
     * Menampilkan daftar semua usulan sesuai role
     */
    public function index()
    {
        $userId = session('user_id');
        $currentUser = User::find($userId);
        
        if (!$currentUser) {
            return redirect()->route('admin.login')->with('error', 'Sesi anda berakhir.');
        }

        // Ambil Data Dusun
        // Jika Operator Dusun, hanya ambil dusun dia
        if ($currentUser->role == 'operator_dusun') {
            $dusuns = \App\Models\Dusun::with('usulan')
                ->where('id_dusun', $currentUser->id_dusun)
                ->get();
        } else {
            // Operator Desa / Admin bisa lihat semua
            $dusuns = \App\Models\Dusun::with('usulan')->get();
        }

        return view('admin.usulan.index', compact('dusuns', 'currentUser'));
    }

    /**
     * Show the form for creating a new resource (Create Form)
     * Menampilkan form untuk membuat usulan baru
     */
    public function create()
    {
        $userId = session('user_id');
        $currentUser = User::find($userId);

        if (!$currentUser) {
            return redirect()->route('admin.login')->with('error', 'Sesi anda berakhir.');
        }

        // Validasi Role: Hanya Operator Dusun yang bisa nambah
        if ($currentUser->role != 'operator_dusun' && $currentUser->role != 'admin') { 
             if ($currentUser->role == 'operator_desa') {
                 return redirect()->route('usulan.index')->with('error', 'Operator Desa tidak dapat menambah usulan.');
             }
        }

        $dusuns = \App\Models\Dusun::all();
        $rws = \App\Models\RW::all();
        $rts = \App\Models\RT::all();
        $tahun_aktif = \App\Models\Tahun::where('status', 'Aktif')->value('tahun') ?? date('Y');

        // Fetch Usulan that are currently in 'Proses' for this session context
        $draftUsulans = [];
        if ($currentUser->role == 'operator_dusun') {
            $draftUsulans = Usulan::where('id_dusun', $currentUser->id_dusun)
                                  ->where('tahun', $tahun_aktif)
                                  ->where('status', 'Proses')
                                  ->orderBy('prioritas', 'asc')
                                  ->get();
        }

        return view('admin.usulan.create', compact('dusuns', 'rws', 'rts', 'tahun_aktif', 'currentUser', 'draftUsulans'));
    }

    /**
     * Store a newly created resource in storage (Store)
     * Menyimpan data usulan baru ke database
     */
    public function store(Request $request)
    {
        if (!session('user_authenticated')) {
             return redirect()->route('admin.login');
        }

        // Validasi input
        $validated = $request->validate([
            'jenis_kegiatan' => 'required|string',
            'deskripsi' => 'nullable|string',
            'id_dusun' => 'required|exists:dusun,id_dusun',
            'id_rw' => 'required|exists:rw,id_rw',
            'id_rt' => 'required|exists:rt,id_rt',
            'prioritas' => 'required|integer|min:1',
            'tahun' => 'required|integer',
            // 'file_berita_acara' removed from singular store
        ]);

        $exists = Usulan::where('id_dusun', $validated['id_dusun'])
                    ->where('prioritas', $validated['prioritas'])
                    ->where('tahun', $validated['tahun'])
                    ->exists();

        if ($exists) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['prioritas' => 'Prioritas ' . $validated['prioritas'] . ' sudah ada untuk dusun ini di tahun ' . $validated['tahun'] . '.']);
        }

        $validated['status'] = 'Proses';
        
        $usulan = Usulan::create($validated);

        Notifikasi::create([
            'judul' => 'Usulan Baru',
            'deskripsi' => 'Usulan baru dari Dusun ' . $usulan->dusun->nama . ': ' . substr($validated['jenis_kegiatan'], 0, 50),
            'id_kegiatan' => $usulan->id_usulan,
            'judul_kegiatan' => $validated['jenis_kegiatan'],
            'status' => 'info',
            'id_penerima' => null,
            'dibaca' => 0
        ]);

        // Redirect back for bulk entry
        return redirect()->back()
            ->with('success', 'Usulan berhasil ditambahkan. Silakan input usulan berikutnya.');
    }

    /**
     * Upload Berita Acara for multiple Usulans
     */
    public function uploadBeritaAcara(Request $request)
    {
        $request->validate([
            'id_dusun' => 'required|exists:dusun,id_dusun',
            'tahun' => 'required|integer',
            'file_berita_acara' => 'required|file|mimes:pdf,doc,docx,jpg,png|max:10240', 
        ]);

        if ($request->hasFile('file_berita_acara')) {
            $file = $request->file('file_berita_acara');
            $filename = time() . '_ba_musdus_' . $request->id_dusun . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/berita_acara'), $filename);
            $path = 'uploads/berita_acara/' . $filename;

            Usulan::where('id_dusun', $request->id_dusun)
                  ->where('tahun', $request->tahun)
                  ->where('status', 'Proses') 
                  ->update(['file_berita_acara' => $path]);

            return redirect()->back()->with('success', 'Berita Acara berhasil diunggah untuk semua usulan yang diproses.');
        }

        return redirect()->back()->with('error', 'Gagal mengunggah file.');
    }

    /**
     * Display the specified resource (Show/View)
     * Menampilkan detail usulan tertentu
     */
    public function show($id)
    {
        $usulan = Usulan::findOrFail($id);
        
        // Fetch logs from Notifikasi where id_kegiatan matches usulan ID 
        // Note: Notifikasi 'id_kegiatan' is being overloaded for Usulan IDs too as per StatusService update.
        // We might want to filter by 'judul' or add a 'type' column later, but for now assuming disjoint IDs or just showing mixed if collision (rare if big int).
        // Actually, cleaner way is: Usulan logs might be distinguished by 'judul' containing "Usulan".
        // Or better, just show logs where id_kegiatan matches.
        $logs = Notifikasi::where('id_kegiatan', $id)
                    ->Where('judul', 'like', '%Usulan%') // Filter to be safe? Or just all.
                    ->orWhere(function($query) use ($id){
                         $query->where('id_kegiatan', $id)
                               ->where('judul_kegiatan', '!=', null); // Just simple fetch
                    })
                    ->orderBy('created_at', 'desc')
                    ->get();

        // Simplified: Just get by ID for now.
        $logs = Notifikasi::where('id_kegiatan', $id)->orderBy('created_at', 'desc')->get();

        return view('admin.usulan.show', compact('usulan', 'logs'));
    }

    /**
     * Show the form for editing the specified resource (Edit Form)
     * Menampilkan form untuk mengedit usulan
     */
    public function edit($id)
    {
        $usulan = Usulan::findOrFail($id);
        $dusuns = \App\Models\Dusun::all();
        $rws = \App\Models\RW::all();
        $rts = \App\Models\RT::all();
        
        return view('admin.usulan.edit', compact('usulan', 'dusuns', 'rws', 'rts'));
    }

    /**
     * Update the specified resource in storage (Update)
     * Mengupdate data usulan di database
     */
    public function update(Request $request, $id)
    {
        $usulan = Usulan::findOrFail($id);

        // Validasi input
        $validated = $request->validate([
            'jenis_kegiatan' => 'required|string',
            'deskripsi' => 'nullable|string',
            'id_dusun' => 'required|exists:dusun,id_dusun',
            'id_rw' => 'nullable|exists:rw,id_rw',
            'id_rt' => 'nullable|exists:rt,id_rt',
            'prioritas' => 'required|integer|min:1',
            // 'status' => 'required', 
            'tahun' => 'required|integer',
            'file_berita_acara' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:5120',
        ]);

        // Check unique priority ONLY if it changed
        if (($usulan->prioritas != $validated['prioritas']) || ($usulan->tahun != $validated['tahun'])) {
             $exists = Usulan::where('id_dusun', $validated['id_dusun'])
                    ->where('prioritas', $validated['prioritas'])
                    ->where('tahun', $validated['tahun'])
                    ->where('id_usulan', '!=', $id) // Exclude self
                    ->exists();

            if ($exists) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['prioritas' => 'Prioritas ' . $validated['prioritas'] . ' sudah digunakan.']);
            }
        }

        // Handle File Upload
        if ($request->hasFile('file_berita_acara')) {
            $file = $request->file('file_berita_acara');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/berita_acara'), $filename);
            $validated['file_berita_acara'] = 'uploads/berita_acara/' . $filename;
        }

        // Update usulan
        $usulan->update($validated);

        // Log Update Activity
        Notifikasi::create([
            'judul' => 'Usulan Diedit',
            'deskripsi' => 'Data usulan ' . substr($usulan->jenis_kegiatan, 0, 30) . ' telah diperbarui.',
            'id_kegiatan' => $usulan->id_usulan,
            'judul_kegiatan' => $usulan->jenis_kegiatan,
            'status' => 'info',
            'id_penerima' => null,
            'dibaca' => 0
        ]);

        return redirect()->route('usulan.index')
            ->with('success', 'Usulan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage (Delete)
     * Menghapus usulan dari database
     */
    public function destroy($id)
    {
        $usulan = Usulan::findOrFail($id);
        
        // Log Delete Activity
        Notifikasi::create([
            'judul' => 'Usulan Dihapus',
            'deskripsi' => 'Usulan ' . substr($usulan->jenis_kegiatan, 0, 30) . ' telah dihapus.',
            'id_kegiatan' => $usulan->id_usulan,
            'judul_kegiatan' => $usulan->jenis_kegiatan,
            'status' => 'danger',
            'id_penerima' => null,
            'dibaca' => 0
        ]);

        $usulan->delete();

        return redirect()->route('usulan.index')
            ->with('success', 'Usulan berhasil dihapus');
    }
}
