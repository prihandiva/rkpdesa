<?php

namespace App\Http\Controllers;

use App\Models\RPJM;
use App\Models\Bidang;
use App\Models\SumberBiaya;
use App\Models\PolaPelaksanaan;
use App\Models\Notifikasi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class RPJMController extends Controller
{
    /**
     * Display a listing of the resource (Index)
     */
    public function index()
    {
        $userId = session('user_id');
        $currentUser = User::find($userId);

        if (!$currentUser) {
            return redirect()->route('admin.login')->with('error', 'Sesi anda berakhir.');
        }

        // Fetch Bidang with RPJM relation, filtered by periode if requested
        $periode = request('periode');

        $bidangs = Bidang::with(['rpjm' => function($query) use ($periode) {
            if ($periode) {
                $query->where('periode', $periode);
            }
            $query->orderBy('created_at', 'desc');
        }])->get();

        // Get unique periods for the filter dropdown
        $periodes = RPJM::whereNotNull('periode')->distinct()->pluck('periode');

        return view('admin.rpjm.index', compact('bidangs', 'periodes', 'currentUser', 'periode'));
    }

    /**
     * Show the form for creating a new resource (Create Form)
     */
    public function create()
    {
        $userId = session('user_id');
        $currentUser = User::find($userId);

        if (!$currentUser) {
            return redirect()->route('admin.login')->with('error', 'Sesi anda berakhir.');
        }

        // Access Control: Only Operator Desa
        if ($currentUser->role != 'operator_desa' && $currentUser->role != 'admin') {
             return redirect()->route('rpjm.index')->with('error', 'Hanya Operator Desa yang dapat menambah RPJM.');
        }

        $bidangs = Bidang::all();
        $sumber_biayas = SumberBiaya::all();
        $pola_pelaksanaans = PolaPelaksanaan::all();
        
        // Drafts (Status = Proses for RPJM upon creation)
        $draftRpjms = RPJM::where('status', 'Proses')->orderBy('created_at', 'desc')->get();

        // Existing Priorities for Frontend Validation
        $existingPriorities = RPJM::select('bidang', 'prioritas')->whereNotNull('prioritas')->get()->groupBy('bidang')->map(function ($items) {
            return $items->pluck('prioritas')->toArray();
        });

        return view('admin.rpjm.create', compact('bidangs', 'sumber_biayas', 'pola_pelaksanaans', 'currentUser', 'draftRpjms', 'existingPriorities'));
    }

    /**
     * Store a newly created resource in storage (Store)
     */
    public function store(Request $request)
    {
        if (!session('user_authenticated')) {
             return redirect()->route('admin.login');
        }

        $validated = $request->validate([
            'bidang' => 'required|exists:bidang,id_bidang',
            'subbidang' => 'required|string',
            'jenis_kegiatan' => 'required|string',
            'jenis' => 'required|string',
            'periode_mulai' => 'required|numeric',
            'periode_selesai' => 'required|numeric',
            'lokasi' => 'required|string',
            'volume' => 'required|string',
            'sasaran' => 'required|string',
            'waktu' => 'nullable|string',
            'jumlah' => 'required|numeric',
            'tahun_pelaksanaan' => 'required|string',
            'sumber_biaya' => 'required|array', 
            'sumber_biaya.*' => 'exists:sumber_biaya,id_biaya',
            'pola_pelaksanaan' => 'required|exists:pola_pelaksanaan,id_pelaksanaan',
            'prioritas' => [
                'nullable',
                'integer',
                Rule::unique('rpjm')->where(function ($query) use ($request) {
                    return $query->where('bidang', $request->bidang);
                }),
            ], 
        ]);

        $validated['periode'] = $request->periode_mulai . ' sd ' . $request->periode_selesai;
        unset($validated['periode_mulai'], $validated['periode_selesai']);

        $validated['status'] = 'Proses'; 
        
        $rpjm = RPJM::create($validated);

        $allUsersIds = \App\Models\User::pluck('id_user')->implode(',');

        Notifikasi::create([
            'judul' => 'Input RPJM Baru',
            'jenis' => 'rpjm',
            'deskripsi' => 'Item RPJM baru: ' . substr($validated['jenis_kegiatan'], 0, 50),
            'id_kegiatan' => 'rpjm_' . $rpjm->id_rpjm,
            'judul_kegiatan' => $validated['jenis_kegiatan'],
            'status' => 'info',
            'id_penerima' => $allUsersIds,
            'dibaca' => 0
        ]);

        return redirect()->back()
            ->with('success', 'Item RPJM berhasil ditambahkan. Silakan input berikutnya.');
    }

    /**
     * Display the specified resource (Show/View)
     */
    public function show($id)
    {
        $userId = session('user_id');
        $currentUser = User::find($userId);
        
        $rpjm = RPJM::with(['masterBidang', 'masterPola'])->findOrFail($id);
        $logs = Notifikasi::where('id_kegiatan', 'rpjm_' . $id)->orderBy('created_at', 'desc')->get();
        return view('admin.rpjm.show', compact('rpjm', 'logs', 'currentUser'));
    }

    /**
     * Show the form for editing the specified resource (Edit Form)
     */
    public function edit($id)
    {
        $rpjm = RPJM::findOrFail($id);
        $bidangs = Bidang::all();
        $sumber_biayas = SumberBiaya::all();
        $pola_pelaksanaans = PolaPelaksanaan::all();
        
        // Existing Priorities for Frontend Validation
        $existingPriorities = RPJM::select('bidang', 'prioritas')->whereNotNull('prioritas')->get()->groupBy('bidang')->map(function ($items) {
            return $items->pluck('prioritas')->toArray();
        });

        return view('admin.rpjm.edit', compact('rpjm', 'bidangs', 'sumber_biayas', 'pola_pelaksanaans', 'existingPriorities'));
    }

    /**
     * Update the specified resource in storage (Update)
     */
    public function update(Request $request, $id)
    {
        $rpjm = RPJM::findOrFail($id);

        $validated = $request->validate([
            'bidang' => 'required|exists:bidang,id_bidang',
            'subbidang' => 'required|string',
            'jenis_kegiatan' => 'required|string',
            'jenis' => 'required|string',
            'periode_mulai' => 'required|numeric',
            'periode_selesai' => 'required|numeric',
            'lokasi' => 'required|string',
            'volume' => 'required|string',
            'sasaran' => 'required|string',
            'waktu' => 'nullable|string',
            'jumlah' => 'required|numeric',
            'tahun_pelaksanaan' => 'required|string',
            'sumber_biaya' => 'required|array',
            'sumber_biaya.*' => 'exists:sumber_biaya,id_biaya',
            'pola_pelaksanaan' => 'required|exists:pola_pelaksanaan,id_pelaksanaan',
            'prioritas' => [
                'nullable',
                'integer',
                Rule::unique('rpjm')->ignore($rpjm->id_rpjm, 'id_rpjm')->where(function ($query) use ($request) {
                    return $query->where('bidang', $request->bidang);
                }),
            ],
            'status' => 'sometimes|string',
        ]);

        $validated['periode'] = $request->periode_mulai . ' sd ' . $request->periode_selesai;
        unset($validated['periode_mulai'], $validated['periode_selesai']);

        $original = $rpjm->getOriginal();

        $rpjm->update($validated);
        $changes = $rpjm->getChanges();

        $currentUser = User::find(session('user_id'));
        $userName = $currentUser ? $currentUser->nama : 'Sistem';

        $deskripsiEdit = 'Data RPJM diperbarui: ' . substr($rpjm->jenis_kegiatan, 0, 50) . '.';
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

        Notifikasi::create([
            'judul' => 'RPJM Diedit',
            'jenis' => 'rpjm',
            'deskripsi' => $deskripsiEdit,
            'id_kegiatan' => 'rpjm_' . $rpjm->id_rpjm,
            'judul_kegiatan' => $rpjm->jenis_kegiatan,
            'status' => 'info',
            'id_penerima' => $allUsersIds,
            'dibaca' => 0
        ]);

        return redirect()->route('rpjm.index')->with('success', 'RPJM berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage (Delete)
     */
    public function destroy($id)
    {
        $rpjm = RPJM::findOrFail($id);
        
        $allUsersIds = \App\Models\User::pluck('id_user')->implode(',');

        Notifikasi::create([
            'judul' => 'RPJM Dihapus',
            'jenis' => 'rpjm',
            'deskripsi' => 'Item RPJM dihapus: ' . $rpjm->jenis_kegiatan,
            'id_kegiatan' => 'rpjm_' . $rpjm->id_rpjm,
            'judul_kegiatan' => $rpjm->jenis_kegiatan,
            'status' => 'danger',
            'id_penerima' => $allUsersIds,
            'dibaca' => 0
        ]);

        $rpjm->delete();

        return redirect()->route('rpjm.index')->with('success', 'RPJM berhasil dihapus');
    }

    /**
     * Update Prioritas Only
     */
    public function updatePrioritas(Request $request, $id)
    {
        $rpjm = RPJM::findOrFail($id);

        $validated = $request->validate([
            'prioritas' => [
                'nullable',
                'integer',
                // Unique priority per bidang check
                Rule::unique('rpjm')->ignore($rpjm->id_rpjm, 'id_rpjm')->where(function ($query) use ($rpjm) {
                    return $query->where('bidang', $rpjm->bidang);
                }),
            ],
        ]);

        $rpjm->update(['prioritas' => $validated['prioritas']]);

        return redirect()->back()->with('success', 'Prioritas berhasil diperbarui');
    }

    /**
     * Export RPJM to Excel
     */
    public function exportExcel(Request $request)
    {
        $periode = $request->get('periode');
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\RPJMExport($periode), 'RPJM_Desa.xlsx');
    }
}
