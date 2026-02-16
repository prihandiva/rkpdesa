<?php

namespace App\Http\Controllers;

use App\Models\RKPDesa;
use Illuminate\Http\Request;

class RKPController extends Controller
{
    protected $statusService;

    public function __construct(\App\Services\StatusService $statusService)
    {
        $this->statusService = $statusService;
    }

    /**
     * Display a listing of the resource (Index)
     * Menampilkan daftar semua RKP Desa
     */
    public function index(Request $request)
    {
        $query = RKPDesa::query();

        // Filter by Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by Jenis (Fisik / Non Fisik)
        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        // Filter for BPD Role
        if (session('user_role') == 'bpd') {
            $tahunAktif = \App\Models\Tahun::where('status', 'Aktif')->value('tahun');
            if ($tahunAktif) {
                $query->where('tahun', $tahunAktif);
            }
            $query->whereIn('status', ['Menunggu persetujuan BPD', 'Disetujui', 'Ditolak BPD']);
        }

        // Sorting
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'prioritas_desc':
                    $query->orderBy('prioritas', 'desc');
                    break;
                case 'prioritas_asc':
                    $query->orderBy('prioritas', 'asc');
                    break;
                case 'terbaru':
                default:
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $rkp_desa = $query->paginate(10)->appends($request->all());
        
        return view('admin.rkpdesa.index', compact('rkp_desa'));
    }

    /**
     * Show the form for creating a new resource (Create Form)
     * Menampilkan form untuk membuat RKP Desa baru
     */
    public function create()
    {
        $tahuns = \App\Models\Tahun::where('status', 'aktif')->get();
        $rpjms = \App\Models\RPJM::all(); 
        $usulans = \App\Models\Usulan::where('status', 'Disetujui')->orWhere('status', 'Pending')->get(); // Show approved usulans to be picked? Or pending? Usually Approved Usulan -> RKP. But user mentioned "Proses" -> "Pending". Let's show all relevant.
        // Reverting to user requirement: Pending (kuning) -> masuk ke rkpdesa.
        // So maybe show 'Pending' usulans here.
        $bidangs = \App\Models\Bidang::all();
        $sumber_biayas = \App\Models\SumberBiaya::all();
        $pola_pelaksanaans = \App\Models\PolaPelaksanaan::all();

        // Existing Priorities for Frontend Validation (RKP needs strict priority per Bidang too?)
        // Assuming per Bidang as per user request context.
        $existingPriorities = RKPDesa::select('bidang', 'prioritas')->whereNotNull('prioritas')->get()->groupBy('bidang')->map(function ($items) {
            return $items->pluck('prioritas')->toArray();
        });

        return view('admin.rkpdesa.create', compact('tahuns', 'rpjms', 'usulans', 'bidangs', 'sumber_biayas', 'pola_pelaksanaans', 'existingPriorities'));
    }

