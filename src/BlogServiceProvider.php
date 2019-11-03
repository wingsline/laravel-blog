<?php

namespace Wingsline\Blog;

use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Spatie\Flash\Flash;
use Spatie\Menu\Laravel\Facades\Menu;
use Spatie\Menu\Laravel\Link;
use Wingsline\Blog\Console\InstallCommand;

class BlogServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     */
    public function boot()
    {
        // prepend the views from the theme
        if(File::isDirectory(base_path('theme'))) {
            $paths = array_merge([base_path('theme/views')], config('view.paths'));
            config()->set('view.paths', $paths);
            $this->mergeConfigFrom(base_path('theme/config.php'), 'theme');
        }

        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'wingsline');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'blog');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        Flash::levels([
            'success' => '',
            'error' => 'bg-red-500',
        ]);

        Menu::macro('admin', function () {
            return Menu::new()
                ->addClass('flex items-center')
                ->addItemClass('p-2')
                ->add(Link::toUrl('/', 'Site')->setAttribute('target', '_blank'))
                ->route('admin.posts.index', 'Posts')
                ->route('admin.account.edit', 'Account')
                ->view('blog::layouts.partials.logout')
                ->setActiveFromRequest('/');
        });

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['blog'];
    }

    /**
     * Register any package services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/blog.php', 'blog');

        $this->commands([
            InstallCommand::class
        ]);

        // Register the service the package provides.
        $this->app->singleton('blog', function ($app) {
            return new Blog();
        });
    }

    /**
     * Console-specific booting.
     */
    protected function bootForConsole()
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__ . '/../config/blog.php' => config_path('blog.php'),
            __DIR__ . '/../config/theme.php' => config_path('theme.php'),
        ], 'blog.config');

        // Publishing the views.
        $this->publishes([
            __DIR__ . '/../resources/views' => base_path('resources/views/vendor/wingsline'),
        ], 'blog.views');

        // Publishing the migrations.
        $this->publishes([
            __DIR__ . '/../database/migrations' => database_path('migrations'),
        ], 'blog.migrations');
        // Publishing assets.
        $this->publishes([
            __DIR__.'/../public' => public_path('vendor/wingsline'),
        ], 'blog.assets');

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/wingsline'),
        ], 'blog.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
