<?php

namespace App\Http\Controllers\Admin;

use App\Models\User; 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{public function index(Request $request)
{
    $query = User::where(function ($q) {
        $q->whereNull('role')
          ->orWhereRaw('LOWER(role) != ?', ['admin']);
    })
    ->where(function ($q) {
        $q->whereNull('location')
          ->orWhereRaw('LOWER(location) != ?', ['admin']);
    });

    if ($request->has('search') && $request->search != '') {
        $query->where(function($query) use ($request) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
        });
    }

    $users = $query->orderBy('created_at', 'desc')->paginate(20);
    $groupedUsers = $users->getCollection()->groupBy('location');

    return view('admin.users.index', compact('users', 'groupedUsers'));
}



    public function edit($id)
{
    // Retrieve the user by ID
    $user = User::findOrFail($id);

    // Define the list of locations (you can also fetch this from a DB table)
    $locations = ['Bantayan', 'Santa.Fe', 'Madridejos'];

    // Return the edit view with user and locations
    return view('admin.users.edit', compact('user', 'locations'));
}


    public function update(Request $request, $id)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'location' => 'required|string|max:255',
        ]);

        // Find the user by ID
        $user = User::findOrFail($id);

        // Update the user with the validated data
        $user->update($validated);

        // Redirect back to the user list with a success message
        return redirect()->route('admin.users.index')->with('success', 'User updated successfully');
    }

    public function destroy($id)
    {
        // Find the user by ID
        $user = User::findOrFail($id);
        
        // Delete the user
        $user->delete();

        // Redirect back to the user list with a success message
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully');
    }
}

