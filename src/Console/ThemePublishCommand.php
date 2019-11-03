<?php


namespace Wingsline\Blog\Console;

use Illuminate\Console\Command;

class ThemePublishCommand extends Command
{
    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'blog:theme-publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a symbolic link from "theme/public" to "public/theme"';

    /**
     * Execute the console command.
     *
     * @return void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function handle()
    {
        if (!file_exists(base_path('theme/public'))) {
            return $this->error('The theme doesn\'t have any public assets.');
        }

        $this->laravel->make('files')->delete(public_path('theme'));

        $this->laravel->make('files')->link(
            base_path('theme/public'), public_path('theme')
        );

        $this->info('The theme\'s public assets were linked.');
    }
}
