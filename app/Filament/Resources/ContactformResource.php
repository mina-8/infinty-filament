<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactformResource\Pages;
use App\Filament\Resources\ContactformResource\RelationManagers;
use App\Models\Contactform;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContactformResource extends Resource
{
    protected static ?string $model = Contactform::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationGroup():string
    {
        return __('filament-panels::layout.webist.control webiste');
    }
    public static function getNavigationSort(): ?int
    {
        return 7;
    }



    public static function getModelLabel(): string
    {
        return __('filament-panels::resources/pages/contactus.title');
    }
    public static function getPluralModelLabel(): string
    {
        return __('filament-panels::resources/pages/contactus.title');
    }
    public static function getNavigationLabel(): string
    {
        return __('filament-panels::resources/pages/contactus.title');
    }

    public static function canCreate(): bool
    {
        return false;
    }




    // public static function form(Form $form): Form
    // {
    //     return $form
    //         ->schema([
    //             //
    //         ]);
    // }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),

                Tables\Columns\TextColumn::make('first_name')
                    ->label(__('filament-panels::resources/pages/contactform.fields.email'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('last_name')
                    ->label(__('filament-panels::resources/pages/contactform.fields.email'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label(__('filament-panels::resources/pages/contactform.fields.email'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('filament-panels::resources/pages/contactform.fields.created_at'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
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
            'index' => Pages\ListContactforms::route('/'),
            'view' => Pages\ViewContactform::route('/view'),
            // 'create' => Pages\CreateContactform::route('/create'),
            // 'edit' => Pages\EditContactform::route('/{record}/edit'),
        ];
    }
}