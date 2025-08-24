<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class SantaFeUserController extends Controller
{
    public function index()
{
    $users = User::where('location', 'Santa.Fe')
                ->where(function ($query) {
                    $query->where('id', '!=', Auth::id())
                          ->orWhere('role', '!=', 'admin');
                })
                ->get();

    return view('santa_fe.manage_users', compact('users'));
}

    public function edit($id)
{
    $user = \App\Models\User::findOrFail($id);

    return view('santa_fe.edit', compact('user'));
}
public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    $user->update([
        'name' => $request->input('name'),
        'email' => $request->input('email'),
        'barangay' => $request->input('barangay'),
        // add more fields as needed
    ]);

    return redirect()->route('santafe.users.index')->with('success', 'User updated successfully.');
}

}

