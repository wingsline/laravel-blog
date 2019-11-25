<?php

use Wingsline\Blog\Markdown\Markdown;
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
    | Header navigation
    |--------------------------------------------------------------------------
    |
    | This is the header navigation. It uses views as menu items.
    |
    */
    'navHeader' => [
        'blog::layouts.nav.items.site',
        'blog::layouts.nav.items.account',
        'blog::layouts.nav.items.logout',
    ],

    /*
    |--------------------------------------------------------------------------
    | Admin navigation
    |--------------------------------------------------------------------------
    |
    | Main admin navigation
    |
    */
    'navAdmin' => [
        'blog::layouts.nav.dashboard',
        'blog::layouts.nav.blog',
        'blog::layouts.nav.account',
    ],

    /*
    |--------------------------------------------------------------------------
    | Feed configuration
    |--------------------------------------------------------------------------
    |
    */
    'feed' => [
        'items' => Post::class.'@getFeedItems',
        'url' => '/feed/blog',
        'title' => config('app.name'),
        'description' => config('theme.meta.description', ''),
        'language' => 'en-US',
        'view' => 'feed::atom',
        'type' => 'application/atom+xml',
    ],

    /*
    |--------------------------------------------------------------------------
    | Markdown Parser class and method name
    |--------------------------------------------------------------------------
    |
    | Set the markdown parser class and method name here
    |
    */
    'markdown_parser' => [
        'class' => Markdown::class,
        'method' => 'convertToHtml',
    ],
];
