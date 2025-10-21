<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report; // ✅ Make sure you import your Report model
use App\Models\ForwardedReport;
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
   public function reportsBantayan()
{
    $reports = ForwardedReport::where('location', 'Bantayan')
        ->where(function ($q) {
            $q->where('category', 'Water Management')
              ->orWhere('forwarded_to', 'Water Management')
              ->orWhere('status', 'Rerouted to Water Management');
        })
        ->whereIn('status', ['Forwarded', 'Pending', 'Ongoing', 'Rerouted to Water Management'])
        ->latest()
        ->paginate(10); // 👈 this enables $reports->links()

    return view('water.reports-bantayan', compact('reports'));
}


    public function reportsSantafe()
{
    $reports = Report::latest()->get();
    return view('water.reports-santafe', compact('reports'));
}

    public function reportsMadridejos()
{
    $reports = Report::latest()->get();
    return view('water.reports-madridejos', compact('reports'));
}}