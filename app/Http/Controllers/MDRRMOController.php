<?php

namespace App\Http\Controllers;
use App\Models\ReroutedReport;
use App\Models\PostAnnounce;

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

    $acceptedReportsCount = ForwardedReport::where('location', 'Santa.Fe')
        ->where('status', 'Accepted')
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

    // ✅ Show only 5 recent reports
    $reports = ForwardedReport::where('location', 'Santa.Fe')
        ->latest()
        ->take(5)
        ->get();

    // Pass everything to Blade
    return view('dashboard.mdrrmo-santafe', compact(
        'totalUsers',
        'totalReports',
        'pendingReportsCount',
        'acceptedReportsCount',   // 👈 added
        'ongoingReportsCount',
        'resolvedReportsCount',
        'resolvedReports',
        'reports'
    ));
}

    public function Bantayan()
{
    $totalUsers = User::where('location', 'Bantayan')->count();

    // ✅ Report counts (strictly for Madridejos)
    $totalReports = ForwardedReport::where('location', 'Bantayan')->count();

    $pendingReportsCount = ForwardedReport::where('location', 'Bantayan')
        ->where('status', 'Pending')
        ->count();

    $acceptedReportsCount = ForwardedReport::where('location', 'Bantayan')
        ->where('status', 'Accepted')
        ->count();

    $ongoingReportsCount = ForwardedReport::where('location', 'Bantayan')
        ->where('status', 'Ongoing')
        ->count();

    $resolvedReportsCount = ForwardedReport::where('location', 'Bantayan')
        ->where('status', 'Resolved')
        ->count();

    // ✅ Resolved reports list
    $resolvedReports = ForwardedReport::where('location', 'Bantayan')
        ->where('status', 'Resolved')
        ->latest()
        ->get();

    // ✅ Show only 5 recent reports
    $reports = ForwardedReport::where('location', 'Bantayan')
        ->latest()
        ->take(5)
        ->get();

    // Pass everything to Blade
    return view('dashboard.mdrrmo-Bantayan', compact(
        'totalUsers',
        'totalReports',
        'pendingReportsCount',
        'acceptedReportsCount',   // 👈 added
        'ongoingReportsCount',
        'resolvedReportsCount',
        'resolvedReports',
        'reports'
    ));
}

 public function madridejos()
{
    $totalUsers = User::where('location', 'Madridejos')->count();

    // ✅ Report counts (strictly for Madridejos)
    $totalReports = ForwardedReport::where('location', 'Madridejos')->count();

    $pendingReportsCount = ForwardedReport::where('location', 'Madridejos')
        ->where('status', 'Pending')
        ->count();

    $acceptedReportsCount = ForwardedReport::where('location', 'Madridejos')
        ->where('status', 'Accepted')
        ->count();

    $ongoingReportsCount = ForwardedReport::where('location', 'Madridejos')
        ->where('status', 'Ongoing')
        ->count();

    $resolvedReportsCount = ForwardedReport::where('location', 'Madridejos')
        ->where('status', 'Resolved')
        ->count();

    // ✅ Resolved reports list
    $resolvedReports = ForwardedReport::where('location', 'Madridejos')
        ->where('status', 'Resolved')
        ->latest()
        ->get();

    // ✅ Show only 5 recent reports
    $reports = ForwardedReport::where('location', 'Madridejos')
        ->latest()
        ->take(5)
        ->get();

    // Pass everything to Blade
    return view('dashboard.mdrrmo-madridejos', compact(
        'totalUsers',
        'totalReports',
        'pendingReportsCount',
        'acceptedReportsCount',   // 👈 added
        'ongoingReportsCount',
        'resolvedReportsCount',
        'resolvedReports',
        'reports'
    ));
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
public function updateStatus(Request $request, ForwardedReport $report)
{
    $request->validate([
        'status'      => 'required|string|max:255',
        'rerouted_to' => 'nullable|string|max:255',
    ]);

    $status = $request->status;

    // ✅ Allowed statuses
    $validStatuses = ['Pending', 'Forwarded', 'Accepted', 'Ongoing', 'Resolved', 'Rejected'];
    if (!in_array($status, $validStatuses) && !str_starts_with($status, 'Rerouted to')) {
        return response()->json([
            'success' => false,
            'message' => 'Invalid status provided.',
        ], 400);
    }

    // ✅ Update forwarded_reports
    $report->status = $status;
    $report->save();

    // ✅ Only log reroutes
    if (str_starts_with($status, 'Rerouted to')) {
        ReroutedReport::create([
            'report_id'   => $report->id,           // 🔗 original report
            'category'    => $report->category,
            'title'       => $report->title,
            'description' => $report->description,
            'photo'       => $report->photo,
            'status'      => $status,
            'forwarded_to'=> $request->rerouted_to, // new office/department
            'location'    => $report->location,
            'user_id'     => $report->user_id,
        ]);
    }

    return response()->json([
        'success'     => true,
        'status'      => $status,
        'rerouted_to' => $request->rerouted_to,
    ]);
}
public function santafeAnnouncements()
{
    $announcements = \App\Models\Announcement::where('location', 'Santa.Fe')
        ->latest()
        ->get();

    return view('mdrrmo.mdrrmo_santafe-announcements', compact('announcements'));
}
 public function getResolvedReports()
    {
        // Fetch resolved reports for Santa Fe
        $reports = ForwardedReport::where('location', 'Santa.Fe')
                                   ->where('status', 'Resolved')
                                   ->orderBy('updated_at', 'desc')
                                   ->get(['title', 'description', 'category', 'updated_at']);

        return response()->json($reports);
    }
    // Fetch resolved reports for Madridejos
public function getResolvedReportsMadridejos()
{
    $reports = ForwardedReport::where('location', 'Madridejos')
                               ->where('status', 'Resolved')
                               ->orderBy('updated_at', 'desc')
                               ->get(['title', 'description', 'category', 'updated_at']);

    return response()->json($reports);
}

// Fetch resolved reports for Bantayan
public function getResolvedReportsBantayan()
{
    $reports = ForwardedReport::where('location', 'Bantayan')
                               ->where('status', 'Resolved')
                               ->orderBy('updated_at', 'desc')
                               ->get(['title', 'description', 'category', 'updated_at']);

    return response()->json($reports);
}

public function postAnnouncement(Request $request)
{
    $data = $request->only(['title', 'description', 'category', 'location']);

    // Validate input
    $request->validate([
        'title'       => 'required|string|max:255',
        'description' => 'required|string',
        'category'    => 'nullable|string|max:100',
        'location'    => 'required|in:Santa.Fe,Madridejos,Bantayan'
    ]);

    // Save announcement
    PostAnnounce::create([
        'title'       => $data['title'],
        'description' => $data['description'],
        'category'    => $data['category'] ?? 'General',
        'location'    => $data['location']
    ]);

    return response()->json(['success' => true, 'message' => 'Announcement posted successfully.']);
}

// 🔹 Madridejos Announcements
public function madridejosAnnouncements()
{
    $announcements = PostAnnounce::where('location', 'Madridejos')
        ->latest()
        ->get();

    return view('mdrrmo.mdrrmo_madridejos-announcements', compact('announcements'));
}

// 🔹 Bantayan Announcements
public function bantayanAnnouncements()
{
    $announcements = PostAnnounce::where('location', 'Bantayan')
        ->latest()
        ->get();

    return view('mdrrmo.mdrrmo_bantayan-announcements', compact('announcements'));
}



}
