<?php

use Illuminate\Support\Facades\Route;
use Wingsline\Blog\Http\Controllers\AccountController;
use Wingsline\Blog\Http\Controllers\DashboardController;
use Wingsline\Blog\Http\Controllers\Front\HomeController;
use Wingsline\Blog\Http\Controllers\Front\TaggedPostsController;
use Wingsline\Blog\Http\Controllers\LoginController;
use Wingsline\Blog\Http\Controllers\PostsController;

// Admin routes
Route::middleware(['web', 'blog-nocache'])
    ->prefix(config('blog.prefix'))
    ->group(function () {
        Route::get('login', [LoginController::class, 'showLoginForm'])->name('admin.login');
        Route::post('login', [LoginController::class, 'login']);
        Route::post('logout', [LoginController::class, 'logout'])->name('admin.logout');
        // authorized routes
        Route::middleware('blog-auth')
            ->name('admin.')
            ->group(function () {
                Route::get('/', DashboardController::class)->name('dashboard');

                Route::get('account', [AccountController::class, 'edit'])->name('account.edit');
                Route::match(['PUT', 'PATCH'], 'account', [AccountController::class, 'update'])->name('account.update');

                Route::post('posts/preview', [PostsController::class, 'preview'])->name('posts.preview');
                Route::post('posts/upload/{post}', [PostsController::class, 'upload'])->name('posts.upload');
                Route::resource('posts', PostsController::class)->except('show');
            });
    });

Route::middleware(['web', 'blog-cacheResponse'])
    ->group(function () {
        Route::feeds();
        Route::get('/', HomeController::class);
        Route::get('tag/{tagSlug}', TaggedPostsController::class)->name('posts.tagged');
        Route::get('{postSlug}', [\Wingsline\Blog\Http\Controllers\Front\PostsController::class, 'detail'])->name('post');
    });
