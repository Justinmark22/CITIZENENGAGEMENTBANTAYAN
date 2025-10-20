<?php
namespace App\Http\Controllers;
use App\Models\Update;
use Illuminate\Http\Request;

class MadridejosUpdateController extends Controller
{
    public function index() {
    $updates = Update::where('location', 'Madridejos')->latest()->get();
    return view('madridejos.updates', compact('updates'));
}


    public function create() {
        return view('madridejos.updates-create');
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


    return redirect()->route('madridejos.updates.index')->with('success', 'Update posted successfully.');
}


    public function show($id) {
        $update = Update::findOrFail($id);
        return view('madridejos.updates-show', compact('update'));
    }
    public function destroy($id)
{
    $update = Update::findOrFail($id);
    $update->delete();

    return redirect()->route('madridejos.updates.index')->with('success', 'Update deleted successfully.');
}
public function edit($id)
{
    $update = Update::findOrFail($id);
    return view('madridejos.updates.edit', compact('update'));
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
