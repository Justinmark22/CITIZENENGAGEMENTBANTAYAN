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



class DashboardController extends Controller
{
    public function dashboardSantaFe()
    {
        $user = Auth::user();  
        $location = $user->location;  

$alerts = Alert::where(function($query) use ($location) {
                $query->where('location', $location)
                      ->orWhere('location', 'All');
            })
            ->where('is_read', false)
            ->latest()
            ->get();


        $reports = Report::where('location', $location)->latest()->take(5)->get();
        $announcements = Announcement::where('location', $location)->latest()->take(5)->get();
        $updates = Update::where('location', $location)->latest()->take(5)->get(); // 👈 Add this line
        $events = Event::where('location', 'Santa.Fe')->latest()->take(10)->get();
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


        // Optional debugging
        if ($alerts->isEmpty()) {
            \Log::info('No alerts found for location: ' . $location);
        }
        if ($reports->isEmpty()) {
            \Log::info('No reports found for location: ' . $location);
        }
        if ($announcements->isEmpty()) {
            \Log::info('No announcements found for location: ' . $location);
        }
        if ($updates->isEmpty()) {
            \Log::info('No updates found for location: ' . $location);
        }

        return view('dashboard.santafe', compact('alerts', 'reports', 'announcements', 'updates', 'location','events','forwardedAnnouncements','forwardedEvents' )); // 👈 Include $updates
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

$alerts = Alert::where(function($query) use ($location) {
                $query->where('location', $location)
                      ->orWhere('location', 'All');
            })
            ->where('is_read', false)
            ->latest()
            ->get();


        $reports = Report::where('location', $location)->latest()->take(5)->get();
        $announcements = Announcement::where('location', $location)->latest()->take(5)->get();
        $updates = Update::where('location', $location)->latest()->take(5)->get(); // 👈 Add this line
        $events = Event::where('location', 'Bantayan')->latest()->take(10)->get();
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


        // Optional debugging
        if ($alerts->isEmpty()) {
            \Log::info('No alerts found for location: ' . $location);
        }
        if ($reports->isEmpty()) {
            \Log::info('No reports found for location: ' . $location);
        }
        if ($announcements->isEmpty()) {
            \Log::info('No announcements found for location: ' . $location);
        }
        if ($updates->isEmpty()) {
            \Log::info('No updates found for location: ' . $location);
        }

        return view('dashboard.bantayan', compact('alerts', 'reports', 'announcements', 'updates', 'location','events','forwardedAnnouncements','forwardedEvents' )); // 👈 Include $updates
    }
public function dashboardMadridejos()
    {
        $user = Auth::user();  
        $location = $user->location;  

$alerts = Alert::where(function($query) use ($location) {
                $query->where('location', $location)
                      ->orWhere('location', 'All');
            })
            ->where('is_read', false)
            ->latest()
            ->get();


        $reports = Report::where('location', $location)->latest()->take(5)->get();
        $announcements = Announcement::where('location', $location)->latest()->take(5)->get();
        $updates = Update::where('location', $location)->latest()->take(5)->get(); // 👈 Add this line
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


        // Optional debugging
        if ($alerts->isEmpty()) {
            \Log::info('No alerts found for location: ' . $location);
        }
        if ($reports->isEmpty()) {
            \Log::info('No reports found for location: ' . $location);
        }
        if ($announcements->isEmpty()) {
            \Log::info('No announcements found for location: ' . $location);
        }
        if ($updates->isEmpty()) {
            \Log::info('No updates found for location: ' . $location);
        }

        return view('dashboard.madridejos', compact('alerts', 'reports', 'announcements', 'updates', 'location','events','forwardedAnnouncements','forwardedEvents' )); // 👈 Include $updates
    }
public function index()
{
    $forwardedAnnouncements = ForwardedAnnouncement::orderBy('created_at', 'desc')->get();

    return view('dashboard.admin', compact('forwardedAnnouncements'));
}

}
