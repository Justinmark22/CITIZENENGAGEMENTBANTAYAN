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
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6',
        'location' => 'required|string',
    ]);

    $admin = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'location' => $request->location,
        'role' => 'admin',
        'status' => 'active',
    ]);

    return redirect()->back()->with('success', '✅ New admin added successfully!');
}

}
