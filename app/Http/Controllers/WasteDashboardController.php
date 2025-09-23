<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ForwardedReport;
use App\Models\ReroutedReport;
use App\Models\PostAnnounce;
use Illuminate\Http\Request;

class WasteDashboardController extends Controller
{
    // 🔹 Santa Fe Waste Dashboard
    public function santafe()
    {
        $totalUsers = User::where('location', 'Santa Fe')->count();
        $totalReports = ForwardedReport::where('location', 'Santa Fe')
                                        ->where('category', 'Waste Management')
                                        ->count();

        $pendingReportsCount = ForwardedReport::where('location', 'Santa Fe')
                                ->where('category', 'Waste Management')
                                ->where('status', 'Pending')
                                ->count();

        $acceptedReportsCount = ForwardedReport::where('location', 'Santa Fe')
                                ->where('category', 'Waste Management')
                                ->where('status', 'Accepted')
                                ->count();

        $ongoingReportsCount = ForwardedReport::where('location', 'Santa Fe')
                                ->where('category', 'Waste Management')
                                ->where('status', 'Ongoing')
                                ->count();

        $resolvedReportsCount = ForwardedReport::where('location', 'Santa Fe')
                                ->where('category', 'Waste Management')
                                ->where('status', 'Resolved')
                                ->count();

        $resolvedReports = ForwardedReport::where('location', 'Santa Fe')
                            ->where('category', 'Waste Management')
                            ->where('status', 'Resolved')
                            ->latest()
                            ->get();

        $reports = ForwardedReport::where('location', 'Santa Fe')
                    ->where('category', 'Waste Management')
                    ->latest()
                    ->take(5)
                    ->get();

        return view('dashboard.waste-santafe', compact(
            'totalUsers',
            'totalReports',
            'pendingReportsCount',
            'acceptedReportsCount',
            'ongoingReportsCount',
            'resolvedReportsCount',
            'resolvedReports',
            'reports'
        ));
    }

    // 🔹 Bantayan Waste Dashboard
    public function bantayan()
    {
        $totalUsers = User::where('location', 'Bantayan')->count();
        $totalReports = ForwardedReport::where('location', 'Bantayan')
                                        ->where('category', 'Waste Management')
                                        ->count();

        $pendingReportsCount = ForwardedReport::where('location', 'Bantayan')
                                ->where('category', 'Waste Management')
                                ->where('status', 'Pending')
                                ->count();

        $acceptedReportsCount = ForwardedReport::where('location', 'Bantayan')
                                ->where('category', 'Waste Management')
                                ->where('status', 'Accepted')
                                ->count();

        $ongoingReportsCount = ForwardedReport::where('location', 'Bantayan')
                                ->where('category', 'Waste Management')
                                ->where('status', 'Ongoing')
                                ->count();

        $resolvedReportsCount = ForwardedReport::where('location', 'Bantayan')
                                ->where('category', 'Waste Management')
                                ->where('status', 'Resolved')
                                ->count();

        $resolvedReports = ForwardedReport::where('location', 'Bantayan')
                            ->where('category', 'Waste Management')
                            ->where('status', 'Resolved')
                            ->latest()
                            ->get();

        $reports = ForwardedReport::where('location', 'Bantayan')
                    ->where('category', 'Waste Management')
                    ->latest()
                    ->take(5)
                    ->get();

        return view('dashboard.waste-bantayan', compact(
            'totalUsers',
            'totalReports',
            'pendingReportsCount',
            'acceptedReportsCount',
            'ongoingReportsCount',
            'resolvedReportsCount',
            'resolvedReports',
            'reports'
        ));
    }

    // 🔹 Madridejos Waste Dashboard
    public function madridejos()
    {
        $totalUsers = User::where('location', 'Madridejos')->count();
        $totalReports = ForwardedReport::where('location', 'Madridejos')
                                        ->where('category', 'Waste Management')
                                        ->count();

        $pendingReportsCount = ForwardedReport::where('location', 'Madridejos')
                                ->where('category', 'Waste Management')
                                ->where('status', 'Pending')
                                ->count();

        $acceptedReportsCount = ForwardedReport::where('location', 'Madridejos')
                                ->where('category', 'Waste Management')
                                ->where('status', 'Accepted')
                                ->count();

        $ongoingReportsCount = ForwardedReport::where('location', 'Madridejos')
                                ->where('category', 'Waste Management')
                                ->where('status', 'Ongoing')
                                ->count();

        $resolvedReportsCount = ForwardedReport::where('location', 'Madridejos')
                                ->where('category', 'Waste Management')
                                ->where('status', 'Resolved')
                                ->count();

        $resolvedReports = ForwardedReport::where('location', 'Madridejos')
                            ->where('category', 'Waste Management')
                            ->where('status', 'Resolved')
                            ->latest()
                            ->get();

        $reports = ForwardedReport::where('location', 'Madridejos')
                    ->where('category', 'Waste Management')
                    ->latest()
                    ->take(5)
                    ->get();

        return view('dashboard.waste-madridejos', compact(
            'totalUsers',
            'totalReports',
            'pendingReportsCount',
            'acceptedReportsCount',
            'ongoingReportsCount',
            'resolvedReportsCount',
            'resolvedReports',
            'reports'
        ));
    }

