<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Support; // Import the Support model

class SupportController extends Controller
{
    // Show the support page
    public function showSupportPage()
    {
        return view('contact_support'); // Make sure the Blade view exists
    }

    // Handle support request submission
    public function submitSupportRequest(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        // Store the support request in the database
        Support::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'message' => $validated['message'],
        ]);

        // Redirect with success message
        return redirect()->route('contact.support.page')->with('success', 'Your message has been sent.');
    }
}
