<?php
namespace App\Http\Controllers;
use App\Models\Event;
use App\Models\ForwardedEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SantaFeEventController extends Controller
{public function index()
{
    $now = now();
    
    // Fetch events where event_date is today or in the future
    $events = Event::whereDate('event_date', '>=', $now->toDateString())
                    ->orderBy('event_date')
                    ->get();

    return view('santa_fe.events', compact('events'));
}
public function forward(Request $request, $id)
{
    $request->validate([
        'barangay' => 'required|string|max:100',
    ]);

    $event = Event::findOrFail($id);

   ForwardedEvent::create([
    'event_id'    => $event->id,
    'title'       => $event->title,
    'category' => $event->category,
    'location'    => $event->location,
    'start_date'  => $event->start_date,
    'end_date'    => $event->end_date,
    'event_time'  => $event->event_time ?? now()->toTimeString(),
    'event_date'  => $event->event_date ?? $event->start_date, // ✅ FIX: provide value here
    'barangay'    => $request->barangay,
    'forwarded_by'=> Auth::id(),
]);


    return redirect()->back()->with('success', 'Event forwarded successfully.');
} public function edit($id)
    {
        $event = Event::findOrFail($id);
        return view('santa_fe.events_edit', compact('event'));
    }

    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'location' => 'required|string|max:255',
            'event_date' => 'required|date',
            'event_time' => 'required',
        ]);

        $event->update($request->only(['title', 'category', 'location', 'event_date', 'event_time']));

        return redirect()->route('santa_fe.events')->with('success', 'Event updated successfully.');
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();

        return back()->with('success', 'Event deleted successfully.');
    }

}





