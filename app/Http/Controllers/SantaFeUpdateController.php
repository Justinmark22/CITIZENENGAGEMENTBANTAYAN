<?php
namespace App\Http\Controllers;
use App\Models\Update;
use Illuminate\Http\Request;

class SantaFeUpdateController extends Controller
{
    public function index() {
    $updates = Update::where('location', 'Santa.Fe')->latest()->get();
    return view('santa_fe.updates', compact('updates'));
}


    public function create() {
        return view('santa_fe.updates-create');
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


    return redirect()->route('santafe.updates')->with('success', 'Update posted successfully.');
}


    public function show($id) {
        $update = Update::findOrFail($id);
        return view('santa_fe.updates-show', compact('update'));
    }
    public function destroy($id)
{
    $update = Update::findOrFail($id);
    $update->delete();

    return redirect()->route('santafe.updates.index')->with('success', 'Update deleted successfully.');
}
public function edit($id)
{
    $update = Update::findOrFail($id);
    return view('santafe.updates.edit', compact('update'));
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
