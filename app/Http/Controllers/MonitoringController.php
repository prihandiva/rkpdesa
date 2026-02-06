<?php

namespace App\Http\Controllers;

use App\Models\MonitoringLog;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MonitoringController extends Controller
{
    public function index()
    {
        // Fetch logs with user data
        $logs = MonitoringLog::with('user')->latest()->take(100)->get();

        // Line Chart Data: Logins per day for the last 7 days
        $loginData = MonitoringLog::where('activity_type', 'login')
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->groupBy('date')
            ->pluck('count', 'date')
            ->toArray();

        // Fill in missing days
        $chartData = [];
        $categories = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $categories[] = Carbon::now()->subDays($i)->format('d M');
            $chartData[] = $loginData[$date] ?? 0;
        }

        // Pie Chart Data: Activity Type Distribution
        $pieData = MonitoringLog::select('activity_type', DB::raw('count(*) as count'))
            ->groupBy('activity_type')
            ->pluck('count', 'activity_type')
            ->toArray();
        
        $pieSeries = array_values($pieData);
        $pieLabels = array_keys($pieData);

        return view('admin.monitoring.index', compact('logs', 'chartData', 'categories', 'pieSeries', 'pieLabels'));
    }
}
