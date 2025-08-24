<?php

namespace App\Http\Controllers;

use App\Models\ForwardedReport;
use Illuminate\Http\Request;
use App\Models\User;
class MDRRMOController extends Controller
{
  public function santafe()
{
    $totalUsers = User::where('location', 'Santa.Fe')->count();

    // ✅ Report counts (strictly for Santa.Fe)
    $totalReports = ForwardedReport::where('location', 'Santa.Fe')->count();

    $pendingReportsCount = ForwardedReport::where('location', 'Santa.Fe')
        ->where('status', 'Pending')
        ->count();

    $ongoingReportsCount = ForwardedReport::where('location', 'Santa.Fe')
        ->where('status', 'Ongoing')
        ->count();

    $resolvedReportsCount = ForwardedReport::where('location', 'Santa.Fe')
        ->where('status', 'Resolved')
        ->count();

    // ✅ Resolved reports list
    $resolvedReports = ForwardedReport::where('location', 'Santa.Fe')
        ->where('status', 'Resolved')
        ->latest()
        ->get();
$reports = ForwardedReport::where('location', 'Santa.Fe')
                ->latest()
                ->take(5) // show only 5 recent ones
                ->get();

    // Pass everything to Blade
    return view('dashboard.mdrrmo-santafe', compact(
        'totalUsers',
        'totalReports',
        'pendingReportsCount',
        'ongoingReportsCount',
        'resolvedReportsCount',
        'resolvedReports',
        'reports' 
    ));
}




    public function bantayan()
    {
        return view('dashboard.mdrrmo-bantayan');
    }

    public function madridejos()
    {
        return view('dashboard.mdrrmo-madridejos');
    }

    // Santa.Fe Forwarded Reports
    public function reportsSantafe()
    {
        // Only Pending or Ongoing reports
        $reports = ForwardedReport::where('location', 'Santa.Fe')
                    ->whereIn('status', ['Forwarded','Pending','Ongoing'])
                    ->latest()
                    ->paginate(10);

        return view('mdrrmo.reports-santafe', compact('reports'));
    }

    // Madridejos Forwarded Reports
    public function reportsMadridejos()
    {
        $reports = ForwardedReport::where('location', 'Madridejos')
                    ->whereIn('status', ['Forwarded','Pending','Ongoing'])
                    ->latest()
                    ->paginate(10);

        return view('mdrrmo.reports-madridejos', compact('reports'));
    }

    // Bantayan Forwarded Reports
    public function reportsBantayan()
    {
        $reports = ForwardedReport::where('location', 'Bantayan')
                    ->whereIn('status', ['Forwarded','Pending','Ongoing'])
                    ->latest()
                    ->paginate(10);

        return view('mdrrmo.reports-bantayan', compact('reports'));
    }

    // Fetch the user relationship
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Update report status
    public function updateStatus(Request $request, ForwardedReport $report)
    {
        $request->validate([
            'status' => 'required|in:Forwarded,Ongoing,Resolved,Rejected',
        ]);

        $report->status = $request->status;
        $report->save();

        return response()->json([
            'success' => true,
            'status' => $report->status,
        ]);
    }
    
}
