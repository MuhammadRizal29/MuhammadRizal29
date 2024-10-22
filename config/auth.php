<?php

return [
    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'admin' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],

        'guru' => [
            'driver' => 'session',
            'provider' => 'gurus',
        ],

        'orangtua' => [
            'driver' => 'session',
            'provider' => 'orangtuas',
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        'admins' => [
            'driver' => 'eloquent',
            'model' => App\Models\Admin::class,
        ],

        'gurus' => [
            'driver' => 'eloquent',
            'model' => App\Models\Guru::class,
        ],

        'orangtuas' => [
            'driver' => 'eloquent',
            'model' => App\Models\OrangTua::class,
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
        'admins' => [
            'provider' => 'admins',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
        'gurus' => [
            'provider' => 'gurus',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
        'orangtuas' => [
            'provider' => 'orangtuas',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,

    'password_hash_driver' => 'bcrypt',  // Ensure bcrypt is used for hashing

    'bcrypt' => [
        'rounds' => env('BCRYPT_ROUNDS', 10),
    ],
];