<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RPJM;
use App\Models\RKPDesa;
use App\Models\Usulan;
use App\Models\BeritaAcara;

class DashboardController extends Controller
{
    public function index()
    {
        $rpjmCount = RPJM::count();
        $rkpdesaCount = RKPDesa::count();
        $usulanCount = Usulan::count();
        $beritaAcaraCount = BeritaAcara::count();

        $latestBeritaAcara = BeritaAcara::orderBy('created_at', 'desc')->take(5)->get();

        // Data for Chart: Usulan by Status
        $usulanByStatus = Usulan::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->get()
            ->map(function ($item) {
                // Determine a color based on status for the frontend
                $color = match(strtolower(trim($item->status ?? ''))) {
                    'proses'                   => '#60A5FA', // blue-400
                    'pending'                  => '#FBBF24', // amber-400
                    'terverifikasi'            => '#34D399', // emerald-400
                    'gagal terverifikasi'      => '#F87171', // red-400
                    'menunggu persetujuan bpd' => '#A78BFA', // violet-400
                    'disetujui'                => '#4ADE80', // green-400
                    'ditolak'                  => '#F472B6', // pink-400
                    default                    => '#94A3B8', // slate-400
                };
                return [
                    'status' => $item->status ?? 'Tidak Diketahui',
                    'count' => $item->count,
                    'color' => $color
                ];
            });

        return response()->json([
            'success' => true,
            'data' => [
                'summary' => [
                    'rpjm' => $rpjmCount,
                    'rkpdesa' => $rkpdesaCount,
                    'usulan' => $usulanCount,
                    'berita_acara' => $beritaAcaraCount,
                ],
                'usulan_by_status' => $usulanByStatus,
                'latest_berita_acara' => $latestBeritaAcara
            ]
        ]);
    }
}
