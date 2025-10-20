<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    public function create()
    {
        return view('admin.events.create');
    }
public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'location' => 'required|string|max:100',
        'category' => 'required|string|max:100',
        'event_date' => 'required|date',
        'event_time' => 'required'
    ]);

    $event = Event::create($validated);

    return response()->json($event); // ✅ JavaScript can now handle this!
}

    public function getAll()
{
    $events = \App\Models\Event::orderBy('created_at', 'desc')->get();
    return response()->json($events);
}
public function destroy($id)
{
    $event = \App\Models\Event::find($id);
    
    if (!$event) {
        return response()->json(['success' => false, 'message' => 'Event not found.'], 404);
    }

    $event->delete();

    return response()->json(['success' => true, 'message' => 'Event deleted successfully.']);
}
public function update(Request $request, $id)
{
    $event = Event::findOrFail($id);
    $event->update($request->all());

    return response()->json($event);
}

}
