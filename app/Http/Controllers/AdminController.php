<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Store a newly created admin in storage.
     */
    public function store(Request $request)
    {
        // ✅ Validate the incoming request
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'location' => 'required|string',
            'role'     => 'required|string|in:admin,fire,waste,water,mdrrmo', // added role validation
        ]);

        // ✅ Create the admin account
        $admin = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'location' => $request->location,
            'role'     => $request->role, // use the selected role
            'status'   => 'active',
        ]);

        // ✅ Redirect back with success message
        return redirect()->back()->with('success', '✅ New ' . ucfirst($request->role) . ' admin added successfully!');
    }
}
