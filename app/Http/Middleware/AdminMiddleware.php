<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || Auth::user()->role !== 'Admin') {
            return redirect()->route('login')->withErrors(['email' => 'You must be an admin to access this page.']);
        }

        return $next($request);
    }
}
