<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use App\Models\Report;
use App\Models\ForwardedReport;
use App\Models\ReroutedReport;
use Illuminate\Support\Facades\DB;

class WaterDashboardController extends Controller
{
    public function __construct()
    {
        // ✅ Comment this line if you want the dashboard public
        $this->middleware('auth');
    }

    /* ============================
     * DASHBOARD SUMMARIES
     * ============================
     */

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

    /* ============================
     * REPORTS PER LOCATION
     * ============================
     */

   
public function reportsBantayan()
{
    // 🔹 Forwarded Reports for Bantayan
    $forwarded = ForwardedReport::select(
        'id',
        'title',
        'description',
        'category',
        'status',
        'location',
        'photo',
        'user_id',
        'created_at',
        'updated_at',
        DB::raw("'forwarded' as type") // mark type
    )
    ->where('location', 'Bantayan')
    ->where(function ($q) {
        $q->where('category', 'Water Management')
          ->orWhere('forwarded_to', 'Water Management')
          ->orWhere('status', 'Rerouted to Water Management');
    })
    ->whereIn('status', ['Forwarded', 'Pending', 'Ongoing', 'Rerouted to Water Management']);

    // 🔹 Rerouted Reports for Bantayan
    $rerouted = ReroutedReport::select(
        'id',
        'title',
        'description',
        'category',
        'status',
        'location',
        'photo',
        'user_id',
        'created_at',
        'updated_at',
        DB::raw("'rerouted' as type") // mark type
    )
    ->where('location', 'Bantayan')
    ->where('status', 'like', 'Rerouted%');

    // 🔹 Combine both using union
    $combinedQuery = $forwarded->unionAll($rerouted);

    // 🔹 Wrap in query builder for ordering and pagination
    $reports = DB::table(DB::raw("({$combinedQuery->toSql()}) as reports"))
        ->mergeBindings($combinedQuery->getQuery())
        ->orderByDesc('created_at')
        ->paginate(10);

    return view('water.reports-bantayan', compact('reports'));
}
     
public function reportsSantafe()
{
    // 🔹 Forwarded Reports for Santa Fe
    $forwarded = ForwardedReport::select(
        'id',
        'title',
        'description',
        'category',
        'status',
        'location',
        'photo',
        'user_id',
        'created_at',
        'updated_at',
        DB::raw("'forwarded' as type") // mark type
    )
    ->where('location', 'Santa.Fe')
    ->where(function ($q) {
        $q->where('category', 'Water Management')
          ->orWhere('forwarded_to', 'Water Management')
          ->orWhere('status', 'Rerouted to Water Management');
    })
    ->whereIn('status', ['Forwarded', 'Pending', 'Ongoing', 'Rerouted to Water Management']);

    // 🔹 Rerouted Reports for Santa Fe
    $rerouted = ReroutedReport::select(
        'id',
        'title',
        'description',
        'category',
        'status',
        'location',
        'photo',
        'user_id',
        'created_at',
        'updated_at',
        DB::raw("'rerouted' as type") // mark type
    )
    ->where('location', 'Santa.Fe')
    ->where('status', 'like', 'Rerouted%');

    // 🔹 Combine both using union
    $combinedQuery = $forwarded->unionAll($rerouted);

    // 🔹 Wrap in query builder for ordering and pagination
    $reports = DB::table(DB::raw("({$combinedQuery->toSql()}) as reports"))
        ->mergeBindings($combinedQuery->getQuery())
        ->orderByDesc('created_at')
        ->paginate(10);

    return view('water.reports-santafe', compact('reports'));
}

    
public function reportsMadridejos()
{
    // 🔹 Forwarded Reports for Madridejos
    $forwarded = ForwardedReport::select(
        'id',
        'title',
        'description',
        'category',
        'status',
        'location',
        'photo',
        'user_id',
        'created_at',
        'updated_at',
        DB::raw("'forwarded' as type") // mark type
    )
    ->where('location', 'Madridejos')
    ->where(function ($q) {
        $q->where('category', 'Water Management')
          ->orWhere('forwarded_to', 'Water Management')
          ->orWhere('status', 'Rerouted to Water Management');
    })
    ->whereIn('status', ['Forwarded', 'Pending', 'Ongoing', 'Rerouted to Water Management']);

    // 🔹 Rerouted Reports for Madridejos
    $rerouted = ReroutedReport::select(
        'id',
        'title',
        'description',
        'category',
        'status',
        'location',
        'photo',
        'user_id',
        'created_at',
        'updated_at',
        DB::raw("'rerouted' as type") // mark type
    )
    ->where('location', 'Santa.Fe')
    ->where('status', 'like', 'Rerouted%');

    // 🔹 Combine both using union
    $combinedQuery = $forwarded->unionAll($rerouted);

    // 🔹 Wrap in query builder for ordering and pagination
    $reports = DB::table(DB::raw("({$combinedQuery->toSql()}) as reports"))
        ->mergeBindings($combinedQuery->getQuery())
        ->orderByDesc('created_at')
        ->paginate(10);

    return view('water.reports-madridejos', compact('reports'));
}

