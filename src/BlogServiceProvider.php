<?php

namespace Wingsline\Blog;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Spatie\Flash\Flash;
use Spatie\Menu\Laravel\Facades\Menu;
use Spatie\Menu\Laravel\Link;
use Spatie\ResponseCache\Middlewares\CacheResponse;
use Spatie\Tags\Tag;
use Wingsline\Blog\Console\InstallCommand;
use Wingsline\Blog\Console\PublishCommand;
use Wingsline\Blog\Console\ThemePublishCommand;
use Wingsline\Blog\Http\Middleware\Authenticate;
use Wingsline\Blog\Http\Middleware\NoHttpCache;
use Wingsline\Blog\Posts\Post;
use Wingsline\Blog\Posts\PostObserver;

class BlogServiceProvider extends ServiceProvider
{
    public function addFeed()
    {
        $this->app['config']
            ->set(
                'feed.feeds.blog',
                $this->app['config']->get('blog.feed')
            );
    }

    /**
     * Perform post-registration booting of services.
     */
    public function boot()
    {
        // prepend the views from the theme
        $this->app['view']->getFinder()->prependLocation(base_path('theme/views'));

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'blog');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        Flash::levels([
            'success' => '',
            'error' => 'bg-red-500',
        ]);

        Menu::macro('admin', function () {
            return Menu::new()
                ->addClass('flex items-center')
                ->addItemClass('p-2')
                ->add(Link::toUrl('/', 'Site')->setAttribute('target',
                    '_blank'))
                ->route('admin.posts.index', 'Posts')
                ->route('admin.account.edit', 'Account')
                ->view('blog::layouts.partials.logout')
                ->setActiveFromRequest('/');
        });

        // register the route middleware groups
        $this->app['router']->middlewareGroup('blog-auth',
            [Authenticate::class]);
        $this->app['router']->middlewareGroup('blog-nocache',
            [NoHttpCache::class]);
        $this->app['router']->middlewareGroup('blog-cacheResponse',
            [CacheResponse::class]);

        // router bindings
        $this->registerRouteModelBindings();

        // model event observers
        Post::observe(PostObserver::class);

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/blog.php', 'blog');

        if (file_exists(base_path('theme/config.php'))) {
            $this->mergeConfigFrom(base_path('theme/config.php'), 'theme');
        }

        $this->addFeed();

        $this->commands([
            InstallCommand::class,
            PublishCommand::class,
            ThemePublishCommand::class,
        ]);
    }

    public function registerRouteModelBindings()
    {
        Route::bind('postSlug', function ($slug) {
            if (auth()->check()) {
                return Post::where('slug', $slug)->first() ?? abort(404);
            }

            $post = Post::where('slug', $slug)->public()->first() ?? abort(404);

            if (!$post->published) {
                abort(404);
            }

            return $post;
        });

        Route::bind('tagSlug', function ($slug) {
            return Tag::where('slug->en', $slug)->first() ?? abort(404);
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
            __DIR__ . '/../public' => public_path('vendor/wingsline-blog'),
        ], 'blog.assets');

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/wingsline'),
        ], 'blog.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
