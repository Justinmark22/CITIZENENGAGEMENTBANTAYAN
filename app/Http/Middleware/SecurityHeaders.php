<?php

namespace App\Http\Middleware;

use Closure;

class SecurityHeaders
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        // Enforce HTTPS
        $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');

        // Clickjacking protection
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // Modern frame protection (CSP)
        $response->headers->set('Content-Security-Policy',
            "default-src 'self'; script-src 'self'; style-src 'self'; img-src 'self' data:; font-src 'self'; connect-src 'self'; frame-ancestors 'self';"
        );

        // Prevent MIME type sniffing
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // Referrer policy
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // Legacy XSS protection
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // Permissions for geolocation and fullscreen
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=(self), fullscreen=(self)');

        // Optional modern headers
        $response->headers->set('Cross-Origin-Opener-Policy', 'same-origin');
        $response->headers->set('Cross-Origin-Embedder-Policy', 'require-corp');

        return $response;
    }
}
