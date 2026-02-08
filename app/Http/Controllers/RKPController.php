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
    public function index()
    {
        // $rkp_desa = RKPDesa::all();
        $rkp_desa = RKPDesa::orderBy('created_at', 'desc')->paginate(10);
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
            'status' => 'required|string', // Validation for new status strings
            'tahun' => 'required|exists:tahun,id_tahun',
            'id_rpjm' => 'nullable|exists:rpjm,id_rpjm',
            'id_usulan' => 'nullable|exists:usulan,id_usulan',
            'file_berita_acara_musrenbang' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:5120',
            'file_berita_acara_musrenbang' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:5120',
            'catatan_verifikasi' => 'nullable|string',
            'prioritas' => 'nullable|integer|between:1,5',
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
        
        // Sync Status using Service
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
            'nama' => 'sometimes|required|string|max:255',
            'bidang' => 'nullable|exists:bidang,id_bidang',
            'jenis_kegiatan' => 'sometimes|required|string',
            'data_existing' => 'nullable|string',
            'target_capaian' => 'nullable|string',
            'lokasi' => 'nullable|string',
            'volume' => 'nullable|string',
            'penerima' => 'nullable|string',
            'waktu' => 'nullable|string',
            'jumlah' => 'nullable|numeric',
            'sumber_biaya' => 'nullable|exists:sumber_biaya,id_sumber_biaya',
            'pola_pelaksanaan' => 'nullable|exists:pola_pelaksanaan,id_pola',
            'status' => 'required|string',
            'tahun' => 'sometimes|required|exists:tahun,id_tahun',
            'id_rpjm' => 'nullable|exists:rpjm,id_rpjm',
            'id_usulan' => 'nullable|exists:usulan,id_usulan',
            'file_berita_acara_musrenbang' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:5120',
            'file_berita_acara_musrenbang' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:5120',
            'catatan_verifikasi' => 'nullable|string',
            'prioritas' => 'nullable|integer|between:1,5',
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

        // Trigger Service if status changed (or even if same to ensure sync?)
        // Better to always sync if update is called
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
                    'nama' => $usulan->jenis_kegiatan,
                    'jenis_kegiatan' => $usulan->jenis_kegiatan,
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
