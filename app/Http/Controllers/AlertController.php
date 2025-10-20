<?php

namespace App\Http\Controllers;

use App\Models\Alert;
use Illuminate\Http\Request;

class AlertController extends Controller
{
    // ✅ Store new alert
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'location' => 'required|string',
        ]);

        Alert::create([
            'title' => $request->title,
            'message' => $request->message,
            'location' => $request->location,
        ]);

        return redirect()->back()->with('alert_success', '🚨 Alert submitted successfully!');
    }

    // ✅ Get alerts for user (filter by location and unread)
    public function getAlerts()
    {
        $user = auth()->user();

        $alerts = Alert::where(function ($query) use ($user) {
                $query->where('location', $user->location)
                      ->orWhere('location', 'All');
            })
            ->where('is_read', false)
            ->latest()
            ->get();

        return response()->json($alerts);
    }

    // ✅ Mark alerts as read
    public function markAsRead()
    {
        $user = auth()->user();

        Alert::where(function ($query) use ($user) {
                $query->where('location', $user->location)
                      ->orWhere('location', 'All');
            })
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }
}
