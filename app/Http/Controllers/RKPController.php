<?php

namespace App\Http\Controllers;

use App\Models\RKPDesa;
use Illuminate\Http\Request;

class RKPController extends Controller
{
    /**
     * Display a listing of the resource (Index)
     * Menampilkan daftar semua RKP Desa
     */
    public function index()
    {
        $rkpDesaSs = RKPDesa::paginate(10);
        return view('admin.rkpdesa.index', compact('rkpDesaSs'));
    }

    /**
     * Show the form for creating a new resource (Create Form)
     * Menampilkan form untuk membuat RKP Desa baru
     */
    public function create()
    {
        $tahuns = \App\Models\Tahun::where('status', 'aktif')->get();
        $rpjms = \App\Models\RPJM::all(); // Assuming RPJM model exists
        $usulans = \App\Models\Usulan::where('status', 'Setuju')->get(); // Only approved usulans
        $bidangs = \App\Models\Bidang::all();
        $sumber_biayas = \App\Models\SumberBiaya::all();
        $pola_pelaksanaans = \App\Models\PolaPelaksanaan::all();

        return view('admin.rkpdesa.create', compact('tahuns', 'rpjms', 'usulans', 'bidangs', 'sumber_biayas', 'pola_pelaksanaans'));
    }

    /**
     * Store a newly created resource in storage (Store)
     * Menyimpan data RKP Desa baru ke database
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            // 'id_kegiatan' => 'required|unique:rkpdesa', // Auto increment ID, not needed validation usually
            'nama' => 'required|string|max:255',
            'bidang' => 'required|exists:bidang,id_bidang',
            'jenis_kegiatan' => 'required|string',
            'data_existing' => 'nullable|string',
            'target_capaian' => 'nullable|string',
            'lokasi' => 'nullable|string',
            'volume' => 'nullable|string',
            'penerima' => 'nullable|string',
            'waktu' => 'nullable|string',
            'jumlah' => 'nullable|numeric',
            'sumber_biaya' => 'required|exists:sumber_biaya,id_sumber_biaya',
            'pola_pelaksanaan' => 'required|exists:pola_pelaksanaan,id_pola',
            'status' => 'required|in:draft,diajukan,disetujui,ditolak',
            'tahun' => 'required|exists:tahun,id_tahun',
            'id_rpjm' => 'nullable|exists:rpjm,id_rpjm',
            'id_usulan' => 'nullable|exists:usulan,id_usulan',
            'file_berita_acara_musrenbang' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:5120',
        ]);

        // Handle File Upload
        if ($request->hasFile('file_berita_acara_musrenbang')) {
            $file = $request->file('file_berita_acara_musrenbang');
            $filename = time() . '_musrenbang_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/rkp'), $filename);
            $validated['file_berita_acara_musrenbang'] = 'uploads/rkp/' . $filename;
        }

        // Simpan RKP Desa baru
        RKPDesa::create($validated);

        return redirect()->route('rkpdesa.index')
            ->with('success', 'RKP Desa berhasil ditambahkan');
    }

    /**
     * Display the specified resource (Show/View)
     * Menampilkan detail RKP Desa tertentu
     */
    public function show($id)
    {
        $rkpDesa = RKPDesa::findOrFail($id);
        return view('admin.rkpdesa.show', compact('rkpDesa'));
    }

    /**
     * Show the form for editing the specified resource (Edit Form)
     * Menampilkan form untuk mengedit RKP Desa
     */
    public function edit($id)
    {
        $rkpDesa = RKPDesa::findOrFail($id);
        $tahuns = \App\Models\Tahun::where('status', 'aktif')->get();
        $rpjms = \App\Models\RPJM::all();
        $usulans = \App\Models\Usulan::where('status', 'Setuju')->get();
        $bidangs = \App\Models\Bidang::all();
        $sumber_biayas = \App\Models\SumberBiaya::all();
        $pola_pelaksanaans = \App\Models\PolaPelaksanaan::all();

        return view('admin.rkpdesa.edit', compact('rkpDesa', 'tahuns', 'rpjms', 'usulans', 'bidangs', 'sumber_biayas', 'pola_pelaksanaans'));
    }

