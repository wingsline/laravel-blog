<?php

namespace Wingsline\Blog\Tests;

use Spatie\Feed\FeedServiceProvider;
use Illuminate\Support\Facades\Schema;
use Wingsline\Blog\BlogServiceProvider;
use Spatie\Menu\Laravel\MenuServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\ResponseCache\ResponseCacheServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpDatabase();
    }

    /**
     * Define environment setup.
     *
     * @param \Illuminate\Foundation\Application $app
     */
    public function getEnvironmentSetUp($app)
    {
        // test theme
        view()->getFinder()->prependLocation(__DIR__ . '/Feature/theme');
    }

    public function setUpDatabase()
    {
        $this->withFactories(__DIR__ . '/../database/factories');
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

        Schema::dropIfExists('taggables');
        Schema::dropIfExists('tags');
        include_once __DIR__ . '/../../../../vendor/spatie/laravel-tags/database/migrations/create_tag_tables.php.stub';
        (new \CreateTagTables())->up();
    }

    /**
     * Get package providers.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            ResponseCacheServiceProvider::class,
            FeedServiceProvider::class,
            MenuServiceProvider::class,
            BlogServiceProvider::class,
        ];
    }
}
