<?php

namespace Wingsline\Blog\Console;

use Illuminate\Console\Command;

class PublishCommand extends Command
{
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish all of the blog\'s resources';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blog:publish';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->call('vendor:publish', [
            '--tag' => 'blog.assets',
            '--force' => true,
        ]);
    }
}
