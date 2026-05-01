<?php

namespace App\Http\Controllers;

use App\Models\BeritaAcara;
use App\Models\RKPDesa;
use App\Models\RPJM;
use App\Models\Usulan;
use Illuminate\Http\Request;

class PemulihanController extends Controller
{
    /**
     * Display a listing of the trashed resources.
     */
    public function index()
    {
        $trashedRpjm = RPJM::onlyTrashed()->get();
        $trashedUsulan = Usulan::onlyTrashed()->get();
        $trashedRkpdesa = RKPDesa::onlyTrashed()->get();
        $trashedBeritaAcara = BeritaAcara::onlyTrashed()->get();

        return view('admin.pemulihan.index', compact('trashedRpjm', 'trashedUsulan', 'trashedRkpdesa', 'trashedBeritaAcara'));
    }

    /**
     * Restore the specified resource from trash.
     */
    public function restore(Request $request)
    {
        $request->validate([
            'model' => 'required|in:rpjm,usulan,rkpdesa,beritaacara',
            'ids' => 'required|array',
            'ids.*' => 'string' // Some IDs are string/uuid or int
        ]);

        $modelType = $request->model;
        $ids = $request->ids;

        switch ($modelType) {
            case 'rpjm':
                RPJM::withTrashed()->whereIn('id_rpjm', $ids)->restore();
                break;
            case 'usulan':
                Usulan::withTrashed()->whereIn('id_usulan', $ids)->restore();
                break;
            case 'rkpdesa':
                RKPDesa::withTrashed()->whereIn('id_kegiatan', $ids)->restore();
                break;
            case 'beritaacara':
                BeritaAcara::withTrashed()->whereIn('id_ba', $ids)->restore();
                break;
        }

        return redirect()->back()->with('success', count($ids) . ' data berhasil dipulihkan.');
    }

    /**
     * Permanently delete the specified resource from trash.
     */
    public function forceDelete(Request $request)
    {
        $request->validate([
            'model' => 'required|in:rpjm,usulan,rkpdesa,beritaacara',
            'ids' => 'required|array',
            'ids.*' => 'string'
        ]);

        $modelType = $request->model;
        $ids = $request->ids;

        switch ($modelType) {
            case 'rpjm':
                RPJM::withTrashed()->whereIn('id_rpjm', $ids)->forceDelete();
                break;
            case 'usulan':
                Usulan::withTrashed()->whereIn('id_usulan', $ids)->forceDelete();
                break;
            case 'rkpdesa':
                RKPDesa::withTrashed()->whereIn('id_kegiatan', $ids)->forceDelete();
                break;
            case 'beritaacara':
                BeritaAcara::withTrashed()->whereIn('id_ba', $ids)->forceDelete();
                break;
        }

        return redirect()->back()->with('success', count($ids) . ' data berhasil dihapus permanen.');
    }
}
