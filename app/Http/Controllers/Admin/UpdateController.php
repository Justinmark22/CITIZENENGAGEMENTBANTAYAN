<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Update;

class UpdateController extends Controller
{
    public function create()
    {
        return view('admin.updates.create');
    }

    public function store(Request $request)
{
    $update = Update::create($request->all());

    return response()->json([
        'message' => 'Update successfully posted!',
        'id' => $update->id,
        'title' => $update->title,
        'message' => $update->message,
        'location' => $update->location,
        'update_date' => $update->update_date,
    ]);
}

public function update(Request $request, $id)
{
    $update = \App\Models\Update::findOrFail($id);
    $update->update($request->all());

    return response()->json([
        'id' => $update->id,
        'title' => $update->title,
        'message' => $update->message,
        'location' => $update->location,
        'update_date' => $update->update_date,
    ]);
}public function destroy($id)
{
    $update = Update::findOrFail($id);
    $update->delete();

    return response()->json(['message' => 'Deleted successfully']);
}


public function getAll()
{
    return response()->json(Update::orderBy('created_at', 'desc')->get());
}

}