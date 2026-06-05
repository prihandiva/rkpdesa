<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RPJM;
use App\Models\Bidang;

class RPJMController extends Controller
{
    public function index(Request $request)
    {
        $query = RPJM::query()->with(['masterBidang', 'masterPola']);

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('jenis_kegiatan', 'like', "%{$search}%")
                  ->orWhere('lokasi', 'like', "%{$search}%")
                  ->orWhere('sasaran', 'like', "%{$search}%");
            });
        }

        if ($request->has('id_bidang') && $request->id_bidang != '') {
            $query->where('bidang', $request->id_bidang);
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
        $rpjm = RPJM::with(['masterBidang', 'masterPola'])->find($id);

        if (!$rpjm) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $rpjm
        ]);
    }

    public function getBidang()
    {
        $bidang = Bidang::all();
        return response()->json([
            'success' => true,
            'data' => $bidang
        ]);
    }
}
