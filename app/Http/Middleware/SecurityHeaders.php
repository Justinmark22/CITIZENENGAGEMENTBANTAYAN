<?php

namespace App\Http\Middleware;

use Closure;

class SecurityHeaders
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        // Strict-Transport-Security
        $response->headers->set(
            'Strict-Transport-Security',
            'max-age=31536000; includeSubDomains; preload'
        );

        // Permissions-Policy
        $response->headers->set(
            'Permissions-Policy',
            'camera=(), microphone=(), geolocation=(), fullscreen=(self)'
        );

        // X-Frame-Options (anti-clickjacking)
        $response->headers->set('X-Frame-Options', 'DENY');

        // X-Content-Type-Options
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // Referrer-Policy
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // X-XSS-Protection (legacy)
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // ✅ Content-Security-Policy (CSP)
        $csp = "default-src 'self'; script-src 'self'; style-src 'self'; img-src 'self'; object-src 'none'; base-uri 'self'; frame-ancestors 'none';";
        $response->headers->set('Content-Security-Policy', $csp);

        return $response;
    }
}