    /* ============================
     * UPDATE STATUS (Accept, Ongoing, Resolved, Reroute)
     * ============================
     */
    public function updateStatus(Request $request, $id)
    {
        try {
            $request->validate([
                'status'      => 'required|string|max:255',
                'rerouted_to' => 'nullable|string|max:255',
            ]);

            $status = $request->input('status');
            $validStatuses = ['Pending', 'Forwarded', 'Accepted', 'Ongoing', 'Resolved', 'Rejected'];

            if (!in_array($status, $validStatuses) && !str_starts_with($status, 'Rerouted to')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid status provided.',
                ], 400);
            }

            // 🔹 Try to find report in ForwardedReport first
            $report = ForwardedReport::find($id);
            $isReroutedModel = false;

            if (!$report) {
                $report = ReroutedReport::find($id);
                $isReroutedModel = true;
            }

            if (!$report) {
                return response()->json([
                    'success' => false,
                    'message' => 'Report not found.',
                ], 404);
            }

            $oldStatus = $report->status;

            // 🔹 Update main status
            $report->status = $status;

            // 🔹 Handle rerouting
            if ($request->filled('rerouted_to')) {
                if (Schema::hasColumn($report->getTable(), 'rerouted_to')) {
                    $report->rerouted_to = $request->input('rerouted_to');
                } elseif (Schema::hasColumn($report->getTable(), 'forwarded_to')) {
                    $report->forwarded_to = $request->input('rerouted_to');
                }
            }

            $report->save();

            // 🔹 If rerouted, duplicate in ReroutedReports
            if (str_starts_with($status, 'Rerouted to') && !$isReroutedModel) {
                ReroutedReport::create([
                    'report_id'    => $report->id,
                    'category'     => $report->category,
                    'title'        => $report->title,
                    'description'  => $report->description,
                    'photo'        => $report->photo,
                    'status'       => $status,
                    'forwarded_to' => $request->input('rerouted_to'),
                    'location'     => $report->location,
                    'user_id'      => $report->user_id,
                ]);
            }