    /**
     * Store a newly created resource in storage (Store)
     * Menyimpan data RKP Desa baru ke database
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'bidang' => 'required|exists:bidang,id_bidang',
            'jenis_kegiatan' => 'required|string|max:255',
            'jenis' => 'nullable|string',
            'data_existing' => 'nullable|string',
            'target_capaian' => 'nullable|string',
            'lokasi' => 'nullable|string',
            'volume' => 'nullable|string',
            'penerima' => 'nullable|string',
            'waktu' => 'nullable|string',
            'jumlah' => 'nullable|numeric',
            'sumber_biaya' => 'required|exists:sumber_biaya,id_biaya',
            'pola_pelaksanaan' => 'required|exists:pola_pelaksanaan,id_pelaksanaan',
            'status' => 'required|string', // Validation for new status strings
            'tahun' => 'required|exists:tahun,tahun',
            'id_rpjm' => 'nullable|exists:rpjm,id_rpjm',
            'id_usulan' => 'nullable|exists:usulan,id_usulan',
            'file_berita_acara_musrenbang' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:5120',
            'file_berita_acara_musrenbang' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:5120',
            'catatan_verifikasi' => 'nullable|string',
            'prioritas' => 'nullable|integer|min:1',
        ]);

        // Handle File Upload
        if ($request->hasFile('file_berita_acara_musrenbang')) {
            $file = $request->file('file_berita_acara_musrenbang');
            $filename = time() . '_musrenbang_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/rkp'), $filename);
            $validated['file_berita_acara_musrenbang'] = 'uploads/rkp/' . $filename;
        }

        // Simpan RKP Desa baru
        $rkpDesa = RKPDesa::create($validated);
        
        // Sync Status using Service (for standard status like Pending or manual choice)
        $this->statusService->updateStatus($rkpDesa, $validated['status']);

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
        $logs = \App\Models\Notifikasi::where('id_kegiatan', $id)
                    ->orderBy('created_at', 'desc')
                    ->get();
        
        // Fetch reference data for the edit form in show page
        $bidangs = \App\Models\Bidang::all();
        $sumber_biayas = \App\Models\SumberBiaya::all();
        $pola_pelaksanaans = \App\Models\PolaPelaksanaan::all();

        return view('admin.rkpdesa.show', compact('rkpDesa', 'logs', 'bidangs', 'sumber_biayas', 'pola_pelaksanaans'));
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
        $usulans = \App\Models\Usulan::all();
        $bidangs = \App\Models\Bidang::all();
        $sumber_biayas = \App\Models\SumberBiaya::all();
        $pola_pelaksanaans = \App\Models\PolaPelaksanaan::all();

        $existingPriorities = RKPDesa::select('bidang', 'prioritas')->whereNotNull('prioritas')->get()->groupBy('bidang')->map(function ($items) {
            return $items->pluck('prioritas')->toArray();
        });

        return view('admin.rkpdesa.edit', compact('rkpDesa', 'tahuns', 'rpjms', 'usulans', 'bidangs', 'sumber_biayas', 'pola_pelaksanaans', 'existingPriorities'));
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
            'bidang' => 'nullable|exists:bidang,id_bidang',
            'jenis_kegiatan' => 'required|string|max:255',
            'jenis' => 'nullable|string',
            'data_existing' => 'nullable|string',
            'target_capaian' => 'nullable|string',
            'lokasi' => 'nullable|string',
            'volume' => 'nullable|string',
            'penerima' => 'nullable|string',
            'waktu' => 'nullable|string',
            'jumlah' => 'nullable|numeric',
            'sumber_biaya' => 'nullable|exists:sumber_biaya,id_biaya',
            'pola_pelaksanaan' => 'nullable|exists:pola_pelaksanaan,id_pelaksanaan',
            'status' => 'required|string',
            'tahun' => 'sometimes|required',
            'id_rpjm' => 'nullable|exists:rpjm,id_rpjm',
            'id_usulan' => 'nullable|exists:usulan,id_usulan',
            'file_berita_acara_musrenbang' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:5120',
            'catatan_verifikasi' => 'nullable|string',
            'prioritas' => 'nullable|integer|min:1',
        ]);

        // Handle File Upload
        if ($request->hasFile('file_berita_acara_musrenbang')) {
            $file = $request->file('file_berita_acara_musrenbang');
            $filename = time() . '_musrenbang_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/rkp'), $filename);
            $validated['file_berita_acara_musrenbang'] = 'uploads/rkp/' . $filename;
        }

        // Check if status changed
        $oldStatus = $rkpDesa->status;
        $newStatus = $validated['status'];

        // Update RKP Desa (excluding status first if we want service to handle it, but service updates it too. Safe to just update all)
        $rkpDesa->update($validated);

        // Status Update via Service if changed
        if ($oldStatus !== $newStatus) {
            $this->statusService->updateStatus($rkpDesa, $newStatus);
        }

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
                
                // Create RKP Desa
                $rkp = RKPDesa::create([
                    'jenis_kegiatan' => $usulan->jenis_kegiatan,
                    'jenis' => $usulan->jenis,
                    'bidang' => null, 
                    'id_usulan' => $usulan->id_usulan,
                    'id_rpjm' => null, 
                    'tahun' => $usulan->tahun,
                    'status' => "Pending", // Default 
                    'sumber_biaya' => null, 
                    'pola_pelaksanaan' => null,
                    'catatan_verifikasi' => null,
                ]);

                // Update Status Usulan & Sync via Service
                // If we set RKP to Pending, we should sync Usulan to Pending too.
                $this->statusService->updateStatus($rkp, 'Pending');

                $count++;
            }
        }

        return redirect()->route('usulan.index')
            ->with('success', $count . ' Usulan berhasil dimasukkan ke RKP Desa (Status: Pending)');
    }

    /**
     * Store RKP Desa from RPJM (Bulk Action)
     * Memindahkan data RPJM terpilih ke tabel RKP Desa
     */
    public function storeFromRpjm(Request $request)
    {
        $request->validate([
            'id_rpjm' => 'required|array',
            'id_rpjm.*' => 'exists:rpjm,id_rpjm',
        ]);

        $ids = $request->id_rpjm;
        $count = 0;
        
        // Get Active Tahun
        $tahunAktif = \App\Models\Tahun::where('status', 'Aktif')->value('tahun') ?? date('Y');

        foreach ($ids as $id) {
            $rpjm = \App\Models\RPJM::find($id);
            if ($rpjm) {
                
                // Check if already in RKP?
                // Probably not strictly required, but usually we don't want duplicates for same year.
                // But RKP table doesn't enforce unique constraints strongly yet.
                
                $rkp = RKPDesa::create([
                    'jenis_kegiatan' => $rpjm->jenis_kegiatan,
                    'jenis' => $rpjm->jenis,
                    'bidang' => $rpjm->bidang,
                    'id_usulan' => null,
                    'id_rpjm' => $rpjm->id_rpjm, 
                    'tahun' => $tahunAktif,
                    'status' => "Pending",
                    'sumber_biaya' => $rpjm->sumber_biaya, 
                    'pola_pelaksanaan' => $rpjm->pola_pelaksanaan,
                    'lokasi' => $rpjm->lokasi,
                    'volume' => $rpjm->volume,
                    'penerima' => $rpjm->sasaran,
                    'waktu' => $rpjm->waktu,
                    'jumlah' => $rpjm->jumlah,
                    'catatan_verifikasi' => $rpjm->catatan_verifikasi,
                    'prioritas' => null,
                ]);

                // Update Status RPJM to Pending (kuning) as it's now in RKP
                $rpjm->update(['status' => 'Pending']);

                // Status Service update for RKP if needed
                $this->statusService->updateStatus($rkp, 'Pending');

                $count++;
            }
        }

        return redirect()->route('rpjm.index')
            ->with('success', $count . ' Item RPJM berhasil dimasukkan ke RKP Desa (Status: Pending)');
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

    /**
     * Update Prioritas Only
     */
    public function updatePrioritas(Request $request, $id)
    {
        $rkpDesa = RKPDesa::findOrFail($id);

        $validated = $request->validate([
            'prioritas' => 'nullable|integer|min:1',
        ]);

        $rkpDesa->update(['prioritas' => $validated['prioritas']]);

        return redirect()->back()->with('success', 'Prioritas RKP Desa berhasil diperbarui');
    }

    /**
     * Update Status Only (Verification / Approval)
     */
    public function updateStatus(Request $request, $id)
    {
        $rkpDesa = RKPDesa::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|string',
            'catatan_verifikasi' => 'nullable|string',
        ]);

