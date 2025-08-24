<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SantaFeAnnouncementController extends Controller
{
    public function forward(Request $request, $id)
    {
        $request->validate([
            'barangay' => 'required|string|max:255',
        ]);

        $announcement = Announcement::findOrFail($id);

        DB::table('forwarded_announcements')->insert([
            'announcement_id' => $announcement->id,
            'title' => $announcement->title,
            'message' => $announcement->body ?? $announcement->message,
            'location' => $announcement->location,
            'start_date' => $announcement->start_date,
            'end_date' => $announcement->end_date,
            'barangay' => $request->barangay,
            'forwarded_by' => Auth::id(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Announcement forwarded successfully!');
    }
    public function edit($id)
{
    $announcement = Announcement::findOrFail($id);
    return view('santa_fe.announcement_edit', compact('announcement'));
}

public function update(Request $request, $id)
{
    $announcement = Announcement::findOrFail($id);

$validated = $request->validate([
    'title' => 'required|string|max:255',
    'message' => 'required|string', // ✅ change from 'body' to 'message'
    'location' => 'required|string|max:255',
    'start_date' => 'required|date',
    'end_date' => 'required|date|after_or_equal:start_date',
]);

$announcement->update([
    'title' => $request->title,
    'message' => $request->message,
    'location' => $request->location,
    'start_date' => $request->start_date,
    'end_date' => $request->end_date,
]);

    return redirect()->route('santafe.announcements') // ✅ Correct route name here
                     ->with('success', 'Announcement updated successfully!');
}



public function destroy($id)
{
    Announcement::destroy($id);
    return redirect()->back()->with('success', 'Announcement deleted.');
}
}

