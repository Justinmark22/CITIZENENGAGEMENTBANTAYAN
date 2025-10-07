<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OtpController extends Controller
{
    public function showVerifyForm()
    {
        return view('auth.verify-otp');
    }

    public function verifyOtp(Request $request)
    {
        $user = Auth::user();

        if ($request->otp == $user->otp_code) {
            $user->otp_verified = true;
            $user->save();

            return redirect()->route('dashboard')->with('success', 'OTP verified successfully!');
        }

        return back()->withErrors(['otp' => 'Invalid OTP code']);
    }
}
