<?php

return [

    'name' => env('APP_NAME', 'Laravel'),


    'env' => env('APP_ENV', 'production'),


    'debug' => (bool) env('APP_DEBUG', false),


    'url' => env('APP_URL', 'http://localhost'),

    'timezone' => 'Asia/Jakarta',

    'locale' => 'id',

    'fallback_locale' => env('APP_FALLBACK_LOCALE', 'en'),

    'faker_locale' => env('APP_FAKER_LOCALE', 'en_US'),


    'cipher' => 'AES-256-CBC',

    'key' => env('APP_KEY'),

    'previous_keys' => [
        ...array_filter(
            explode(',', (string) env('APP_PREVIOUS_KEYS', ''))
        ),
    ],

    'maintenance' => [
        'driver' => env('APP_MAINTENANCE_DRIVER', 'file'),
        'store' => env('APP_MAINTENANCE_STORE', 'database'),
    ],

    'batas_verifikasi_days' => env('BATAS_VERIFIKASI_DAYS', 14),
    'batas_verifikasi_seconds' => env('BATAS_VERIFIKASI_SECONDS', null), // ditulis null karena cuma dipakai pas mau demo
    'batas_unggah_wawancara_days' => env ('BATAS_UNGGAH_WAWANCARA_DAYS', 30),
    'batas_unggah_wawancara_seconds' => env ('BATAS_UNGGAH_WAWANCARA_SECONDS', null),
];
