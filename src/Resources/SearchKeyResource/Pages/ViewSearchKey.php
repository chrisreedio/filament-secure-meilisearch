<?php

namespace ChrisReedIO\SecureMeilisearch\Filament\Resources\SearchKeyResource\Pages;

use ChrisReedIO\SecureMeilisearch\Filament\Resources\SearchKeyResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewSearchKey extends ViewRecord
{
    protected static string $resource = SearchKeyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
