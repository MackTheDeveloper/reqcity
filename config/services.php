<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    // 'facebook' => [
    //     'client_id' => '771093430473362',
    //     'client_secret' => '6b6ca87ce8f0eb27619db3140f2d582a',
    //     'redirect' => PHP_SAPI === 'cli' ? false : url('/').'/auth/facebook/callback',
    // ],
    // 'google' => [
    //     'client_id' => '316927230092-970kuili1ngtogj9c5f6bdse6euotd5v.apps.googleusercontent.com',
    //     'client_secret' => 'mdRHmkH3oOXGjOZGc8kZpEaZ',
    //     'redirect' => PHP_SAPI === 'cli' ? false : url('/').'/auth/google/callback',
    // ],

    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_REDIRECT'),
    ],
    'facebook' => [
        'client_id' => env('FB_ID'),
        'client_secret' => env('FB_SECRET'),
        'redirect' => env('FB_REDIRECT'),
    ],
    'stripe' => [
        'secret' => env('STRIPE_SECRET'),
    ],

];
