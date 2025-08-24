<?php

namespace App\Http\Controllers;
use App\Models\Announcement;
use App\Models\Report;
use Illuminate\Http\Request;
use App\Models\Feedback;
use Barryvdh\DomPDF\Facade\Pdf;

class SantaFeController extends Controller
{
    public function feedback()
    {
        $feedbacks = Feedback::with('user')->latest()->paginate(10);
        return view('santa_fe.feedback', compact('feedbacks'));
        
    }
    public function announcements()
{
    $announcements = Announcement::latest()->paginate(5);
    return view('santa_fe.announcements', compact('announcements'));
}public function createAnnouncement()
{
    return view('santa_fe.create-announcement');
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

    return redirect()->route('santafe.announcements')->with('success', 'Announcement posted successfully!');
}
public function forwardAnnouncement(Request $request, $id)
{
    $request->validate([
        'barangay' => 'required|string',
    ]);

    $announcement = Announcement::findOrFail($id);

    // Example logic: You can store it in another table or send a notification
    // For now, just flash a message for confirmation

    return redirect()->route('santafe.announcements')->with('success', 'Announcement forwarded to ' . $request->barangay . ' successfully!');
}
public function reports(Request $request)
{
    $query = Report::with('user') // Eager load the user relationship
                   ->where('location', 'Santa.Fe'); // Filter by location

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

    return view('santa_fe.reports', compact('reports'));
}

public function export(Report $report)
{
    $pdf = Pdf::loadView('santa_fe.export', compact('report'));
    return $pdf->download('report-'.$report->id.'.pdf');
}
public function forward(Request $request)
{
    $request->validate([
        'report_id' => 'required|exists:reports,id',
        'forwarded_to' => 'required|string|max:255',
    ]);

    $report = Report::findOrFail($request->report_id);

    // Insert into forwarded_reports table
    \App\Models\ForwardedReport::create([
        'report_id' => $report->id,
        'forwarded_to' => $request->forwarded_to,
        'status' => 'Forwarded',
        'user_id' => auth()->id(),
        'location' => $report->location,
        'title' => $report->title,
        'description' => $report->description,
        'category' => $report->category,
        'photo' => $report->photo,
    ]);

    // Update original report status
    $report->status = 'Forwarded';
    $report->save();

    return response()->json(['success' => true, 'message' => 'Report forwarded successfully!']);
}


}
