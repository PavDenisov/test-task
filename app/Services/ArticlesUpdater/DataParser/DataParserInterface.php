<?php

namespace App\Services\ArticlesUpdater\DataParser;

use Illuminate\Support\Collection;

interface DataParserInterface
{
    /**
     * Parse data
     *
     * @return Collection
     */
    public function parse(): Collection;
}
