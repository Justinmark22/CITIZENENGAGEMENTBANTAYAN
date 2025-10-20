<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ForwardedReport;
use App\Models\ReroutedReport;
use App\Models\PostAnnounce;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;

class WasteDashboardController extends Controller
{
    /**
     * 🔹 Santa Fe Waste Dashboard
     */
    public function santafe()
    {
        return $this->dashboardData('Santa Fe', 'dashboard.waste-santafe');
    }

    /**
     * 🔹 Bantayan Waste Dashboard
     */
    public function bantayan()
    {
        return $this->dashboardData('Bantayan', 'dashboard.waste-bantayan');
    }

    /**
     * 🔹 Madridejos Waste Dashboard
     */
    public function madridejos()
    {
        return $this->dashboardData('Madridejos', 'dashboard.waste-madridejos');
    }

    /**
     * ✅ Shared logic for dashboard counts
     */
    private function dashboardData($location, $view)
    {
        $totalUsers = User::where('location', $location)->count();

        $query = ForwardedReport::where('location', $location)
            ->where(function ($q) {
                $q->where('category', 'Waste Management')
                  ->orWhere('forwarded_to', 'Waste Management')
                  ->orWhere('status', 'Rerouted to Waste Management');
            });

        $totalReports = $query->count();

        $pendingReportsCount  = (clone $query)->where('status', 'Pending')->count();
        $acceptedReportsCount = (clone $query)->where('status', 'Accepted')->count();
        $ongoingReportsCount  = (clone $query)->where('status', 'Ongoing')->count();
        $resolvedReportsCount = (clone $query)->where('status', 'Resolved')->count();

        $resolvedReports = (clone $query)->where('status', 'Resolved')->latest()->get();
        $reports = (clone $query)->latest()->take(5)->get();

        return view($view, compact(
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

    /**
     * 🔹 Forwarded & Rerouted Reports List
     */
    public function reportsSantafe()
    {
        $reports = ForwardedReport::where('location', 'Santa Fe')
            ->where(function ($q) {
                $q->where('category', 'Waste Management')
                  ->orWhere('forwarded_to', 'Waste Management')
                  ->orWhere('status', 'Rerouted to Waste Management');
            })
            ->whereIn('status', ['Forwarded', 'Pending', 'Ongoing', 'Rerouted to Waste Management'])
            ->latest()
            ->paginate(10);

        return view('waste.reports-santafe', compact('reports'));
    }

    public function reportsBantayan()
    {
        $reports = ForwardedReport::where('location', 'Bantayan')
            ->where(function ($q) {
                $q->where('category', 'Waste Management')
                  ->orWhere('forwarded_to', 'Waste Management')
                  ->orWhere('status', 'Rerouted to Waste Management');
            })
            ->whereIn('status', ['Forwarded', 'Pending', 'Ongoing', 'Rerouted to Waste Management'])
            ->latest()
            ->paginate(10);

        return view('waste.reports-bantayan', compact('reports'));
    }

    public function reportsMadridejos()
    {
        $reports = ForwardedReport::where('location', 'Madridejos')
            ->where(function ($q) {
                $q->where('category', 'Waste Management')
                  ->orWhere('forwarded_to', 'Waste Management')
                  ->orWhere('status', 'Rerouted to Waste Management');
            })
            ->whereIn('status', ['Forwarded', 'Pending', 'Ongoing', 'Rerouted to Waste Management'])
            ->latest()
            ->paginate(10);

        return view('waste.reports-madridejos', compact('reports'));
    }

    /**
     * 🔹 Update Report Status (with reroute handling)
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
                    'message' => 'Invalid status provided.'
                ], 400);
            }

            // 🔹 Look in Forwarded first
            $report = ForwardedReport::find($id);
            $isReroutedModel = false;

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

            $oldStatus = $report->status; // ✅ Capture old status before update

            // 🔹 Update status
            $report->status = $status;
            if ($request->filled('rerouted_to')) {
                if (Schema::hasColumn($report->getTable(), 'rerouted_to')) {
                    $report->rerouted_to = $request->input('rerouted_to');
                } elseif (Schema::hasColumn($report->getTable(), 'forwarded_to')) {
                    $report->forwarded_to = $request->input('rerouted_to');
                }
            }
            $report->save();

            // 🔹 If rerouted, create new entry in ReroutedReports
            if (str_starts_with($status, 'Rerouted to') && !$isReroutedModel) {
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
                'success'     => true,
                'message'     => 'Report status updated successfully.',
                'status'      => $report->status,
                'old_status'  => $oldStatus, // ✅ Send old status
                'rerouted_to' => $request->input('rerouted_to') ?? null,
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
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


    /**
     * 🔹 Announcements per location
     */
    public function santafeAnnouncements()
    {
        return $this->announcements('Santa Fe', 'waste.waste-santafe-announcements');
    }

    public function bantayanAnnouncements()
    {
        return $this->announcements('Bantayan', 'waste.waste-bantayan-announcements');
    }

    public function madridejosAnnouncements()
    {
        return $this->announcements('Madridejos', 'waste.waste-madridejos-announcements');
    }

    private function announcements($location, $view)
    {
        $announcements = PostAnnounce::where('location', $location)
            ->where('category', 'Waste Management')
            ->latest()
            ->get();

        return view($view, compact('announcements'));
    }
}
