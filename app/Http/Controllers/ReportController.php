<?php

namespace App\Http\Controllers;
use App\Models\Announcement;

use Illuminate\Http\Request;
use App\Models\Report;

class ReportController extends Controller
{
    public function store(Request $request)
{
    // ✅ Validate the form input
    $validated = $request->validate([
        'category' => 'required|string',
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'photo' => 'nullable|image|max:2048',
    ]);

    // ✅ Handle image upload (store in storage/app/public/reports)
    if ($request->hasFile('photo')) {
        $photo = $request->file('photo');
        $photoName = time() . '_' . uniqid() . '.' . $photo->getClientOriginalExtension();

        // Store and get relative path like 'reports/xxxx.jpg'
        $photo->storeAs('public/reports', $photoName);
        $validated['photo'] = 'reports/' . $photoName;
    }

    // ✅ Default + relational fields
    $validated['status'] = 'Pending';
    $validated['location'] = auth()->user()->location ?? 'Unknown';
    $validated['user_id'] = auth()->id();

    // ✅ Save report to database
    Report::create($validated);

    // ✅ Return success message
    return redirect()->back()->with('success', 'Report submitted successfully!');
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