            return response()->json([
                'success'     => true,
                'message'     => 'Report status updated successfully.',
                'status'      => $report->status,
                'old_status'  => $oldStatus,
                'rerouted_to' => $request->input('rerouted_to') ?? null,
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => collect($e->errors())->flatten()->join(' '),
            ], 422);
        } catch (\Throwable $e) {
            Log::error("updateStatus error: {$e->getMessage()} in {$e->getFile()}:{$e->getLine()}");
            return response()->json([
                'success' => false,
                'message' => 'Server error while updating status. Check logs.',
            ], 500);
        }
    }public function reroute(Request $request, $id)
{
    try {
        // 🔹 1. Validate incoming request
        $request->validate([
            'rerouted_to' => 'required|string|max:255',
        ]);

        // 🔹 2. Try finding the report in ForwardedReport first
        $report = ForwardedReport::find($id);

        // If not found, try ReroutedReport (in case it was already rerouted once)
        if (!$report) {
            $report = ReroutedReport::find($id);
        }

        // 🔹 3. Handle missing report
        if (!$report) {
            return response()->json([
                'success' => false,
                'message' => 'Report not found in either ForwardedReport or ReroutedReport.',
            ], 404);
        }

        // 🔹 4. Update report status
        $newOffice = $request->input('rerouted_to');
        $report->status = "Rerouted to {$newOffice}";

        // 🔹 5. Save rerouted_to / forwarded_to depending on model
        if (\Schema::hasColumn($report->getTable(), 'rerouted_to')) {
            $report->rerouted_to = $newOffice;
        } elseif (\Schema::hasColumn($report->getTable(), 'forwarded_to')) {
            $report->forwarded_to = $newOffice;
        }

        $report->save();

        // 🔹 6. Log rerouted copy in ReroutedReports (prevent duplicates)
        ReroutedReport::create([
            'report_id'    => $report->id,
            'category'     => $report->category ?? 'Unknown',
            'title'        => $report->title ?? 'Untitled',
            'description'  => $report->description ?? '',
            'photo'        => $report->photo ?? null,
            'status'       => $report->status,
            'forwarded_to' => $newOffice,
            'location'     => $report->location ?? 'Unknown',
            'user_id'      => $report->user_id ?? null,
        ]);

        return response()->json([
            'success'     => true,
            'message'     => 'Report rerouted successfully.',
            'new_status'  => $report->status,
            'rerouted_to' => $newOffice,
        ], 200);

    } catch (\Illuminate\Validation\ValidationException $e) {
        // Validation errors
        return response()->json([
            'success' => false,
            'message' => collect($e->errors())->flatten()->join(' '),
        ], 422);
    } catch (\Throwable $e) {
        // 🔥 Log the real cause for debugging
        \Log::error("Reroute error: {$e->getMessage()} in {$e->getFile()}:{$e->getLine()}");

        return response()->json([
            'success' => false,
            'message' => "Server error while rerouting report. Check storage/logs/laravel.log.",
        ], 500);
    }
}public function santafeAnnouncements()
{
    $announcements = \App\Models\Announcement::where('location', 'Santa.Fe')
        ->latest()
        ->get();

    return view('water.announcement-santafe', compact('announcements'));
}
/* ============================
 * FETCH RESOLVED REPORTS (PER LOCATION)
 * ============================ */
public function getResolvedReportsSantafe()
{
    $reports = \App\Models\ForwardedReport::whereRaw('LOWER(location) = ?', ['Santa.Fe'])
        ->whereRaw('LOWER(status) = ?', ['resolved'])
        ->orderBy('updated_at', 'desc')
        ->get(['id', 'title', 'description', 'category', 'updated_at', 'photo']);

    $reports->transform(function ($report) {
        $report->photo = $report->photo
            ? asset('storage/' . ltrim($report->photo, '/'))
            : null;
        return $report;
    });

    return response()->json($reports);
}

public function getResolvedReportsBantayan()
{
    $reports = \App\Models\ForwardedReport::whereRaw('LOWER(location) = ?', ['Bantayan'])
        ->whereRaw('LOWER(status) = ?', ['resolved'])
        ->orderBy('updated_at', 'desc')
        ->get(['id', 'title', 'description', 'category', 'updated_at', 'photo']);

    $reports->transform(function ($report) {
        $report->photo = $report->photo
            ? asset('storage/' . ltrim($report->photo, '/'))
            : null;
        return $report;
    });

    return response()->json($reports);
}

public function getResolvedReportsMadridejos()
{
    $reports = \App\Models\ForwardedReport::whereRaw('LOWER(location) = ?', ['Madridejos'])
        ->whereRaw('LOWER(status) = ?', ['resolved'])
        ->orderBy('updated_at', 'desc')
        ->get(['id', 'title', 'description', 'category', 'updated_at', 'photo']);

    $reports->transform(function ($report) {
        $report->photo = $report->photo
            ? asset('storage/' . ltrim($report->photo, '/'))
            : null;
        return $report;
    });

    return response()->json($reports);
}


public function bantayanAnnouncements()
{
    $announcements = \App\Models\Announcement::where('location', 'Bantayan')
        ->latest()
        ->get();

    return view('water.announcement-bantayan', compact('announcements'));
}

public function madridejosAnnouncements()
{
    $announcements = \App\Models\Announcement::where('location', 'Madridejos')
        ->latest()
        ->get();

    return view('water.announcement-madridejos', compact('announcements'));
}
}