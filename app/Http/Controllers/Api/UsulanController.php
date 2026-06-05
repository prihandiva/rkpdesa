<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usulan;
use App\Models\Dusun;
use App\Models\Tahun;

class UsulanController extends Controller
{
    public function index(Request $request)
    {
        $query = Usulan::query()->with(['dusun', 'rw', 'rt']);

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('pengusul', 'like', "%{$search}%")
                  ->orWhere('jenis_kegiatan', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        if ($request->has('id_dusun') && $request->id_dusun != '') {
            $query->where('id_dusun', $request->id_dusun);
        }

        if ($request->has('active_year') && $request->active_year == 'true') {
            $activeTahun = Tahun::where('status', 'Aktif')->first();
            if ($activeTahun) {
                $query->where('tahun', $activeTahun->tahun);
            }
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
        $usulan = Usulan::with(['dusun', 'rw', 'rt'])->find($id);

        if (!$usulan) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $usulan
        ]);
    }

    public function getDusun()
    {
        $dusun = Dusun::all();
        return response()->json([
            'success' => true,
            'data' => $dusun
        ]);
    }
}
