<?php

namespace App\Console\Commands;

use App\Services\ArticlesUpdater\Facade\ArticlesUpdaterFacadeInterface;
use Illuminate\Console\Command;

class UpdateLaravelBlogData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:laravel:blog:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updating Laravel Blog data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(private ArticlesUpdaterFacadeInterface $articlesUpdaterFacade)
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
        $this->info('Updating please wait...');
        $this->articlesUpdaterFacade->update();
    }
}
