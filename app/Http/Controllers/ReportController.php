<?php

namespace App\Http\Controllers;
use App\Models\Announcement;

use Illuminate\Http\Request;
use App\Models\Report;

class ReportController extends Controller
{
   public function store(Request $request)
{
    $validated = $request->validate([
        'category' => 'required|string|max:255',
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $report = new Report();
    $report->category = $validated['category'];
    $report->title = $validated['title'];
    $report->description = $validated['description'];

    // ✅ Handle photo upload
    if ($request->hasFile('photo')) {
        // store in "storage/app/public/reports"
        $path = $request->file('photo')->store('reports', 'public');
        $report->photo = $path; // just save relative path like "reports/abc.jpg"
    }

    $report->status = 'Pending';
    $report->user_id = auth()->id() ?? null;
    $report->save();

    return redirect()->back()->with('success', 'Your concern has been submitted successfully.');
}


public function stafeDashboard()
{
    $reports = Report::latest()->take(5)->get();
    $announcements = Announcement::where('location', 'Santa.Fe')
                                  ->latest()
                                  ->take(5)
                                  ->get();

    return view('dashboard.santafe', compact('reports', 'announcements'));
}

public function bantayanDashboard()
{
    $reports = Report::latest()->take(5)->get();
    return view('dashboard.bantayan', compact('reports'));
}
 public function index()
    {
        // Fetch reports from the database (adjust as necessary)
        $reports = Report::latest()->paginate(10);  // Paginate if needed

        // Return the view with the reports data
        return view('admin.reports.index', compact('reports'));
    }
     public function updateStatus(Request $request, $id)
    {
        // Find the report by ID, or fail if it doesn't exist
        $report = Report::findOrFail($id);

        // Update the status of the report based on the input from the form
        $report->status = $request->input('status');
        
        // Save the updated report to the database
        $report->save();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Report status updated.');
    }
}
