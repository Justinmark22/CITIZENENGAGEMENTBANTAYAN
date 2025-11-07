<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ForwardedEvent;        // ✅ Forwarded events
use App\Models\ForwardedAnnouncement; // ✅ Forwarded announcements

class EventsAndAnnouncementController extends Controller
{
    // Bantayan
    public function bantayan()
    {
        $events = ForwardedEvent::where('location', 'Bantayan')->get();
        $announcements = ForwardedAnnouncement::where('location', 'Bantayan')->get();

        return view('eventsandannouncements.bantayan', compact('events', 'announcements'));
    }

    // Madridejos
    public function madridejos()
    {
        $events = ForwardedEvent::where('location', 'Madridejos')->get();
        $announcements = ForwardedAnnouncement::where('location', 'Madridejos')->get();

        return view('eventsandannouncements.madridejos', compact('events', 'announcements'));
    }

    // Santa Fe
    public function santafe()
    {
        $events = ForwardedEvent::where('location', 'Santa Fe')->get();
        $announcements = ForwardedAnnouncement::where('location', 'Santa Fe')->get();

        return view('eventsandannouncements.santafe', compact('events', 'announcements'));
    }
    // In your Controller
public function getForwardedNotificationsCount()
{
    $announcementsCount = \App\Models\Announcement::where('forwarded', 1)->count();
    $eventsCount = \App\Models\Event::where('forwarded', 1)->count();

    return response()->json([
        'count' => $announcementsCount + $eventsCount
    ]);
}

}
