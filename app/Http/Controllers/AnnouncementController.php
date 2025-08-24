<?php

// app/Http/Controllers/AnnouncementController.php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    // Show the form to add a new announcement
    public function create()
    {
        
        return view('admin.announcements.create');
    }

public function store(Request $request)
{
$request->validate([
    'title' => 'required|string|max:255',
    'message' => 'required|string|max:500',
    'location' => 'required|string',
    'start_date' => 'required|date|before_or_equal:end_date',
    'end_date' => 'required|date|after_or_equal:start_date',
]);

// Create the announcement with time frame
Announcement::create([
    'title' => $request->title,
    'message' => $request->message,
    'location' => $request->location,
    'start_date' => $request->start_date,
    'end_date' => $request->end_date,
]);


    return redirect()->route('admin.announcements.create')->with('success', 'Announcement added successfully!');
}

    // Display all announcements
   public function index(Request $request)
{
    $query = Announcement::query();

    if ($request->has(['start_date', 'end_date'])) {
        $query->where(function ($q) use ($request) {
            $q->whereDate('start_date', '<=', $request->end_date)
              ->whereDate('end_date', '>=', $request->start_date);
        });
    }

    $announcements = $query->latest()->get();
    return view('admin.announcements.index', compact('announcements'));

    }public function edit($id)
{
    $announcement = Announcement::findOrFail($id);
    return view('admin.announcements.edit', compact('announcement'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'message' => 'required|string',
    ]);

    $announcement = Announcement::findOrFail($id);
    $announcement->update($request->only('title', 'message'));

    return redirect()->route('admin.announcements.index')->with('success', 'Announcement updated successfully.');
}
public function destroy($id)
{
    $announcement = Announcement::findOrFail($id);
    $announcement->delete();

    return redirect()->route('admin.announcements.index')->with('success', 'Announcement deleted successfully.');
}

}
