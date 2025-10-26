<?php

namespace App\Http\Controllers;
use App\Models\Announcement;

use Illuminate\Http\Request;
use App\Models\Report;

class ReportController extends Controller
{public function store(Request $request)
{
    $validated = $request->validate([
        'category' => 'required|string',
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'photo' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048', // Validation for photo
    ]);

    // ✅ Assign default values
    $validated['status'] = 'Pending';
    $validated['location'] = auth()->user()->location ?? 'Unknown';
    $validated['user_id'] = auth()->id();

    // Check if a photo was uploaded
    if ($request->hasFile('photo')) {
        // Get the file
        $file = $request->file('photo');

        // Generate a unique name for the photo
        $filename = time() . '.' . $file->getClientOriginalExtension();

        // Store the photo in the 'public' directory and get its path
        $filePath = $file->storeAs('reports/photos', $filename, 'public');

        // Add the file path to the validated data
        $validated['photo'] = $filePath;
    }

    // Create the report
    Report::create($validated);

    return redirect()->back()->with('success', 'Report submitted!');
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