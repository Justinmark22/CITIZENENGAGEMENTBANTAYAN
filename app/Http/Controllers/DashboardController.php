<?php

namespace App\Http\Controllers;

use App\Models\Alert;
use App\Models\Announcement;
use App\Models\Report;
use App\Models\Update; // Make sure to include this
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

    // System alerts
    $alerts = Alert::where(function($query) use ($location) {
                    $query->where('location', $location)
                          ->orWhere('location', 'All');
                })
                ->where('is_read', false)
                ->latest()
                ->get();

    $reports = Report::where('location', $location)->latest()->take(5)->get();
    $announcements = Announcement::where('location', $location)->latest()->take(5)->get();
    $updates = Update::where('location', $location)->latest()->take(5)->get();
    $events = Event::where('location', 'santafe')->latest()->take(10)->get();

    $forwardedAnnouncements = ForwardedAnnouncement::where('location', $location)
            ->orWhere('barangay', $location)
            ->latest()
            ->get();

    $forwardedEvents = ForwardedEvent::where(function($query) use ($location) {
            $query->where('location', $location)
                  ->orWhere('barangay', $location);
        })
        ->whereDate('event_date', '>=', now()->toDateString())
        ->orderBy('event_date')
        ->get();

    // ✅ MDRRMO reports
    $mddrmoAcceptedReports = ForwardedReport::where('location', $location)
        ->where('status', 'Accepted')
        ->latest()
        ->get();

    $mddrmoOngoingReports = ForwardedReport::where('location', $location)
        ->where('status', 'Ongoing')
        ->latest()
        ->get();

    $mddrmoResolvedReports = ForwardedReport::where('location', $location)
        ->where('status', 'Resolved')
        ->latest()
        ->get();

    // ✅ Waste Management reports
    $wasteAcceptedReports = WasteReport::where('location', $location)
        ->where('status', 'Accepted')
        ->latest()
        ->get();

    $wasteOngoingReports = WasteReport::where('location', $location)
        ->where('status', 'Ongoing')
        ->latest()
        ->get();

    $wasteResolvedReports = WasteReport::where('location', $location)
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
    // For testing, you can set a specific user ID
    // $userId = 2; // or 13, 66, etc.
    $user = Auth::user();
    $userId = $user->id; 
    $location = $user->location;

    // System alerts
    $alerts = Alert::where(function($query) use ($location) {
            $query->where('location', $location)
                  ->orWhere('location', 'All');
        })
        ->where('is_read', false)
        ->latest()
        ->get();

    // Only this user's reports
    $reports = Report::where('location', $location)
        ->where('user_id', $userId)
        ->latest()
        ->take(5)
        ->get();

    $announcements = Announcement::where('location', $location)
        ->latest()
        ->take(5)
        ->get();

    $updates = Update::where('location', $location)
        ->latest()
        ->take(5)
        ->get();

    $events = Event::where('location', $location)
        ->latest()
        ->take(10)
        ->get();

    $forwardedAnnouncements = ForwardedAnnouncement::where('location', $location)
        ->orWhere('barangay', $location)
        ->latest()
        ->get();

    $forwardedEvents = ForwardedEvent::where(function($query) use ($location) {
            $query->where('location', $location)
                  ->orWhere('barangay', $location);
        })
        ->whereDate('event_date', '>=', now()->toDateString())
        ->orderBy('event_date')
        ->get();

    // MDRRMO reports filtered by this user
    $mddrmoAcceptedReports = ForwardedReport::where('location', $location)
        ->where('user_id', $userId)
        ->where('status', 'Accepted')
        ->latest()
        ->get();

    $mddrmoOngoingReports = ForwardedReport::where('location', $location)
        ->where('user_id', $userId)
        ->where('status', 'Ongoing')
        ->latest()
        ->get();

    $mddrmoResolvedReports = ForwardedReport::where('location', $location)
        ->where('user_id', $userId)
        ->where('status', 'Resolved')
        ->latest()
        ->get();

    // Waste reports filtered by this user
    $wasteAcceptedReports = WasteReport::where('location', $location)
        ->where('user_id', $userId)
        ->where('status', 'Accepted')
        ->latest()
        ->get();

    $wasteOngoingReports = WasteReport::where('location', $location)
        ->where('user_id', $userId)
        ->where('status', 'Ongoing')
        ->latest()
        ->get();

    $wasteResolvedReports = WasteReport::where('location', $location)
        ->where('user_id', $userId)
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

    // System alerts
    $alerts = Alert::where(function($query) use ($location) {
                    $query->where('location', $location)
                          ->orWhere('location', 'All');
                })
                ->where('is_read', false)
                ->latest()
                ->get();

    $reports = Report::where('location', $location)->latest()->take(5)->get();
    $announcements = Announcement::where('location', $location)->latest()->take(5)->get();
    $updates = Update::where('location', $location)->latest()->take(5)->get();
    $events = Event::where('location', 'Madridejos')->latest()->take(10)->get();

    $forwardedAnnouncements = ForwardedAnnouncement::where('location', $location)
            ->orWhere('barangay', $location)
            ->latest()
            ->get();

    $forwardedEvents = ForwardedEvent::where(function($query) use ($location) {
            $query->where('location', $location)
                  ->orWhere('barangay', $location);
        })
        ->whereDate('event_date', '>=', now()->toDateString())
        ->orderBy('event_date')
        ->get();

    // ✅ MDRRMO reports
    $mddrmoAcceptedReports = ForwardedReport::where('location', $location)
        ->where('status', 'Accepted')
        ->latest()
        ->get();

    $mddrmoOngoingReports = ForwardedReport::where('location', $location)
        ->where('status', 'Ongoing')
        ->latest()
        ->get();

    $mddrmoResolvedReports = ForwardedReport::where('location', $location)
        ->where('status', 'Resolved')
        ->latest()
        ->get();

    // ✅ Waste Management reports
    $wasteAcceptedReports = WasteReport::where('location', $location)
        ->where('status', 'Accepted')
        ->latest()
        ->get();

    $wasteOngoingReports = WasteReport::where('location', $location)
        ->where('status', 'Ongoing')
        ->latest()
        ->get();

    $wasteResolvedReports = WasteReport::where('location', $location)
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
