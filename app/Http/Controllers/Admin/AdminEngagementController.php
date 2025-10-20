<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Engagement;

class AdminEngagementController extends Controller
{
    public function index()
{
    $engagements = Engagement::latest()->get();
    return view('admin.engagements.index', compact('engagements'));
}

public function create()
{
    return view('admin.engagements.create');
}

public function store(Request $request)
{
    $request->validate([
        'title' => 'required',
        'host' => 'required',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'description' => 'required',
    ]);

    Engagement::create($request->all());

    return redirect()->route('admin.engagements.index')->with('success', 'Engagement posted successfully.');
}

public function show($id)
{
    $engagement = Engagement::findOrFail($id);
    return view('admin.engagements.show', compact('engagement'));
}

public function chartData($id)
{
    $engagement = Engagement::findOrFail($id);

    $labels = ['Start Date', 'End Date'];
    $datasets = [
        [
            'label' => 'Engagement Duration',
            'data' => [
                strtotime($engagement->start_date),
                strtotime($engagement->end_date)
            ],
        ]
    ];

    return response()->json([
        'labels' => $labels,
        'datasets' => $datasets,
    ]);
}public function destroy($id)
{
    $engagement = Engagement::findOrFail($id);
    $engagement->delete();

    return response()->json(['success' => true]);
}


}