<?php

namespace App\Providers;

use App\Console\Commands\UpdateLaravelBlogData;
use App\Services\ArticlesUpdater\DataParser\DataParserInterface;
use App\Services\ArticlesUpdater\DataParser\LaravelBlogParser;
use App\Services\ArticlesUpdater\Facade\ArticlesUpdaterFacadeInterface;
use App\Services\ArticlesUpdater\Facade\LaravelBlogArticlesUpdater;
use App\Services\ArticlesUpdater\HttpClient\HttpClientInterface;
use App\Services\ArticlesUpdater\HttpClient\LaravelBlogHttpClient;
use Illuminate\Support\ServiceProvider;

class LaravelBlogArticlesUpdaterServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->when(UpdateLaravelBlogData::class)
            ->needs(ArticlesUpdaterFacadeInterface::class)
            ->give(LaravelBlogArticlesUpdater::class);

        $this->app->when(LaravelBlogArticlesUpdater::class)
            ->needs(DataParserInterface::class)
            ->give(LaravelBlogParser::class);

        $this->app->when(LaravelBlogParser::class)
            ->needs(HttpClientInterface::class)
            ->give(LaravelBlogHttpClient::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