    // 🔹 Forwarded Reports
    public function reportsSantafe()
    {
        $reports = ForwardedReport::where('location', 'Santa Fe')
                    ->where('category', 'Waste Management')
                    ->whereIn('status', ['Forwarded','Pending','Ongoing'])
                    ->latest()
                    ->paginate(10);

        return view('waste.reports-santafe', compact('reports'));
    }

    public function reportsBantayan()
    {
        $reports = ForwardedReport::where('location', 'Bantayan')
                    ->where('category', 'Waste Management')
                    ->whereIn('status', ['Forwarded','Pending','Ongoing'])
                    ->latest()
                    ->paginate(10);

        return view('waste.reports-bantayan', compact('reports'));
    }
   
    public function reportsMadridejos()
    {
        $reports = ReroutedReport::where('forwarded_to', 'Waste Management')
                    ->where('location', 'Madridejos')
                    ->latest()
                    ->paginate(10);

        return view('waste.reports-madridejos', compact('reports'));
    }

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
                    'message' => 'Invalid status provided.'
                ], 400);
            }

            // Try to find the report in ForwardedReport first
            $report = ForwardedReport::find($id);
            $isReroutedModel = false;

            // If not present, try ReroutedReport
            if (!$report) {
                $report = ReroutedReport::find($id);
                $isReroutedModel = true;
            }

            if (!$report) {
                return response()->json([
                    'success' => false,
                    'message' => 'Report not found.'
                ], 404);
            }

            // Update status and optional rerouted target
            $report->status = $status;
            if ($request->filled('rerouted_to')) {
                // Some tables use forwarded_to vs rerouted_to field names — try both
                if (Schema::hasColumn($report->getTable(), 'rerouted_to')) {
                    $report->rerouted_to = $request->input('rerouted_to');
                } elseif (Schema::hasColumn($report->getTable(), 'forwarded_to')) {
                    $report->forwarded_to = $request->input('rerouted_to');
                } else {
                    // fallback: try to set attribute if exists
                    if (property_exists($report, 'rerouted_to') || array_key_exists('rerouted_to', $report->getAttributes())) {
                        $report->rerouted_to = $request->input('rerouted_to');
                    }
                }
            }

            $report->save();

            // If we just rerouted a forwarded report, log a ReroutedReport record
            if (str_starts_with($status, 'Rerouted to') && !$isReroutedModel) {
                // create record only if the ReroutedReport model doesn't already have it
                ReroutedReport::create([
                    'report_id'    => $report->id,
                    'category'     => $report->category ?? null,
                    'title'        => $report->title ?? null,
                    'description'  => $report->description ?? null,
                    'photo'        => $report->photo ?? null,
                    'status'       => $status,
                    'forwarded_to' => $request->input('rerouted_to'),
                    'location'     => $report->location ?? null,
                    'user_id'      => $report->user_id ?? null,
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Report status updated successfully.',
                'status'  => $report->status,
                'rerouted_to' => $request->input('rerouted_to') ?? null,
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => collect($e->errors())->flatten()->join(' ')
            ], 422);

        } catch (\Throwable $e) {
            // Log full exception for debugging, return safe message
            Log::error("updateStatus error: {$e->getMessage()} in {$e->getFile()}:{$e->getLine()}");
            return response()->json([
                'success' => false,
                'message' => 'Server error while updating status. Check logs.'
            ], 500);
        }
    }
    // 🔹 Announcements
    public function bantayanAnnouncements()
    {
        $announcements = PostAnnounce::where('location', 'Bantayan')
            ->where('category', 'Waste Management')
            ->latest()
            ->get();

        return view('waste.waste-bantayan-announcements', compact('announcements'));
    }

    public function madridejosAnnouncements()
    {
        $announcements = PostAnnounce::where('location', 'Madridejos')
            ->where('category', 'Waste Management')
            ->latest()
            ->get();

        return view('waste.waste-madridejos-announcements', compact('announcements'));
    }
}
