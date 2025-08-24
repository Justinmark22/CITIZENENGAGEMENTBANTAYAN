<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class BantayanUserController extends Controller
{
    public function index()
{
    $users = User::where('location', 'Bantayan') // or adjust based on your DB column
                ->where('email', '!=', 'admin@santafe.gov') // exclude admin
                ->orderBy('created_at', 'desc')
                ->get();

    return view('bantayan.users.index', compact('users'));
}
    public function edit($id)
{
    $user = \App\Models\User::findOrFail($id);

    return view('bantayan.edit', compact('user'));
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

    return redirect()->route('bantayan.users.index')->with('success', 'User updated successfully.');
}public function destroy($id)
{
    $user = User::findOrFail($id);
    $user->delete();

    return redirect()->route('bantayan.users.index')->with('success', 'User deleted successfully.');
}


}

