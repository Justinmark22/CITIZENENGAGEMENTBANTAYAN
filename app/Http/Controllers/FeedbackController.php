<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Feedback;
use App\Models\Rating;

class FeedbackController extends Controller
{
    // Show the feedback form
    public function showFeedbackForm()
    {
        return view('feedback'); // feedback.blade.php
    }

    // Show the rate service form
    public function showRateServiceForm()
    {
        return view('rate_service'); // rate_service.blade.php
    }

    // Submit the feedback (store in DB)
    public function submitFeedback(Request $request)
    {
        // Validate the feedback submission
        $validated = $request->validate([
            'feedback' => 'required|string|max:1000',
            'rating' => 'required|integer|between:1,5',
            'location' => 'required|string|max:255',
        ]);

        // Process feedback (store in database)
        Feedback::create([
            'feedback' => $validated['feedback'],
            'rating' => $validated['rating'],
            'location' => $validated['location'],
            'user_id' => Auth::id(), // Store the user who submitted the feedback
        ]);

        return redirect()->route('feedback.page')->with('success', 'Thank you for your feedback!');
    }

    // Submit the rating (store in DB)
    public function submitRating(Request $request)
    {
        // Validate the rating submission
        $validated = $request->validate([
            'service_rating' => 'required|integer|between:1,5',
            'feedback' => 'nullable|string|max:1000',
            'location' => 'required|string|max:255',
        ]);

        // Process rating (store in database)
        Rating::create([
            'service_rating' => $validated['service_rating'],
            'feedback' => $validated['feedback'],
            'location' => $validated['location'],
            'user_id' => Auth::id(), // Store the user who submitted the rating
        ]);

        return redirect()->route('rate.service')->with('success', 'Thank you for rating our service!');
    }
}
