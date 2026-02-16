<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OurRegionalOfficeResource\Pages;
use App\Filament\Resources\OurRegionalOfficeResource\RelationManagers;
use App\Models\OurRegionalOffice;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Pixelpeter\FilamentLanguageTabs\Forms\Components\LanguageTabs;

class OurRegionalOfficeResource extends Resource
{
    protected static ?string $model = OurRegionalOffice::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';
    public static function getNavigationGroup():string
    {
        return __('filament-panels::layout.webist.control webiste');
    }
        public static function getNavigationSort(): ?int
    {
        return 6;
    }


    public static function getModelLabel(): string
    {
        return __('filament-panels::resources/pages/ourregionaloffice.title');
    }
    public static function getPluralModelLabel(): string
    {
        return __('filament-panels::resources/pages/ourregionaloffice.title');
    }
    public static function getNavigationLabel(): string
    {
        return __('filament-panels::resources/pages/ourregionaloffice.title');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(1)
                    ->schema([
                        LanguageTabs::make([
                            Forms\Components\TextInput::make('state')
                                ->label(__('filament-panels::resources/pages/ourregionaloffice.fields.state'))
                                ->maxLength(255)
                                ->required(),


                        ]),
                        Forms\Components\TextInput::make('fax')
                            ->label(__('filament-panels::resources/pages/ourregionaloffice.fields.mailbox'))
                            ->maxLength(25)
                            ->required(),
                        Forms\Components\TextInput::make('phone')
                            ->label(__('filament-panels::resources/pages/ourregionaloffice.fields.phone'))
                            ->maxLength(25)
                            ->required(),
                        Forms\Components\TextInput::make('phone_free')
                            ->label(__('filament-panels::resources/pages/ourregionaloffice.fields.phone'))
                            ->maxLength(25)
                            ,
                        Forms\Components\TextInput::make('email')
                            ->label(__('filament-panels::resources/pages/ourregionaloffice.fields.email'))
                            ->email()
                            ->maxLength(255)
                            ->required(),


                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('state')
                    ->label(__('filament-panels::resources/pages/ourregionaloffice.fields.state'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('address')
                    ->label(__('filament-panels::resources/pages/ourregionaloffice.fields.address'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('mailbox')
                    ->label(__('filament-panels::resources/pages/ourregionaloffice.fields.mailbox'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label(__('filament-panels::resources/pages/ourregionaloffice.fields.phone'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label(__('filament-panels::resources/pages/ourregionaloffice.fields.email'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('filament-panels::resources/pages/ourregionaloffice.fields.created_at'))
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
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListOurRegionalOffices::route('/'),
            'create' => Pages\CreateOurRegionalOffice::route('/create'),
            'edit' => Pages\EditOurRegionalOffice::route('/{record}/edit'),
        ];
    }
}
