<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingSiteResource\Pages;
use App\Filament\Resources\SettingSiteResource\RelationManagers;
use App\Models\SettingSite;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SettingSiteResource extends Resource
{
    protected static ?string $model = SettingSite::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';



    public static function getNavigationGroup(): string
    {
        return __('filament-panels::layout.webist.control webiste');
    }

    public static function getModelLabel(): string
    {
        return __('filament-panels::resources/pages/settingsite.title');
    }
    public static function getPluralModelLabel(): string
    {
        return __('filament-panels::resources/pages/settingsite.title');
    }
    public static function getNavigationLabel(): string
    {
        return __('filament-panels::resources/pages/settingsite.title');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(1)
                    ->schema([
                        Forms\Components\TextInput::make('shop_link')
                                ->label(__('filament-panels::resources/pages/settingsite.fields.shop_link'))
                                ->required()
                                ->default('#'),
                        Forms\Components\TextInput::make('about_us')
                                ->label(__('filament-panels::resources/pages/settingsite.fields.about_us'))
                                ->required()
                                ->default('#'),
                        Forms\Components\TextInput::make('contact_us')
                                ->label(__('filament-panels::resources/pages/settingsite.fields.contact_us'))
                                ->required()
                                ->default('#'),
                        Forms\Components\TextInput::make('map_link')
                                ->label(__('filament-panels::resources/pages/settingsite.fields.map_link'))
                                ->required()
                                ->default('#'),
                        Forms\Components\TextInput::make('whats_app')
                                ->label(__('filament-panels::resources/pages/settingsite.fields.whats_app'))
                                ,

                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->label(__('filament-panels::resources/pages/blog.fields.title'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('filament-panels::resources/pages/blog.fields.created_at'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListSettingSites::route('/'),
            'create' => Pages\CreateSettingSite::route('/create'),
            'edit' => Pages\EditSettingSite::route('/{record}/edit'),
        ];
    }
}
