<?php

namespace App\Http\Controllers;
use App\Models\Announcement;
use App\Models\Report;
use Illuminate\Http\Request;
use App\Models\Feedback;
use Barryvdh\DomPDF\Facade\Pdf;

class BantayanController extends Controller
{
   public function feedback()
{
    $feedbacks = Feedback::with('user')
        ->whereHas('user', function ($query) {
            $query->where('location', 'Bantayan');
        })
        ->latest()
        ->get();

    return view('bantayan.feedback', compact('feedbacks'));
}
    public function announcements()
{
    $announcements = Announcement::where('location', 'Bantayan')
    ->latest()
    ->paginate(10); // or any number of items per page


    return view('bantayan.announcements', compact('announcements'));
}
public function createAnnouncement()
{
    return view('bantayan.create-announcement');
}

public function storeAnnouncement(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required|string',
    ]);

    Announcement::create([
        'title' => $request->title,
        'content' => $request->content,
    ]);

    return redirect()->route('bantayan.announcements')->with('success', 'Announcement posted successfully!');
}
public function forwardAnnouncement(Request $request, $id)
{
    $request->validate([
        'barangay' => 'required|string',
    ]);

    $announcement = Announcement::findOrFail($id);

    // Example logic: You can store it in another table or send a notification
    // For now, just flash a message for confirmation

    return redirect()->route('bantayan.announcements')->with('success', 'Announcement forwarded to ' . $request->barangay . ' successfully!');
}
public function reports(Request $request)
{
    $query = Report::with('user') // Eager load the user relationship
                   ->where('location', 'Bantayan'); // Filter by location

    // Filter by status (default to 'Pending')
    if ($request->has('status') && $request->status !== '') {
        $query->where('status', $request->status);
    } else {
        $query->where('status', 'Pending');
    }

    // Optional date range filter
    if ($request->filled('date')) {
        $range = explode(' to ', $request->date);
        if (count($range) === 2) {
            $start = date('Y-m-d', strtotime($range[0]));
            $end = date('Y-m-d', strtotime($range[1]));
            $query->whereBetween('created_at', [$start, $end]);
        }
    }

    // Paginate the result (10 per page)
    $reports = $query->latest()->paginate(10);

    return view('bantayan.reports', compact('reports'));
}

public function export(Report $report)
{
    $pdf = Pdf::loadView('bantayan.export', compact('report'));
    return $pdf->download('report-'.$report->id.'.pdf');
}
public function show($id)
{
    $report = Report::with('user')->findOrFail($id);

    return response()->json([
        'id' => $report->id,
        'title' => $report->title,
        'description' => $report->description,
        'location' => $report->location,
        'status' => $report->status,
        'created_at' => $report->created_at->format('M d, Y H:i'),
        'photo' => $report->photo ? asset('storage/' . $report->photo) : null,
    ]);
}

}
