<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Ensure important storage sub-directories exist (prevents file_put_contents errors on some hosts)
        $paths = [
            storage_path('framework/sessions'),
            storage_path('framework/cache'),
            storage_path('framework/views'),
        ];

        foreach ($paths as $p) {
            if (!is_dir($p)) {
                @mkdir($p, 0755, true);
                // best-effort permission set
                @chmod($p, 0755);
                Log::info("Created storage directory: {$p}");
            }
        }
    }
}
