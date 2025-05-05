<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DisasterReport;
use Illuminate\Support\Facades\DB;

class DisasterReportStatisticsController extends Controller
{
    /**
     * Display disaster reports statistics.
     */
    public function index()
    {
        $totalReports = DisasterReport::count();
        $pendingReports = DisasterReport::where('status', 'pending')->count();
        $approvedReports = DisasterReport::where('status', 'approved')->count();
        $rejectedReports = DisasterReport::where('status', 'rejected')->count();

        $reportsByMonth = DisasterReport::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as count')
        )
        ->whereYear('created_at', date('Y'))
        ->groupBy('month')
        ->orderBy('month')
        ->get()
        ->pluck('count', 'month')
        ->toArray();

        for ($i = 1; $i <= 12; $i++) {
            if (!isset($reportsByMonth[$i])) {
                $reportsByMonth[$i] = 0;
            }
        }
        ksort($reportsByMonth);

        $topLocations = DisasterReport::select('location', DB::raw('count(*) as total'))
            ->groupBy('location')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();

        $recentReports = DisasterReport::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.statistics.statistics', compact(
            'totalReports',
            'pendingReports',
            'approvedReports',
            'rejectedReports',
            'reportsByMonth',
            'topLocations',
            'recentReports'
        ));
    }
}
