<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Request;

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
        // Mendeteksi jika aplikasi berjalan di balik Cloudflare/Proxy
        if (Request::header('x-forwarded-proto') === 'https' || str_contains(Request::getHost(), 'trycloudflare.com')) {
            URL::forceScheme('https');
        }
    }
}