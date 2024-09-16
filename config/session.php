<?php

use Illuminate\Support\Str;

return [

    'driver' => env('SESSION_DRIVER', 'file'),

    'lifetime' => env('SESSION_LIFETIME', 120),  // Session lasts for 120 minutes

    'expire_on_close' => env('SESSION_EXPIRE_ON_CLOSE', false),  // Keep the session alive after browser close

    'encrypt' => env('SESSION_ENCRYPT', false),  // Session encryption is disabled

    'files' => storage_path('framework/sessions'),

    'connection' => env('SESSION_CONNECTION'),

    'table' => env('SESSION_TABLE', 'sessions'),

    'store' => env('SESSION_STORE'),

    'lottery' => [2, 100],  // This defines the probability of running the garbage collector

    'cookie' => env(
        'SESSION_COOKIE',
        Str::slug(env('APP_NAME', 'laravel'), '_') . '_session'
    ),

    'path' => env('SESSION_PATH', '/'),

    'domain' => env('SESSION_DOMAIN', null),  // You might want to set this to your specific domain

    'secure' => env('SESSION_SECURE_COOKIE', false),  // Set to true if your app uses HTTPS

    'http_only' => env('SESSION_HTTP_ONLY', true),  // JavaScript can't access the session cookie

    'same_site' => env('SESSION_SAME_SITE', 'lax'),  // Cross-site request settings, 'lax' is good for most apps

    'partitioned' => env('SESSION_PARTITIONED_COOKIE', false),  // Should be 'false' unless needed for a specific case

];
