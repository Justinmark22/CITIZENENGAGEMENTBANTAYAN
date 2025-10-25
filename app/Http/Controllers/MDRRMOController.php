<?php

namespace App\Http\Controllers;
use App\Models\ReroutedReport;
use App\Models\PostAnnounce;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\ForwardedReport;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
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

    // ✅ Report counts (strictly for Bantayan)
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
    return view('dashboard.mdrrmo-bantayan', compact(
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
public function reportsBantayan()
{
    // ✅ Forwarded Reports (MDRRMO)
    $forwarded = ForwardedReport::select(
        'id',
        'title',
        'description',
        'category',
        'status',
        'location',
        DB::raw("CASE 
            WHEN photo LIKE 'public/%' THEN CONCAT('storage/', SUBSTRING(photo, 8)) 
            WHEN photo LIKE 'storage/%' THEN photo 
            ELSE CONCAT('storage/', photo) 
        END AS photo"),
        'user_id',
        'created_at',
        'updated_at',
        DB::raw("'forwarded' as type")
    )
    ->where('location', 'Bantayan')
    ->where(function ($q) {
        $q->where('forwarded_to', 'MDRRMO')
          ->orWhere('status', 'like', 'Rerouted to MDRRMO%');
    })
    ->where('status', '!=', 'Rerouted away');

    // ✅ Rerouted Reports (MDRRMO)
    $rerouted = ReroutedReport::select(
        'id',
        'title',
        'description',
        'category',
        'status',
        'location',
        DB::raw("CASE 
            WHEN photo LIKE 'public/%' THEN CONCAT('storage/', SUBSTRING(photo, 8)) 
            WHEN photo LIKE 'storage/%' THEN photo 
            ELSE CONCAT('storage/', photo) 
        END AS photo"),
        'user_id',
        'created_at',
        'updated_at',
        DB::raw("'rerouted' as type")
    )
    ->where('location', 'Bantayan')
    ->where('status', 'like', 'Rerouted to MDRRMO%');

    // ✅ Combine both queries safely
    $combinedQuery = $forwarded->unionAll($rerouted);

    // ✅ Wrap and paginate with preserved bindings
    $reports = DB::table(DB::raw("({$combinedQuery->toSql()}) as reports"))
        ->mergeBindings($combinedQuery->getQuery())
        ->orderByDesc('created_at')
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
    try {
        Log::debug('updateStatus called', [
            'report_id' => $report->id,
            'payload'   => $request->only(['status','rerouted_to'])
        ]);

        $request->validate([
            'status'      => 'required|string|max:255',
            'rerouted_to' => 'nullable|string|max:255',
        ]);

        $origStatus  = trim((string) $request->input('status'));
        $rerouted_to = $request->input('rerouted_to');

        // Allowed base statuses
        $validStatuses = ['Pending', 'Forwarded', 'Accepted', 'Ongoing', 'Resolved', 'Rejected', 'Rerouted'];

        // --- Build final status ---
        if (strcasecmp($origStatus, 'Rerouted') === 0 && !empty($rerouted_to)) {
            $status = 'Rerouted to ' . $rerouted_to;
        } elseif (strcasecmp($origStatus, 'Forwarded') === 0 && !empty($rerouted_to)) {
            $status = 'Rerouted to ' . $rerouted_to;
        } elseif (Str::startsWith($origStatus, 'Rerouted to')) {
            $status = $origStatus;
        } else {
            $status = $origStatus;
        }

        // --- Validate final status ---
        if (
            ! in_array($status, $validStatuses, true) &&
            ! Str::startsWith($status, 'Rerouted to')
        ) {
            Log::warning('updateStatus invalid status', [
                'orig'  => $origStatus,
                'final' => $status
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Invalid status provided.',
            ], 400);
        }

        // --- Update forwarded_reports record ---
        $report->status = $status;

        if (!empty($rerouted_to)) {
            if (Schema::hasColumn($report->getTable(), 'rerouted_to')) {
                $report->rerouted_to = $rerouted_to;
            } elseif (Schema::hasColumn($report->getTable(), 'forwarded_to')) {
                $report->forwarded_to = $rerouted_to;
            } else {
                $report->setAttribute('rerouted_to', $rerouted_to);
            }
        }

        $report->save();

        // --- Log reroute in rerouted_reports and hide original report ---
        if (Str::startsWith($status, 'Rerouted to')) {
            $rr = new ReroutedReport();
            $rr->report_id   = $report->id;
            $rr->category    = $report->category ?? null;
            $rr->title       = $report->title ?? null;
            $rr->description = $report->description ?? null;
            $rr->photo       = $report->photo ?? null;
            $rr->status      = $status;

            $rrTable = $rr->getTable();
            if (Schema::hasColumn($rrTable, 'rerouted_to')) {
                $rr->rerouted_to = $rerouted_to;
            } elseif (Schema::hasColumn($rrTable, 'forwarded_to')) {
                $rr->forwarded_to = $rerouted_to;
            } else {
                $rr->setAttribute('rerouted_to', $rerouted_to);
            }

            $rr->location = $report->location ?? null;
            $rr->user_id  = $report->user_id ?? null;
            $rr->save();

            // ✅ Hide original forwarded report so it won't appear again
            $report->status = 'Rerouted away';
            $report->save();
        }

        return response()->json([
            'success'     => true,
            'status'      => $status,
            'rerouted_to' => $rerouted_to ?? null,
        ], 200);

    } catch (\Illuminate\Validation\ValidationException $e) {
        Log::warning('updateStatus validation failed', ['errors' => $e->errors()]);
        return response()->json([
            'success' => false,
            'message' => collect($e->errors())->flatten()->join(' ')
        ], 422);

    } catch (\Throwable $e) {
        Log::error("updateStatus error: {$e->getMessage()} in {$e->getFile()}:{$e->getLine()}");
        return response()->json([
            'success' => false,
            'message' => 'Server error while updating status. Check logs.'
        ], 500);
    }
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
    $reports = ForwardedReport::where('location', 'Santa.Fe')
        ->where('status', 'Resolved')
        ->orderBy('updated_at', 'desc')
        ->get(['id', 'title', 'description', 'category', 'updated_at', 'photo']);

    // Map photo to a full URL
    $reports->transform(function ($report) {
        $report->photo = $report->photo 
            ? asset('storage/' . $report->photo)   // ✅ full URL
            : null;
        return $report;
    });

    return response()->json($reports);
}

// 🔹 Madridejos Resolved Reports
public function getResolvedReportsMadridejos()
{
    $reports = ForwardedReport::where('location', 'Madridejos')
        ->where('status', 'Resolved')
        ->orderBy('updated_at', 'desc')
        ->get(['id', 'title', 'description', 'category', 'updated_at', 'photo']);

    $reports->transform(function ($report) {
        $report->photo = $report->photo 
            ? asset('storage/' . $report->photo) 
            : null;
        return $report;
    });

    return response()->json($reports);
}public function getResolvedReportsBantayan()
{
    $reports = ForwardedReport::where('location', 'Bantayan')
        ->where('status', 'Resolved')
        ->orderBy('updated_at', 'desc')
        ->get(['id', 'title', 'description', 'category', 'updated_at', 'photo']);

    // Map photo to a full URL
    $reports->transform(function ($report) {
        $report->photo = $report->photo 
            ? asset('storage/' . $report->photo)  // ✅ full URL
            : null;
        $report->announced = false; // add default announced state
        return $report;
    });

    return response()->json($reports);
}



public function postAnnouncement(Request $request)
{
    // Validate input
    $request->validate([
        'title'       => 'required|string|max:255',
        'description' => 'required|string',
        'category'    => 'nullable|string|max:100',
        'location'    => 'required|in:Santa.Fe,Madridejos,Bantayan',
        'photo'       => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
    ]);

    // Handle photo upload
    $photoPath = null;
    if ($request->hasFile('photo')) {
        $photoPath = $request->file('photo')->store('announcements', 'public');
        // stored in: storage/app/public/announcements
    }

    // Save announcement
    $announcement = PostAnnounce::create([
        'title'       => $request->title,
        'description' => $request->description,
        'category'    => $request->category ?? 'General',
        'location'    => $request->location,
        'photo'       => $photoPath, // ✅ save photo path
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Announcement posted successfully.',
        'data'    => $announcement,
    ]);
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
