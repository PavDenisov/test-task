<?php

namespace App\Services\ArticlesUpdater\HttpClient;

use GuzzleHttp\Client;

class LaravelBlogHttpClient extends Client implements HttpClientInterface
{
    public function  __construct(array $config = [])
    {
        $config['base_uri'] = config('laravel_blog_parser.base_url');
        $config['http_errors'] = false;
        parent::__construct($config);
    }
}
