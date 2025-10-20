<?php

namespace App\Http\Controllers;
use App\Models\Comment;
use App\Models\Engagement;
use Illuminate\Http\Request;

class EngagementController extends Controller
{
public function index()
{
    $engagements = Engagement::latest()->get();
    return view('engagements', compact('engagements')); // ✅ updated
}

public function show($id)
{
    $engagement = Engagement::with('comments')->findOrFail($id);
    return view('engagement_show', compact('engagement'));
}

public function postComment(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'message' => 'required|string'
    ]);

    Comment::create([
        'engagement_id' => $id,
        'name' => $request->name,
        'message' => $request->message,
    ]);

    return redirect()->back()->with('success', 'Comment posted!');
}}