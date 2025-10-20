<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class MunicipalAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'Admin');

        // ✅ Search
        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('location', 'like', '%' . $request->search . '%');
            });
        }

        $admins = $query->orderBy('location')->get();
        $groupedAdmins = $admins->groupBy('location');

        return view('admin.municipal.index', compact('groupedAdmins'));
    }

    // ✅ Disable Admin
    public function disable($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'disabled';
        $user->save();

        return redirect()->back()->with('success', 'Admin disabled successfully!');
    }

    // ✅ Enable Admin
    public function enable($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'active';
        $user->save();

        return redirect()->back()->with('success', 'Admin enabled successfully!');
    }
    public function update(Request $request, $id)
{
    $admin = User::findOrFail($id);

    $admin->name = $request->name;
    $admin->email = $request->email;
    $admin->location = $request->location;
    $admin->role = $request->role;
    $admin->status = $request->status;
    $admin->save();

    return response()->json([
        'success' => true,
        'id' => $admin->id,
        'name' => $admin->name,
        'email' => $admin->email,
        'location' => $admin->location,
        'role' => $admin->role,
        'status' => $admin->status,
    ]);
}

}
