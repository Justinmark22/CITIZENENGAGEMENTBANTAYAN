<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckOtpVerified
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('otp_verified')) {
            return redirect()->route('otp.verify.page');
        }

        return $next($request);
    }
}
