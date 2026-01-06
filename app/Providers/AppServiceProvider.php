<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL; // <--- Pastikan import ini ada

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
        // 1. Konfigurasi Bahasa Indonesia & Waktu (Kode Kamu)
        config(['app.locale' => 'id']);
        Carbon::setLocale('id');
        date_default_timezone_set('Asia/Jakarta');

        // 2. FIX TAMPILAN RUSAK & NOT SECURE (Kode Tambahan Wajib)
        // Ini memaksa Laravel membuat link HTTPS saat sudah di Render
        if($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}