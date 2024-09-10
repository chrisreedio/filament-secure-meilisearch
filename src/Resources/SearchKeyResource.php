<?php

namespace ChrisReedIO\SecureMeilisearch\Filament\Resources;

use ChrisReedIO\SecureMeilisearch\Filament\Resources\SearchKeyResource\Pages;
// use ChrisReedIO\SecureMeilisearch\Filament\Resources\SearchKeyResource\RelationManagers;
use ChrisReedIO\SecureMeilisearch\Models\SearchKey;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Carbon;

use function __;
use function config;

class SearchKeyResource extends Resource
{
    protected static ?string $model = SearchKey::class;

    protected static ?string $navigationIcon = 'heroicons-o-key';

    protected static ?string $navigationParentItem = 'Users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->disabled(),
                Forms\Components\TextInput::make('uuid')
                    ->label('UUID')
                    ->readOnly()
                    ->required(),
                Forms\Components\TextInput::make('key')
                    ->maxLength(255),
                Forms\Components\DateTimePicker::make('expires_at'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('uuid')
                    ->label('UUID'),
                Tables\Columns\TextColumn::make('key')
                    ->copyable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('expires_at')
                    ->dateTime()
                    ->color(fn (SearchKey $record) => Carbon::create($record->expires_at)->isPast() ? Color::Rose : null)
                    ->sortable(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                // Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->before(function (SearchKey $record) {
                        if ($record->revoke()) {
                            Notification::make()
                                ->title('Successfully Revoked Search Key')
                                ->success()
                                ->send();
                        } else {
                            Notification::make()
                                ->title('Failed to Revoke Search Key')
                                ->danger()
                                ->send();
                        }
                    }),
                // ->after(fn (SearchKey $record) => $record->revoke()),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSearchKeys::route('/'),
            // 'create' => Pages\CreateSearchKey::route('/create'),
            'view' => Pages\ViewSearchKey::route('/{record}'),
            // 'edit' => Pages\EditSearchKey::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
