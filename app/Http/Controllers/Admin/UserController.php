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
    $user = \App\Models\User::findOrFail($id);

    // Create a trash folder if it doesn't exist
    $trashPath = storage_path('app/trash');
    if (!file_exists($trashPath)) {
        mkdir($trashPath, 0777, true);
    }

    // Load existing trash file if it exists
    $trashFile = $trashPath . '/users.json';
    $trashData = [];

    if (file_exists($trashFile)) {
        $content = file_get_contents($trashFile);
        $trashData = json_decode($content, true) ?: [];
    }

    // Add deleted user data to trash
    $trashData[] = [
        'id'        => $user->id,
        'name'      => $user->name,
        'email'     => $user->email,
        'location'  => $user->location,
        'role'      => $user->role,
        'deleted_at'=> now()->toDateTimeString(),
    ];

    // Save updated trash file
    file_put_contents($trashFile, json_encode($trashData, JSON_PRETTY_PRINT));

    // Delete user from DB
    $user->delete();

    return redirect()->route('admin.users.index')
        ->with('success', 'User has been moved to trash file.');
}public function backup()
{
    // Full path to your trash JSON file
    $trashFile = storage_path('app/trash/users.json');

    // Default empty array
    $trashData = [];

    if (file_exists($trashFile)) {
        // Read the file content
        $content = file_get_contents($trashFile);

        // Decode JSON safely
        $decoded = json_decode($content, true);

        // Ensure valid JSON and it's an array
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            $trashData = $decoded;
        } else {
            // Optional: log or debug invalid JSON
            \Log::warning('Invalid JSON format in users.json file.');
        }
    } else {
        \Log::info('No trash file found at ' . $trashFile);
    }

    // Return your backup view with data
    return view('admin.users.backup', compact('trashData'));
}
public function restore($id)
{
    $path = storage_path('app/trash/users.json');

    if (!file_exists($path)) {
        return response()->json(['error' => 'Trash file not found.'], 404);
    }

    $trashData = json_decode(file_get_contents($path), true);

    if (empty($trashData)) {
        return response()->json(['error' => 'No users found in trash.'], 404);
    }

    $userData = collect($trashData)->firstWhere('id', (int)$id);

    if (!$userData) {
        return response()->json(['error' => 'User not found in trash.'], 404);
    }

    try {
        // Try to restore or recreate the user
        \App\Models\User::withTrashed()->updateOrCreate(
            ['id' => $userData['id']],
            [
                'name' => $userData['name'] ?? 'Unknown',
                'email' => $userData['email'] ?? 'noemail@example.com',
                'location' => $userData['location'] ?? null,
                'role' => $userData['role'] ?? 'User',
                'deleted_at' => null,
            ]
        );

        // Remove from JSON
        $remaining = array_filter($trashData, fn($u) => $u['id'] != $id);
        file_put_contents($path, json_encode(array_values($remaining), JSON_PRETTY_PRINT));

        return response()->json(['success' => true, 'message' => 'User restored successfully!']);
    } catch (\Exception $e) {
        // 🔥 Log the real error in storage/logs/laravel.log
        \Log::error('Restore user failed: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
        return response()->json(['error' => 'Failed to restore user: ' . $e->getMessage()], 500);
    }
}
 public function emptyBin()
    {
        // Permanently delete all soft-deleted users
        User::onlyTrashed()->forceDelete();

        return redirect()->route('admin.users.index')
                         ->with('success', 'Recycle Bin has been emptied successfully.');
    }
}

