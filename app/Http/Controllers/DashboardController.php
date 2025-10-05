<?php

namespace App\Http\Controllers;

use App\Models\Alert;
use App\Models\Announcement;
use App\Models\Report;
use App\Models\Update;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;
use App\Models\ForwardedAnnouncement;
use App\Models\ForwardedEvent;
use App\Models\ForwardedReport;
use App\Models\WasteReport;

class DashboardController extends Controller
{
    public function dashboardSantaFe()
    {
        $user = Auth::user();
        $location = $user->location;

        // ✅ System alerts
        $alerts = Alert::where(function ($query) use ($location) {
                $query->where('location', $location)
                      ->orWhere('location', 'All');
            })
            ->where('is_read', false)
            ->latest()
            ->get();

        // ✅ Only logged-in user's reports
        $reports = Report::where('user_id', $user->id)
            ->where('location', $location)
            ->latest()
            ->take(5)
            ->get();

        $announcements = Announcement::where('location', $location)->latest()->take(5)->get();
        $updates = Update::where('location', $location)->latest()->take(5)->get();
        $events = Event::where('location', 'santafe')->latest()->take(10)->get();

        $forwardedAnnouncements = ForwardedAnnouncement::where('location', $location)
            ->orWhere('barangay', $location)
            ->latest()
            ->get();

        $forwardedEvents = ForwardedEvent::where(function ($query) use ($location) {
                $query->where('location', $location)
                      ->orWhere('barangay', $location);
            })
            ->whereDate('event_date', '>=', now()->toDateString())
            ->orderBy('event_date')
            ->get();

        // ✅ MDRRMO reports for this user
        $mddrmoAcceptedReports = ForwardedReport::where('user_id', $user->id)
            ->where('location', $location)
            ->where('status', 'Accepted')
            ->latest()
            ->get();

        $mddrmoOngoingReports = ForwardedReport::where('user_id', $user->id)
            ->where('location', $location)
            ->where('status', 'Ongoing')
            ->latest()
            ->get();

        $mddrmoResolvedReports = ForwardedReport::where('user_id', $user->id)
            ->where('location', $location)
            ->where('status', 'Resolved')
            ->latest()
            ->get();

        // ✅ Waste Management reports for this user
        $wasteAcceptedReports = WasteReport::where('user_id', $user->id)
            ->where('location', $location)
            ->where('status', 'Accepted')
            ->latest()
            ->get();

        $wasteOngoingReports = WasteReport::where('user_id', $user->id)
            ->where('location', $location)
            ->where('status', 'Ongoing')
            ->latest()
            ->get();

        $wasteResolvedReports = WasteReport::where('user_id', $user->id)
            ->where('location', $location)
            ->where('status', 'Resolved')
            ->latest()
            ->get();

        return view('dashboard.santafe', compact(
            'alerts',
            'reports',
            'announcements',
            'updates',
            'location',
            'events',
            'forwardedAnnouncements',
            'forwardedEvents',
            'mddrmoAcceptedReports',
            'mddrmoOngoingReports',
            'mddrmoResolvedReports',
            'wasteAcceptedReports',
            'wasteOngoingReports',
            'wasteResolvedReports'
        ));
    }

    public function redirectBasedOnRole()
    {
        $user = Auth::user();

        if ($user->location === 'admin') {
            return redirect()->route('dashboard.admin');
        }
    }

