<?php

namespace Wingsline\Blog\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Spatie\Backup\BackupServiceProvider;
use Spatie\Csp\CspServiceProvider;
use Spatie\Feed\FeedServiceProvider;
use Spatie\MediaLibrary\MediaLibraryServiceProvider;
use Spatie\MissingPageRedirector\MissingPageRedirectorServiceProvider;
use Spatie\ResponseCache\ResponseCacheServiceProvider;
use Spatie\Tags\TagsServiceProvider;
use Wingsline\Blog\Database\Seeds\UsersTableSeeder;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blog:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the blog.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->comment('Publishing the blog assets...');
        // Backup
        $this->callSilent(
            'vendor:publish',
            [
                '--provider' => BackupServiceProvider::class
            ]
        );
        // CSP
        $this->callSilent(
            'vendor:publish',
            [
                '--tag' => 'config',
                '--provider' => CspServiceProvider::class
            ]
        );
        // RSS Feed
        $this->callSilent(
            'vendor:publish',
            [
                '--tag' => 'config',
                '--provider' => FeedServiceProvider::class
            ]
        );
        // media library
        $this->callSilent(
            'vendor:publish',
            [
                '--tag' => 'config',
                '--provider' => MediaLibraryServiceProvider::class,
            ]
        );
        // check if media table exists
        if (!Schema::hasTable('media')) {
            $this->callSilent(
                'vendor:publish',
                [
                    '--tag' => 'migrations',
                    '--provider' => MediaLibraryServiceProvider::class
                ]
            );
        }

        // Missing page redirector
        $this->callSilent(
            'vendor:publish',
            [
                '--provider' => MissingPageRedirectorServiceProvider::class,
            ]
        );
        // Response Cache
        $this->callSilent(
            'vendor:publish',
            [
                '--provider' => ResponseCacheServiceProvider::class
            ]
        );
        // tags
        $this->callSilent(
            'vendor:publish',
            [
                '--tag' => 'config',
                '--provider' => TagsServiceProvider::class
            ]
        );
        if (!Schema::hasTable('tags')) {
            $this->callSilent(
                'vendor:publish',
                [
                    '--tag' => 'migrations',
                    '--provider' => TagsServiceProvider::class
                ]
            );
        }
        // Blog migrations
        $this->callSilent('vendor:publish',['--tag' => 'blog.config']);
        $this->callSilent('vendor:publish',['--tag' => 'blog.migrations']);
        $this->callSilent('vendor:publish',['--tag' => 'blog.assets']);
        $this->info('Blog scaffolding installed successfully.');
        // run the migrations and seeds
        $this->comment('Running the database migrations...');
        $this->call('migrate');
        $this->call('storage:link');
        // Link the theme?
        if ($this->confirm('Link the theme\'s public assets?')) {
            $this->call('blog:theme-publish');
        }
        // Seed the database
        if ($this->confirm('Seed the database (recommended for new installations)')) {
            $this->comment('Seeding the database with default data...');
            $this->call('db:seed', ['--class' => UsersTableSeeder::class]);
        }

        $admin_url = url(config('blog.prefix'));
        $this->info('Installation complete. You can login to the admin ' . $admin_url);
    }
}
