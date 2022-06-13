<?php

namespace App\Services\ArticlesUpdater\HttpClient;

use Psr\Http\Message\ResponseInterface;

interface HttpClientInterface
{
    public function get($uri): ResponseInterface;
}
