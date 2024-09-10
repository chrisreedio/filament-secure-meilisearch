<?php

namespace ChrisReedIO\SecureMeilisearch\Filament\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \ChrisReedIO\SecureMeilisearch\Filament\FilamentSecureMeilisearch
 */
class FilamentSecureMeilisearch extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \ChrisReedIO\SecureMeilisearch\Filament\FilamentSecureMeilisearch::class;
    }
}
