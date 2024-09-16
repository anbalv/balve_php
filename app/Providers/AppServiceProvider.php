<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Hier können zusätzliche Services registriert werden.
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Speicherlimit dynamisch erhöhen
        ini_set('memory_limit', '256M');

        // Sicherstellen, dass ältere MySQL-Versionen mit längeren String-Längen arbeiten
        Schema::defaultStringLength(191); // Optional, falls MySQL < 5.7 verwendet wird.

        // Datenbank-Queries protokollieren
        DB::listen(function ($query) {
            Log::withContext([
                'queries' => [
                    'query' => $query->sql,
                    'bindings' => $query->bindings,
                    'time' => $query->time,
                ],
            ]);

            Log::info('Database query executed.');
        });
    }
}