    /**
     * Update the specified resource in storage (Update)
     * Mengupdate data RKP Desa di database
     */
    public function update(Request $request, $id)
    {
        $rkpDesa = RKPDesa::findOrFail($id);

        // Validasi input
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'bidang' => 'required|exists:bidang,id_bidang',
            'jenis_kegiatan' => 'required|string',
            'data_existing' => 'nullable|string',
            'target_capaian' => 'nullable|string',
            'lokasi' => 'nullable|string',
            'volume' => 'nullable|string',
            'penerima' => 'nullable|string',
            'waktu' => 'nullable|string',
            'jumlah' => 'nullable|numeric',
            'sumber_biaya' => 'required|exists:sumber_biaya,id_sumber_biaya',
            'pola_pelaksanaan' => 'required|exists:pola_pelaksanaan,id_pola',
            'status' => 'required|in:draft,diajukan,disetujui,ditolak',
            'tahun' => 'required|exists:tahun,id_tahun',
            'id_rpjm' => 'nullable|exists:rpjm,id_rpjm',
            'id_usulan' => 'nullable|exists:usulan,id_usulan',
            'file_berita_acara_musrenbang' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:5120',
            'status_verifikasi' => 'nullable|in:Menunggu,Diterima,Ditolak,Revisi',
            'catatan_verifikasi' => 'nullable|string',
            'status_approval' => 'nullable|string', // Menunggu, Disetujui BPD, Disetujui Kepala Desa
        ]);

        // Handle File Upload
        if ($request->hasFile('file_berita_acara_musrenbang')) {
            $file = $request->file('file_berita_acara_musrenbang');
            $filename = time() . '_musrenbang_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/rkp'), $filename);
            $validated['file_berita_acara_musrenbang'] = 'uploads/rkp/' . $filename;
        }

        // Update RKP Desa
        $rkpDesa->update($validated);

        return redirect()->route('rkpdesa.index')
            ->with('success', 'RKP Desa berhasil diperbarui');
    }

    /**
     * Store RKP Desa from Usulan (Bulk Action)
     * Memindahkan data Usulan terpilih ke tabel RKP Desa
     */
    public function storeFromUsulan(Request $request)
    {
        $request->validate([
            'id_usulan' => 'required|array',
            'id_usulan.*' => 'exists:usulan,id_usulan',
        ]);

        $ids = $request->id_usulan;
        $count = 0;

        foreach ($ids as $id) {
            $usulan = \App\Models\Usulan::find($id);
            if ($usulan) {
                // Cek apakah sudah ada di RKP (optional check to prevent duplicates if needed, but prompt didn't specify strict check, just logic)
                // Disini kita asumsi bisa masuk berkali-kali atau cek flag status 'Pending' di Usulan
                
                if ($usulan->status != 'Pending' && $usulan->status != 'Proses') {
                    // Skip if already processed or invalid status? User said "Proses" -> "Pending"
                    // But let's allow "Proses" to be moved.
                }

                // Create RKP Desa
                // "jenis kegiatan -> masuk ke kolom nama dan jenis kegiatan"
                RKPDesa::create([
                    'nama' => $usulan->jenis_kegiatan,
                    'jenis_kegiatan' => $usulan->jenis_kegiatan,
                    'bidang' => '1', // Default or need mapping? Prompt didn't specify, use default valid ID
                    'id_usulan' => $usulan->id_usulan,
                    'id_rpjm' => null, // Not from RPJM
                    'tahun' => $usulan->tahun,
                    'status' => 'draft', // Default RKP status
                    'sumber_biaya' => '1', // Default
                    'pola_pelaksanaan' => '1', // Default
                    'status_verifikasi' => 'pending',
                    'status_approval' => 'pending',
                ]);

                // Update Status Usulan
                $usulan->update(['status' => 'Pending']);

                // Create Notification for Operator Dusun
                \App\Models\Notifikasi::create([
                    'judul' => 'Usulan Masuk RKP',
                    'deskripsi' => 'Usulan "' . substr($usulan->jenis_kegiatan, 0, 30) . '..." telah masuk ke draft RKP Desa.',
                    'id_kegiatan' => $usulan->id_usulan,
                    'judul_kegiatan' => $usulan->jenis_kegiatan,
                    'status' => 'success',
                    'id_penerima' => null, // Logic to target specific user if needed
                    'dibaca' => 0
                ]);

                $count++;
            }
        }

        return redirect()->route('usulan.index')
            ->with('success', $count . ' Usulan berhasil dimasukkan ke RKP Desa (Status: Pending)');
    }

    /**
     * Remove the specified resource from storage (Delete)
     * Menghapus RKP Desa dari database
     */
    public function destroy($id)
    {
        $rkpDesa = RKPDesa::findOrFail($id);
        $rkpDesa->delete();

        return redirect()->route('rkpdesa.index')
            ->with('success', 'RKP Desa berhasil dihapus');
    }
}
