<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
public function index()
{
    $stafeReports = \App\Models\Report::with('user')
        ->where('location', 'Santa.Fe')
        ->latest()
        ->paginate(5, ['*'], 'stafe');

    $bantayanReports = \App\Models\Report::with('user')
        ->where('location', 'Bantayan')
        ->latest()
        ->paginate(5, ['*'], 'bantayan');

    $madridejosReports = \App\Models\Report::with('user')
        ->where('location', 'Madridejos')
        ->latest()
        ->paginate(5, ['*'], 'madridejos');

    $user = Auth::user(); // ✅ fetch logged-in user

    return view('admin.reports.index', compact(
        'stafeReports',
        'bantayanReports',
        'madridejosReports',
        'user' // ✅ pass to view
    ));
}


    public function show($id)
    {
        $report = Report::findOrFail($id);
        
        return view('admin.reports.show', compact('report'));
    }

    public function edit($id)
    {
        $report = Report::findOrFail($id);
        return view('admin.reports.edit', compact('report'));
    }

    public function destroy($id)
{
    // Find the report by ID, or fail if it doesn't exist
    $report = Report::findOrFail($id);

    // Delete the report
    $report->delete();

    // Redirect back to the previous page with a success message
    return redirect()->back()->with('success', 'Report deleted successfully.');
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
    }public function getPendingReports()
{
    return response()->json([
        'Santa Fe' => Report::where('location', 'Santa Fe')->where('status', 'Pending')->get(),
        'Madridejos' => Report::where('location', 'Madridejos')->where('status', 'Pending')->get(),
        'Bantayan' => Report::where('location', 'Bantayan')->where('status', 'Pending')->get(),
    ]);
}
public function getPendingReportsJson()
{
    return response()->json([
        'Bantayan' => Report::where('location', 'Bantayan')->where('status', 'Pending')->get(),
        'Madridejos' => Report::where('location', 'Madridejos')->where('status', 'Pending')->get(),
        'Santa Fe' => Report::where('location', 'Santa Fe')->where('status', 'Pending')->get(),
    ]);
}

}




