<?php

use Wingsline\Blog\Posts\Post;

return [
    /*
     |--------------------------------------------------------------------------
     | Admin prefix
     |--------------------------------------------------------------------------
     |
     |
     */
    'prefix' => env('ADMIN_PREFIX', 'admin'),

    /*
    |--------------------------------------------------------------------------
    | Maximum allowed failed login attempts
    |--------------------------------------------------------------------------
    |
    */
    'maxAttempts' => env('ADMIN_MAX_LOGIN_ATTEMPTS', 5),

    /*
    |--------------------------------------------------------------------------
    | Pagination
    |--------------------------------------------------------------------------
    |
    */
    'per_page' => env('ADMIN_PER_PAGE', 15),

    /*
    |--------------------------------------------------------------------------
    | Feed configuration
    |--------------------------------------------------------------------------
    |
    */
    'feed' => [
        'items' => Post::class . '@getFeedItems',
        'url' => '/feed/blog',
        'title' => env('APP_NAME'),
        'description' => config('theme.meta.description', ''),
        'language' => 'en-US',
        'view' => 'feed::atom',
        'type' => 'application/atom+xml',
    ]

];
