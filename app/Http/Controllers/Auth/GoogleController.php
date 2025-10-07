<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
        } catch (\Exception $e) {
            return redirect('/login')->withErrors(['msg' => 'Unable to login using Google.']);
        }

        // Check if user exists
        $user = User::where('email', $googleUser->getEmail())->first();

        if (!$user) {
            // Create user if not exists
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'password' => bcrypt(Str::random(16)), // random password
            ]);
        }

        Auth::login($user, true);

        return redirect('/dashboard'); // change this to your route after login
    }
}
