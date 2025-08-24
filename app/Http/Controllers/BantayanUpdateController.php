<?php
namespace App\Http\Controllers;
use App\Models\Update;
use Illuminate\Http\Request;

class BantayanUpdateController extends Controller
{
    public function index() {
    $updates = Update::where('location', 'Bantayan')->latest()->get();
    return view('bantayan.updates', compact('updates'));
}


    public function create() {
        return view('bantayan.updates-create');
    }

   public function store(Request $request) {
   $request->validate([
    'title' => 'required|string|max:255',
    'content' => 'required|string',
    'location' => 'required|string|max:255',
]);

Update::create([
    'title' => $request->title,
    'message' => $request->content,
    'location' => $request->location, // auto-filled "Santa Fe"
]);


    return redirect()->route('bantayan.updates.index')->with('success', 'Update posted successfully.');
}


    public function show($id) {
        $update = Update::findOrFail($id);
        return view('bantayan.updates-show', compact('update'));
    }
    public function destroy($id)
{
    $update = Update::findOrFail($id);
    $update->delete();

    return redirect()->route('bantayan.updates.index')->with('success', 'Update deleted successfully.');
}
public function edit($id)
{
    $update = Update::findOrFail($id);
    return view('bantayan.updates.edit', compact('update'));
}
public function update(Request $request, $id)
{
    $update = Update::findOrFail($id);
    $update->update([
        'title' => $request->title,
        'message' => $request->message,
        'location' => $request->location,
    ]);

    return redirect()->back()->with('success', 'Update edited successfully.');
}

}