        $oldStatus = $rkpDesa->status;
        $newStatus = $validated['status'];

        // Update Status & Notes
        $rkpDesa->status = $newStatus;
        if ($request->has('catatan_verifikasi')) {
            $rkpDesa->catatan_verifikasi = $validated['catatan_verifikasi'];
        }
        $rkpDesa->save();

        // Sync Status using Service if changed
        if ($oldStatus !== $newStatus) {
            $this->statusService->updateStatus($rkpDesa, $newStatus);
        }
        
        // Log Notification
        $action = 'Diperbarui';
        if (str_contains($newStatus, 'Verifikasi') || $newStatus == 'Terverifikasi' || $newStatus == 'Gagal Terverifikasi') {
            $action = 'Diverifikasi';
        } elseif ($newStatus == 'Disetujui' || $newStatus == 'Ditolak BPD') {
            $action = 'Keputusan BPD';
        }

        \App\Models\Notifikasi::create([
            'judul' => 'Status RKP: ' . $newStatus,
            'deskripsi' => 'Status berubah menjadi ' . $newStatus . ($request->catatan_verifikasi ? '. Catatan: ' . $request->catatan_verifikasi : ''),
            'id_kegiatan' => 'rkpdesa_' . $rkpDesa->id_kegiatan, // Assuming format
            'judul_kegiatan' => $rkpDesa->jenis_kegiatan,
            'status' => 'info',
            'id_penerima' => null, // Broadcast
            'dibaca' => 0
        ]);

        return redirect()->back()->with('success', 'Status RKP Desa berhasil diperbarui: ' . $newStatus);
    }

    /**
     * Submit Selected RKP Desa to BPD Approval
     */
    public function submitToBPD(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:rkpdesa,id_kegiatan',
        ]);

        $ids = $request->ids;
        $items = RKPDesa::whereIn('id_kegiatan', $ids)->get();

        if ($items->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada data yang dipilih.');
        }

        // Check for Incomplete Items & Status Eligibility
        $incompleteItems = [];
        $invalidStatusItems = [];

        foreach ($items as $item) {
            // Check Status - User said only "Terverifikasi" can be submitted
            if ($item->status !== 'Terverifikasi') {
                $invalidStatusItems[] = $item->jenis_kegiatan . ' (Status: ' . $item->status . ')';
                continue; 
            }

            // Check Completeness
            if (!$item->isComplete()) {
                $incompleteItems[] = $item->jenis_kegiatan;
            }
        }

        if (count($invalidStatusItems) > 0) {
            $list = implode(', ', $invalidStatusItems);
            return redirect()->back()->with('error', 'Pengajuan Gagal! Item berikut statusnya bukan Terverifikasi: ' . $list);
        }

        if (count($incompleteItems) > 0) {
            $list = implode(', ', $incompleteItems);
            return redirect()->back()->with('error', 'Pengajuan Gagal! Data berikut belum lengkap: ' . $list);
        }

        // If All Valid, Update Status
        $count = 0;
        foreach ($items as $item) {
             $this->statusService->updateStatus($item, 'Menunggu persetujuan BPD');
             $count++;
        }

        return redirect()->back()->with('success', $count . ' data RKP Desa berhasil diajukan untuk persetujuan BPD.');
    }
}
