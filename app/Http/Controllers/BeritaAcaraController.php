<?php

namespace App\Http\Controllers;

use App\Models\BeritaAcara;
use App\Models\PesertaBeritaAcara;
use App\Models\AbsensiBeritaAcara;
use App\Models\Tahun;
use App\Models\Dusun;
use App\Models\Pegawai;
use App\Models\User;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        $activeTahun = Tahun::where('status', 'Aktif')->first();
        $dusun = Dusun::all();
        $pegawai = Pegawai::all();

        $userDusunId = null;
        if (session('user_role') == 'operator_dusun' && session('dusun_id')) {
             $userDusunId = session('dusun_id');
        }

        return view('admin.berita-acara.create', compact('jenis', 'tahun', 'activeTahun', 'dusun', 'pegawai', 'userDusunId'));
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
            'absensi_nama.*' => 'nullable|string',
            'absensi_alamat.*' => 'nullable|string',
            'absensi_unsur.*' => 'nullable|string',
        ]);

        // Generate 'hari' automatically from 'tanggal'
        $validated['hari'] = \Carbon\Carbon::parse($validated['tanggal'])->translatedFormat('l');

        DB::beginTransaction();
        try {
            // Create Berita Acara
            $beritaAcara = BeritaAcara::create([
                'id_tahun' => $validated['id_tahun'],
                'id_dusun' => $validated['id_dusun'],
                'jenis' => $validated['jenis'],
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
                    if ($nama) {
                        PesertaBeritaAcara::create([
                            'id_berita' => $beritaAcara->id_berita,
                            'nama' => $nama,
                            'alamat' => $request->peserta_alamat[$key] ?? null,
                            'jabatan' => $request->peserta_jabatan[$key] ?? 'Peserta',
                        ]);
                    }
                }
            }

            // Save Absensi
            if ($request->has('absensi_nama')) {
                foreach ($request->absensi_nama as $key => $nama) {
                    if ($nama) {
                        AbsensiBeritaAcara::create([
                            'id_berita' => $beritaAcara->id_berita,
                            'nama' => $nama,
                            'alamat' => $request->absensi_alamat[$key] ?? null,
                            'unsur' => $request->absensi_unsur[$key] ?? null,
                        ]);
                    }
                }
            }

            DB::commit();

            $currentUser = \App\Models\User::find(session('user_id'));
            $userName = $currentUser ? $currentUser->nama : 'Sistem';
            $allUsersIds = \App\Models\User::pluck('id_user')->implode(',');

            \App\Models\Notifikasi::create([
                'judul' => 'Berita Acara Baru',
                'jenis' => 'beritaacara',
                'deskripsi' => 'Berita Acara ' . $validated['jenis'] . ' baru telah dibuat oleh ' . $userName . '.',
                'id_kegiatan' => 'beritaacara_' . $beritaAcara->id_berita,
                'judul_kegiatan' => 'Berita Acara ' . $validated['jenis'],
                'status' => 'info',
                'id_penerima' => $allUsersIds,
                'dibaca' => 0
            ]);

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
        $beritaAcara = BeritaAcara::with(['peserta', 'absensi'])->findOrFail($id);
        
        // Permission Check
        if (!$this->checkPermission($beritaAcara->jenis)) {
            return redirect()->route('berita-acara.index')->with('error', 'Anda tidak memiliki hak akses untuk mengedit data ini.');
        }

        $tahun = Tahun::all();
        $activeTahun = Tahun::where('status', 'Aktif')->first();
        $dusun = Dusun::all();
        $pegawai = Pegawai::all();

        $userDusunId = null;
        if (session('user_role') == 'operator_dusun' && session('dusun_id')) {
             $userDusunId = session('dusun_id');
        }

        return view('admin.berita-acara.edit', compact('beritaAcara', 'tahun', 'activeTahun', 'dusun', 'pegawai', 'userDusunId'));
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
            'peserta_alamat.*' => 'nullable|string',
            'peserta_jabatan.*' => 'nullable|string',
            'absensi_nama.*' => 'nullable|string',
            'absensi_alamat.*' => 'nullable|string',
            'absensi_unsur.*' => 'nullable|string',
        ]);

        // Generate 'hari' automatically from 'tanggal'
        $validated['hari'] = \Carbon\Carbon::parse($validated['tanggal'])->translatedFormat('l');
        
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



        DB::beginTransaction();
        try {
            $original = $beritaAcara->getOriginal();
            // Update berita acara basic info
            $beritaAcara->update($validated);
            $changes = $beritaAcara->getChanges();

            $currentUser = \App\Models\User::find(session('user_id'));
            $userName = $currentUser ? $currentUser->nama : 'Sistem';

            $deskripsiEdit = 'Data Berita Acara ' . $beritaAcara->jenis . ' diperbarui.';
            $changeDetails = [];
            foreach ($changes as $key => $value) {
                if ($key == 'updated_at' || $key == 'created_at') continue;
                if (array_key_exists($key, $original)) {
                    $oldValue = $original[$key];
                    $changeDetails[] = "bagian {$key} dirubah dari '{$oldValue}' menjadi '{$value}'";
                }
            }
            if (count($changeDetails) > 0) {
                $deskripsiEdit .= ' ' . implode(', ', $changeDetails) . ' oleh ' . $userName . '.';
            }

            $allUsersIds = \App\Models\User::pluck('id_user')->implode(',');

            \App\Models\Notifikasi::create([
                'judul' => 'Berita Acara Diedit',
                'jenis' => 'beritaacara',
                'deskripsi' => $deskripsiEdit,
                'id_kegiatan' => 'beritaacara_' . $beritaAcara->id_berita,
                'judul_kegiatan' => 'Berita Acara ' . $beritaAcara->jenis,
                'status' => 'info',
                'id_penerima' => $allUsersIds,
                'dibaca' => 0
            ]);

            // Update Participants (Wakil TTD) - Delete and Recreate
            PesertaBeritaAcara::where('id_berita', $beritaAcara->id_berita)->delete();
            if ($request->has('peserta_nama')) {
                foreach ($request->peserta_nama as $key => $nama) {
                    if ($nama) {
                        PesertaBeritaAcara::create([
                            'id_berita' => $beritaAcara->id_berita,
                            'nama' => $nama,
                            'alamat' => $request->peserta_alamat[$key] ?? null,
                            'jabatan' => $request->peserta_jabatan[$key] ?? 'Peserta',
                        ]);
                    }
                }
            }

            // Update Absensi (Daftar Hadir) - Delete and Recreate
            AbsensiBeritaAcara::where('id_berita', $beritaAcara->id_berita)->delete();
            if ($request->has('absensi_nama')) {
                foreach ($request->absensi_nama as $key => $nama) {
                    if ($nama) {
                        AbsensiBeritaAcara::create([
                            'id_berita' => $beritaAcara->id_berita,
                            'nama' => $nama,
                            'alamat' => $request->absensi_alamat[$key] ?? null,
                            'unsur' => $request->absensi_unsur[$key] ?? null,
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('berita-acara.index', ['jenis' => $beritaAcara->jenis])
                ->with('success', 'Berita Acara berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Gagal mengubah Berita Acara: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $beritaAcara = BeritaAcara::findOrFail($id);
        
        // Permission Check
        if (!$this->checkPermission($beritaAcara->jenis)) {
            return redirect()->route('berita-acara.index')->with('error', 'Anda tidak memiliki hak akses untuk menghapus data ini.');
        }

        $currentUser = \App\Models\User::find(session('user_id'));
        $userName = $currentUser ? $currentUser->nama : 'Sistem';
        $allUsersIds = \App\Models\User::pluck('id_user')->implode(',');

        \App\Models\Notifikasi::create([
            'judul' => 'Berita Acara Dihapus',
            'jenis' => 'beritaacara',
            'deskripsi' => 'Berita Acara ' . $beritaAcara->jenis . ' telah dihapus oleh ' . $userName . '.',
            'id_kegiatan' => 'beritaacara_' . $beritaAcara->id_berita,
            'judul_kegiatan' => 'Berita Acara ' . $beritaAcara->jenis,
            'status' => 'danger',
            'id_penerima' => $allUsersIds,
            'dibaca' => 0
        ]);

        $beritaAcara->delete();

        return redirect()->route('berita-acara.index')
            ->with('success', 'Berita Acara berhasil dihapus');
    }
    /**
     * Print the specified resource (Cetak PDF)
     */
    public function print($id)
    {
        $beritaAcara = BeritaAcara::with(['dusun', 'tahun', 'peserta', 'absensi'])->findOrFail($id);
        
        $judul = match($beritaAcara->jenis) {
            'Musdus'     => 'Musyawarah ' . ($beritaAcara->dusun->nama ?? ''),
            'Musrenbang' => 'Musyawarah Perencanaan Pembangunan Desa',
            'BPD'        => 'Musyawarah Desa',
            default      => 'Musyawarah',
        };

        $kades = \App\Models\Pegawai::where('posisi', 'Kepala Desa')->first();
        $userBpd = \App\Models\User::where('role', 'bpd')->first();

        return view('admin.berita-acara.print', compact('beritaAcara', 'judul', 'kades', 'userBpd'));
    }

    /**
     * Upload signed PDF for Berita Acara
     */
    public function uploadPdf(Request $request, $id)
    {
        $beritaAcara = BeritaAcara::findOrFail($id);

        // Permission Check
        if (!$this->checkPermission($beritaAcara->jenis)) {
            return redirect()->route('berita-acara.index')->with('error', 'Anda tidak memiliki hak akses untuk mengunggah PDF ini.');
        }

        $request->validate([
            'file_pdf' => 'required|mimes:pdf|max:5120', // 5MB max
        ]);

        try {
            if ($request->hasFile('file_pdf')) {
                // Return existing file if any?
                // Logic to delete old file could be added here if needed to avoid storage bloat.
                if ($beritaAcara->file_pdf && file_exists(public_path($beritaAcara->file_pdf))) {
                     unlink(public_path($beritaAcara->file_pdf));
                }

                $file = $request->file('file_pdf');
                $filename = time() . '_' . $file->getClientOriginalName();
                $destinationPath = public_path('/uploads/berita_acara');
                $file->move($destinationPath, $filename);
                
                $beritaAcara->update([
                    'file_pdf' => '/uploads/berita_acara/' . $filename
                ]);

                $allUsersIds = \App\Models\User::pluck('id_user')->implode(',');
                
                \App\Models\Notifikasi::create([
                    'judul' => 'Berita Acara Diunggah',
                    'jenis' => 'beritaacara',
                    'deskripsi' => 'File PDF Berita Acara ' . $beritaAcara->jenis . ' berhasil diunggah dan bisa diakses.',
                    'id_kegiatan' => 'beritaacara_' . $beritaAcara->id_berita,
                    'judul_kegiatan' => 'Berita Acara ' . $beritaAcara->jenis,
                    'status' => 'info',
                    'id_penerima' => $allUsersIds,
                    'dibaca' => 0
                ]);

                return redirect()->back()->with('success', 'File PDF berhasil diunggah.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengunggah file: ' . $e->getMessage());
        }

        return redirect()->back()->with('error', 'Tidak ada file yang diunggah.');
    }

}

