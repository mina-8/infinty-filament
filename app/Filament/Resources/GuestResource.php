<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GuestResource\Pages;
use App\Filament\Resources\GuestResource\RelationManagers;
use App\Models\Guest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GuestResource extends Resource
{
    protected static ?string $model = Guest::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-plus';

    public static function getModelLabel(): string
    {
        return __('filament-panels::resources/pages/guest.title');
    }
    public static function getPluralModelLabel(): string
    {
        return __('filament-panels::resources/pages/guest.title');
    }
    public static function getNavigationLabel(): string
    {
        return __('filament-panels::resources/pages/guest.title');
    }
    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('name')
                    ->label(__('filament-panels::resources/pages/user.fields.name'))
                    ->searchable(),
                TextColumn::make('email')
                    ->label(__('filament-panels::resources/pages/user.fields.email'))
                    ->searchable(),
                TextColumn::make('phone')
                    ->label(__('filament-panels::resources/pages/user.fields.phone'))
                    ->searchable(),
                TextColumn::make('area')
                    ->label(__('filament-panels::resources/pages/user.fields.area'))
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label(__('filament-panels::resources/pages/user.fields.created_at'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
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
            'index' => Pages\ListGuests::route('/'),
            'view' => Pages\ViewGuest::route('/{record}'),
            // 'create' => Pages\CreateGuest::route('/create'),
            // 'edit' => Pages\EditGuest::route('/{record}/edit'),
        ];
    }
}
