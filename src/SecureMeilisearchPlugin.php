<?php

namespace ChrisReedIO\SecureMeilisearch\Filament;

use ChrisReedIO\SecureMeilisearch\Filament\Resources\SearchKeyResource;
use Filament\Contracts\Plugin;
use Filament\Panel;

class SecureMeilisearchPlugin implements Plugin
{
    public function getId(): string
    {
        return 'filament-secure-meilisearch';
    }

    public function register(Panel $panel): void
    {
        $panel->resources([
            SearchKeyResource::class,
        ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }
}
