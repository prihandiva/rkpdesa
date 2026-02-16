<?php

namespace App\Http\Controllers;

use App\Models\BeritaAcara;
use App\Models\PesertaBeritaAcara;
use App\Models\Tahun;
use App\Models\Dusun;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BeritaAcaraController extends Controller
{
    /**
     * Display a listing of the resource (Index)
     * Menampilkan daftar semua berita acara
     */
    /**
     * Display a listing of the resource (Index)
     * Menampilkan daftar semua berita acara
     */
    public function index(Request $request)
    {
        $jenis = $request->query('jenis'); 
        
        $query = BeritaAcara::with(['dusun', 'tahun', 'pemimpinPegawai']);
        
        if ($jenis) {
            $query->where('jenis', $jenis);
        }

        $beritaAcaras = $query->latest()->paginate(10);
        
        return view('admin.berita-acara.index', compact('beritaAcaras', 'jenis'));
    }

    /**
     * Show the form for creating a new resource (Create Form)
     * Menampilkan form untuk membuat berita acara baru
     */
    /**
     * Helper to check permissions based on Berita Acara type and User Role
     */
    private function checkPermission($jenis)
    {
        $role = session('user_role');
        if ($role === 'admin') return true;

        switch ($jenis) {
            case 'Musdus':
                return $role === 'operator_dusun';
            case 'Musrenbang':
                return $role === 'operator_desa';
            case 'BPD':
                return $role === 'bpd';
            default:
                return false;
        }
    }

    public function create(Request $request)
    {
        $jenis = $request->query('jenis');
        
        // Enforce permission if kind is specified
        if ($jenis && !$this->checkPermission($jenis)) {
            return redirect()->route('berita-acara.index')->with('error', 'Anda tidak memiliki hak akses untuk membuat Berita Acara jenis ini.');
        }

        $tahun = Tahun::all(); 
        $dusun = Dusun::all();
        $pegawai = Pegawai::all();

        $userDusunId = null;
        if (session('user_role') == 'operator_dusun' && session('dusun_id')) {
             $userDusunId = session('dusun_id');
        }

        return view('admin.berita-acara.create', compact('jenis', 'tahun', 'dusun', 'pegawai', 'userDusunId'));
    }

    public function store(Request $request)
    {
        // Permission Check
        if (!$this->checkPermission($request->jenis)) {
            abort(403, 'Anda tidak memiliki hak akses untuk menambahkan Berita Acara ini.');
        }

        // Validasi input
        $validated = $request->validate([
            'id_tahun' => 'required|exists:tahun,id_tahun',
            'id_dusun' => 'nullable|exists:dusun,id_dusun', 
            'jenis' => 'required|in:Musdus,Musrenbang,BPD',
            'hari' => 'required|string',
            'tanggal' => 'required|date',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'tempat' => 'required|string',
            'materi' => 'required|string', 
            'putusan' => 'nullable|string', 
            'pemimpin' => 'required|string',
            'asal_pemimpin' => 'required|string',
            'nama_bpd' => 'nullable|string',
            'notulis1' => 'nullable|string',
            'asal_notulis1' => 'nullable|string',
            'notulis2' => 'nullable|string',
            'asal_notulis2' => 'nullable|string',
            'peserta_nama.*' => 'required|string',
            'peserta_alamat.*' => 'nullable|string',
            'peserta_jabatan.*' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            // Create Berita Acara
            $beritaAcara = BeritaAcara::create([
                'id_tahun' => $validated['id_tahun'],
                'id_dusun' => $validated['id_dusun'],
                'jenis' => $validated['jenis'],
                'hari' => $validated['hari'],
                'hari' => $validated['hari'],
                'tanggal' => $validated['tanggal'],
                'jam_mulai' => $validated['jam_mulai'],
                'jam_selesai' => $validated['jam_selesai'],
                'tempat' => $validated['tempat'],
                'materi' => $validated['materi'],
                'putusan' => $validated['putusan'] ?? null,
                'pemimpin' => $validated['pemimpin'],
                'asal_pemimpin' => $validated['asal_pemimpin'] ?? null, // Storing asal_pemimpin
                'nama_bpd' => $validated['jenis'] == 'BPD' ? $validated['nama_bpd'] : null,
                'notulis1' => $validated['notulis1'],
                'asal_notulis1' => $validated['asal_notulis1'] ?? null, // Storing asal_notulis1
                'notulis2' => $validated['notulis2'],
                'asal_notulis2' => $validated['asal_notulis2'] ?? null, // Storing asal_notulis2
            ]);

            // Save Participants
            if ($request->has('peserta_nama')) {
                foreach ($request->peserta_nama as $key => $nama) {
                    PesertaBeritaAcara::create([
                        'id_berita' => $beritaAcara->id_berita,
                        'nama' => $nama,
                        'alamat' => $request->peserta_alamat[$key] ?? null,
                        'jabatan' => $request->peserta_jabatan[$key] ?? 'Peserta',
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('berita-acara.index', ['jenis' => $validated['jenis']])
                ->with('success', 'Berita Acara berhasil ditambahkan');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan Berita Acara: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $beritaAcara = BeritaAcara::findOrFail($id);
        return view('admin.berita-acara.show', compact('beritaAcara'));
    }

    public function edit($id)
    {
        $beritaAcara = BeritaAcara::findOrFail($id);
        
        // Permission Check
        if (!$this->checkPermission($beritaAcara->jenis)) {
            return redirect()->route('berita-acara.index')->with('error', 'Anda tidak memiliki hak akses untuk mengedit data ini.');
        }

        return view('admin.berita-acara.edit', compact('beritaAcara'));
    }

    public function update(Request $request, $id)
    {
        $beritaAcara = BeritaAcara::findOrFail($id);

        // Permission Check
        if (!$this->checkPermission($beritaAcara->jenis)) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengubah data ini.');
        }
        
        // Ensure user cannot change 'jenis' to bypass permission, or just restrict it in validation/update
        // Typically 'jenis' should not change.
        
        // Validasi input
        $validated = $request->validate([
            'id_tahun' => 'required|exists:tahun,id_tahun',
            'id_dusun' => 'nullable|exists:dusun,id_dusun',
            'jenis' => 'required|in:Musdus,Musrenbang,BPD',
            'hari' => 'required|string',
            'tanggal' => 'required|date',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'tempat' => 'required|string',
            'materi' => 'required|string',
            'putusan' => 'nullable|string',
            'pemimpin' => 'required|string',
            'asal_pemimpin' => 'required|string',
            'nama_bpd' => 'nullable|string',
            'notulis1' => 'nullable|string',
            'asal_notulis1' => 'nullable|string',
            'notulis2' => 'nullable|string',
            'asal_notulis2' => 'nullable|string',
            'peserta_nama' => 'required|array|min:1',
            'peserta_nama.*' => 'required|string',
        ]);
        
        // Prevent changing jenis if unauthorized for target jenis? 
        // For simplicity, we assume jenis doesn't change or we strictly use existing one check.
        // If users CAN change jenis, we need to check permission for NEW jenis too.
        if ($validated['jenis'] !== $beritaAcara->jenis) {
             if (!$this->checkPermission($validated['jenis'])) {
                 abort(403, 'Anda tidak memiliki hak akses untuk mengubah ke jenis berita acara ini.');
             }
        }

        if ($validated['jenis'] !== 'BPD') {
            $validated['nama_bpd'] = null;
        }



        // Update berita acara
        $beritaAcara->update($validated);

        return redirect()->route('berita-acara.index')
            ->with('success', 'Berita Acara berhasil diperbarui');
    }

    public function destroy($id)
    {
        $beritaAcara = BeritaAcara::findOrFail($id);
        
        // Permission Check
        if (!$this->checkPermission($beritaAcara->jenis)) {
            return redirect()->route('berita-acara.index')->with('error', 'Anda tidak memiliki hak akses untuk menghapus data ini.');
        }

        $beritaAcara->delete();

        return redirect()->route('berita-acara.index')
            ->with('success', 'Berita Acara berhasil dihapus');
    }
    /**
     * Print the specified resource (Cetak PDF)
     */
    public function print($id)
    {
        $beritaAcara = BeritaAcara::with(['dusun', 'tahun', 'peserta'])->findOrFail($id);
        
        $judul = match($beritaAcara->jenis) {
            'Musdus' => 'MUSYAWARAH DUSUN',
            'Musrenbang' => 'MUSRENBANG DESA',
            'BPD' => 'MUSYAWARAH BPD',
            default => 'MUSYAWARAH',
        };

        return view('admin.berita-acara.print', compact('beritaAcara', 'judul'));
    }
}
