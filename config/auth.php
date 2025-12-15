<?php

return [

    'defaults' => [
        'guard' => 'pelanggan', // default guard untuk pelanggan
        'passwords' => 'pelanggan',
    ],

    'guards' => [
        'web' => [ // untuk admin
            'driver' => 'session',
            'provider' => 'users',
        ],

        'admin' => [              // <<-- pastikan ada
        'driver' => 'session',
        'provider' => 'admin',
        ],

        'pelanggan' => [ // untuk pelanggan
            'driver' => 'session',
            'provider' => 'pelanggan',
        ],
    ],

    'providers' => [
        'admin' => [ // admin
            'driver' => 'eloquent',
            'model' => App\Models\Admin::class,
        ],

        'pelanggan' => [ // pelanggan
            'driver' => 'eloquent',
            'model' => App\Models\Pelanggan::class,
        ],
    ],

    'passwords' => [
        'admin' => [
            'provider' => 'admin',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],

        'pelanggan' => [
            'provider' => 'pelanggan',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

];
