<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report; // ✅ Make sure you import your Report model

class WaterDashboardController extends Controller
{
    public function santafe()
    {
        $totalReports = Report::count();
        $pendingReportsCount = Report::where('status', 'Pending')->count();
        $resolvedReportsCount = Report::where('status', 'Resolved')->count();
        $reports = Report::latest()->take(10)->get();

        return view('dashboard.water-santafe', compact(
            'totalReports',
            'pendingReportsCount',
            'resolvedReportsCount',
            'reports'
        ));
    }

    public function bantayan()
    {
        $totalReports = Report::count();
        $pendingReportsCount = Report::where('status', 'Pending')->count();
        $resolvedReportsCount = Report::where('status', 'Resolved')->count();
        $reports = Report::latest()->take(10)->get();

        return view('dashboard.water-bantayan', compact(
            'totalReports',
            'pendingReportsCount',
            'resolvedReportsCount',
            'reports'
        ));
    }

    public function madridejos()
    {
        $totalReports = Report::count();
        $pendingReportsCount = Report::where('status', 'Pending')->count();
        $resolvedReportsCount = Report::where('status', 'Resolved')->count();
        $reports = Report::latest()->take(10)->get();

        return view('dashboard.water-madridejos', compact(
            'totalReports',
            'pendingReportsCount',
            'resolvedReportsCount',
            'reports'
        ));
    }
}
