<?php

namespace ChrisReedIO\FilamentSecureMeilisearch\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \ChrisReedIO\FilamentSecureMeilisearch\FilamentSecureMeilisearch
 */
class FilamentSecureMeilisearch extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \ChrisReedIO\FilamentSecureMeilisearch\FilamentSecureMeilisearch::class;
    }
}
