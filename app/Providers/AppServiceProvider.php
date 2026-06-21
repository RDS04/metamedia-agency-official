<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

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
        // Jika manifest tidak ada, gunakan mode dev tanpa Hot Module Replacement
        if (! file_exists(public_path('build/manifest.json'))) {
            Vite::useScriptTagAttributes([
                'nonce' => 'no-manifest',
            ]);
        }
    }
}
