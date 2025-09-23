<?php

namespace App\Providers;

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
        // 👇 Aquí ya NO forzamos ngrok
        // Dejamos que APP_URL controle el comportamiento local (127.0.0.1:8000)
        // y usamos NGROK solo en CustomVerifyEmail.php
    }
}
