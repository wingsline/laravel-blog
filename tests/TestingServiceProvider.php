<?php

namespace Wingsline\Blog\Tests;

use Illuminate\Support\ServiceProvider;

class TestingServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     */
    public function boot()
    {
        // spatie/laravel-tags

        // we are loading the laravel migrations first. This is required for the
        // package, since it is uses foreign key constraint tables.

        // If we are loading with loadLaravelMigrations we might migrate the
        // laravel migrations after the package one, resulting partially
        // migrated tables.

        $this->loadMigrationsFrom([
            '--realpath' => realpath(__DIR__ . '/../vendor/orchestra/testbench-core/laravel/migrations'),
            __DIR__ . '/vendor-migrations',
        ]);
    }
}