    public function dashboardBantayan()
    {
        $user = Auth::user();
        $location = $user->location;

        $alerts = Alert::where(function ($query) use ($location) {
                $query->where('location', $location)
                      ->orWhere('location', 'All');
            })
            ->where('is_read', false)
            ->latest()
            ->get();

        $reports = Report::where('user_id', $user->id)
            ->where('location', $location)
            ->latest()
            ->take(5)
            ->get();

        $announcements = Announcement::where('location', $location)->latest()->take(5)->get();
        $updates = Update::where('location', $location)->latest()->take(5)->get();
        $events = Event::where('location', 'bantayan')->latest()->take(10)->get();

        $forwardedAnnouncements = ForwardedAnnouncement::where('location', $location)
            ->orWhere('barangay', $location)
            ->latest()
            ->get();

        $forwardedEvents = ForwardedEvent::where(function ($query) use ($location) {
                $query->where('location', $location)
                      ->orWhere('barangay', $location);
            })
            ->whereDate('event_date', '>=', now()->toDateString())
            ->orderBy('event_date')
            ->get();

        $mddrmoAcceptedReports = ForwardedReport::where('user_id', $user->id)
            ->where('location', $location)
            ->where('status', 'Accepted')
            ->latest()
            ->get();

        $mddrmoOngoingReports = ForwardedReport::where('user_id', $user->id)
            ->where('location', $location)
            ->where('status', 'Ongoing')
            ->latest()
            ->get();

        $mddrmoResolvedReports = ForwardedReport::where('user_id', $user->id)
            ->where('location', $location)
            ->where('status', 'Resolved')
            ->latest()
            ->get();

        $wasteAcceptedReports = WasteReport::where('user_id', $user->id)
            ->where('location', $location)
            ->where('status', 'Accepted')
            ->latest()
            ->get();

        $wasteOngoingReports = WasteReport::where('user_id', $user->id)
            ->where('location', $location)
            ->where('status', 'Ongoing')
            ->latest()
            ->get();

        $wasteResolvedReports = WasteReport::where('user_id', $user->id)
            ->where('location', $location)
            ->where('status', 'Resolved')
            ->latest()
            ->get();

        return view('dashboard.bantayan', compact(
            'alerts',
            'reports',
            'announcements',
            'updates',
            'location',
            'events',
            'forwardedAnnouncements',
            'forwardedEvents',
            'mddrmoAcceptedReports',
            'mddrmoOngoingReports',
            'mddrmoResolvedReports',
            'wasteAcceptedReports',
            'wasteOngoingReports',
            'wasteResolvedReports'
        ));
    }

    public function dashboardMadridejos()
    {
        $user = Auth::user();
        $location = $user->location;

        $alerts = Alert::where(function ($query) use ($location) {
                $query->where('location', $location)
                      ->orWhere('location', 'All');
            })
            ->where('is_read', false)
            ->latest()
            ->get();

        $reports = Report::where('user_id', $user->id)
            ->where('location', $location)
            ->latest()
            ->take(5)
            ->get();

        $announcements = Announcement::where('location', $location)->latest()->take(5)->get();
        $updates = Update::where('location', $location)->latest()->take(5)->get();
        $events = Event::where('location', 'Madridejos')->latest()->take(10)->get();

        $forwardedAnnouncements = ForwardedAnnouncement::where('location', $location)
            ->orWhere('barangay', $location)
            ->latest()
            ->get();

        $forwardedEvents = ForwardedEvent::where(function ($query) use ($location) {
                $query->where('location', $location)
                      ->orWhere('barangay', $location);
            })
            ->whereDate('event_date', '>=', now()->toDateString())
            ->orderBy('event_date')
            ->get();

        $mddrmoAcceptedReports = ForwardedReport::where('user_id', $user->id)
            ->where('location', $location)
            ->where('status', 'Accepted')
            ->latest()
            ->get();

        $mddrmoOngoingReports = ForwardedReport::where('user_id', $user->id)
            ->where('location', $location)
            ->where('status', 'Ongoing')
            ->latest()
            ->get();

        $mddrmoResolvedReports = ForwardedReport::where('user_id', $user->id)
            ->where('location', $location)
            ->where('status', 'Resolved')
            ->latest()
            ->get();

        $wasteAcceptedReports = WasteReport::where('user_id', $user->id)
            ->where('location', $location)
            ->where('status', 'Accepted')
            ->latest()
            ->get();

        $wasteOngoingReports = WasteReport::where('user_id', $user->id)
            ->where('location', $location)
            ->where('status', 'Ongoing')
            ->latest()
            ->get();

        $wasteResolvedReports = WasteReport::where('user_id', $user->id)
            ->where('location', $location)
            ->where('status', 'Resolved')
            ->latest()
            ->get();

        return view('dashboard.madridejos', compact(
            'alerts',
            'reports',
            'announcements',
            'updates',
            'location',
            'events',
            'forwardedAnnouncements',
            'forwardedEvents',
            'mddrmoAcceptedReports',
            'mddrmoOngoingReports',
            'mddrmoResolvedReports',
            'wasteAcceptedReports',
            'wasteOngoingReports',
            'wasteResolvedReports'
        ));
    }

    public function index()
    {
        $forwardedAnnouncements = ForwardedAnnouncement::orderBy('created_at', 'desc')->get();

        return view('dashboard.admin', compact('forwardedAnnouncements'));
    }
}
