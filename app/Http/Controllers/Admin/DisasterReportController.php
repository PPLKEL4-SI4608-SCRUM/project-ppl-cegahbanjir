<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DisasterReport;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DisasterReportController extends Controller
{
    /**
     * Tampilkan semua laporan bencana.
     */
    public function index(): View
    {
        $reports = DisasterReport::with('user')->latest()->get();
        return view('admin.disaster_reports.index', compact('reports'));
    }

    /**
     * Terima laporan bencana.
     */
    public function accept(int $id): RedirectResponse
    {
        $report = DisasterReport::findOrFail($id);
        $report->update(['status' => 'approved']);

        return redirect()->route('admin.disaster-reports.index')->with('success', 'Laporan diterima.');
    }

    /**
     * Tolak laporan bencana.
     */
    public function reject(int $id): RedirectResponse
    {
        $report = DisasterReport::findOrFail($id);
        $report->update(['status' => 'rejected']);

        return redirect()->route('admin.disaster-reports.index')->with('success', 'Laporan ditolak.');
    }
}
