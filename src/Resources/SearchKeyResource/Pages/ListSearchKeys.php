<?php

namespace ChrisReedIO\SecureMeilisearch\Filament\Resources\SearchKeyResource\Pages;

use ChrisReedIO\SecureMeilisearch\Filament\Resources\SearchKeyResource;
use ChrisReedIO\SecureMeilisearch\Models\SearchKey;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListSearchKeys extends ListRecords
{
    protected static string $resource = SearchKeyResource::class;

    protected ?string $maxContentWidth = 'full';

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('revokeExpiredKeys')
                ->label('Revoke Expired Keys')
                // ->icon('heroicons-o-key')
                ->color('danger')
                ->requiresConfirmation()
                ->action(function () {
                    $expiredKeys = SearchKey::expired()->get();
                    $expiredKeys->each(function (SearchKey $key) {
                        $key->revoke();
                        $key->delete();
                    });
                    $count = $expiredKeys->count();

                    Notification::make()
                        ->title('Expired Keys Revoked')
                        ->body("{$count} expired keys have been revoked.")
                        ->success()
                        ->send();
                }),
            // Actions\CreateAction::make(),
        ];
    }
}
