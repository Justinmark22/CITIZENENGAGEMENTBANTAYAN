<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ForwardedEvent;        
use App\Models\ForwardedAnnouncement; 
use App\Models\Event;
use App\Models\Announcement;
use App\Models\PostAnnounce; // ✅ Added

class EventsAndAnnouncementController extends Controller
{
    // ✅ Bantayan
    public function bantayan()
    {
        $events = ForwardedEvent::where('location', 'Bantayan')->get();
        $announcements = ForwardedAnnouncement::where('location', 'Bantayan')->get();

        return view('eventsandannouncements.bantayan', compact('events', 'announcements'));
    }

    // ✅ Madridejos
    public function madridejos()
    {
        $events = ForwardedEvent::where('location', 'Madridejos')->get();
        $announcements = ForwardedAnnouncement::where('location', 'Madridejos')->get();

        return view('eventsandannouncements.madridejos', compact('events', 'announcements'));
    }

    // ✅ Santa Fe
    public function santafe()
    {
        $events = ForwardedEvent::where('location', 'Santa Fe')->get();
        $announcements = ForwardedAnnouncement::where('location', 'Santa Fe')->get();

        return view('eventsandannouncements.santafe', compact('events', 'announcements'));
    }

    // ✅ Fetch total count of forwarded notifications (Announcements + Events + Posts)
    public function getForwardedNotificationsCount()
    {
        $announcementsCount = Announcement::where('forwarded', 1)->count();
        $eventsCount = Event::where('forwarded', 1)->count();
        $postAnnounceCount = PostAnnounce::where('forwarded', 1)->count(); // ✅ Added

        return response()->json([
            'count' => $announcementsCount + $eventsCount + $postAnnounceCount
        ]);
    }
}
