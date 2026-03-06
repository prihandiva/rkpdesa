<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usulan;
use App\Models\RKPDesa;
use App\Models\Tahun;
use App\Models\Dusun;
use App\Models\User;
use App\Models\Rpjm;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Check Auth using session (can be user or admin)
        // if (!session()->get('user_authenticated') && !session()->get('admin_authenticated')) {
        //     return redirect('/login')->with('error', 'Silakan login terlebih dahulu');
        // }

        // Available years for filter
        $tahunList = Tahun::orderBy('tahun', 'desc')->get();
        $defaultTahun = $tahunList->where('status', 'Aktif')->first()->id_tahun ?? ($tahunList->first()->id_tahun ?? null);
        
        // Selected year
        $selectedTahunId = $request->input('tahun', $defaultTahun);
        $selectedTahun = Tahun::find($selectedTahunId);
        $actualYear = $selectedTahun ? $selectedTahun->tahun : date('Y'); // Get actual string '2026'

        // Basic Stats
        $totalRpjm = Rpjm::count();
        $totalUsulan = Usulan::when($actualYear, function ($query) use ($actualYear) {
            return $query->where('tahun', $actualYear);
        })->count();
        
        $totalRkp = RKPDesa::when($actualYear, function ($query) use ($actualYear) {
            return $query->where('tahun', $actualYear);
        })->count();

        // 1. Pie Chart: Usulan per Dusun
        // Fetch dusun to get names instead of IDs
        $dusuns = Dusun::all()->keyBy('id_dusun');
        
        $usulanPerDusunData = Usulan::selectRaw('id_dusun, count(*) as total')
            ->when($actualYear, function ($query) use ($actualYear) {
                return $query->where('tahun', $actualYear);
            })
            ->groupBy('id_dusun')
            ->get()
            ->map(function ($item) use ($dusuns) {
                return [
                    'dusun' => isset($dusuns[$item->id_dusun]) ? $dusuns[$item->id_dusun]->nama : 'Tidak Diketahui',
                    'total' => $item->total
                ];
            });

        // 2. Bar Chart: Usulan dalam satu tahun (Status based or Monthly? The user said: "jumlah usulan dalam satu tahun ... pakai filter")
        // Since there is no "month"/created_at usage common in these tables, we will show Usulan by Status for the selected year as a Bar Chart.
        $usulanPerStatusData = Usulan::selectRaw('status, count(*) as total')
            ->when($actualYear, function ($query) use ($actualYear) {
                return $query->where('tahun', $actualYear);
            })
            ->groupBy('status')
            ->get();

        // 3. Pie/Bar Chart: Kegiatan RKPDesa berdasarkan Status dll (for the selected year)
        $rkpPerStatusData = RKPDesa::selectRaw('status, count(*) as total')
            ->when($actualYear, function ($query) use ($actualYear) {
                return $query->where('tahun', $actualYear);
            })
            ->groupBy('status')
            ->get();

        return view('dashboard', compact(
            'tahunList', 
            'selectedTahunId', 
            'selectedTahun',
            'totalRpjm',
            'totalUsulan',
            'totalRkp',
            'usulanPerDusunData',
            'usulanPerStatusData',
            'rkpPerStatusData'
        ));
    }
}
