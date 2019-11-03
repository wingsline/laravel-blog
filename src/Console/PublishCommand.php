<?php


namespace Wingsline\Blog\Console;


use Illuminate\Console\Command;

class PublishCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blog:publish {--force : Overwrite any existing files}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish all of the Blog resources';
    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->call('vendor:publish', [
            '--tag' => 'blog.assets',
            '--force' => true,
        ]);
    }
}
