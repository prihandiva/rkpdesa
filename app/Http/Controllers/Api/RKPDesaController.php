<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RKPDesa;
use App\Models\Tahun;

class RKPDesaController extends Controller
{
    public function index(Request $request)
    {
        $query = RKPDesa::query()->with(['masterBidang', 'masterPola', 'rpjm', 'usulan']);

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('jenis_kegiatan', 'like', "%{$search}%")
                  ->orWhere('lokasi', 'like', "%{$search}%")
                  ->orWhere('data_existing', 'like', "%{$search}%");
            });
        }

        if ($request->has('tahun') && $request->tahun != '') {
            $query->where('tahun', $request->tahun);
        }

        $perPage = $request->get('per_page', 15);
        $data = $query->orderBy('created_at', 'desc')->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function show($id)
    {
        $rkpdesa = RKPDesa::with(['masterBidang', 'masterPola', 'rpjm', 'usulan'])->find($id);

        if (!$rkpdesa) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $rkpdesa
        ]);
    }

    public function getTahun()
    {
        $tahun = Tahun::orderBy('tahun', 'desc')->get();
        return response()->json([
            'success' => true,
            'data' => $tahun
        ]);
    }
}
