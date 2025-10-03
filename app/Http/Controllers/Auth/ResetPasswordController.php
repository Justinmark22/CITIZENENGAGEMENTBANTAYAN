<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Reset Password Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles resetting user passwords and includes a trait
    | which assists in the process.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting password.
     *
     * @var string
     */
    protected $redirectTo = '/home'; // Change this to your desired route

    /**
     * Display the password reset view for the given token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string|null  $token
     * @return \Illuminate\View\View
     */
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.passwords.reset')->with([
            'token' => $token,
            'email' => $request->email
        ]);
    }
}
