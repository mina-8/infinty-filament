<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';



    public static function getModelLabel(): string
    {
        return __('filament-panels::resources/pages/order.title');
    }
    public static function getPluralModelLabel(): string
    {
        return __('filament-panels::resources/pages/order.title');
    }
    public static function getNavigationLabel(): string
    {
        return __('filament-panels::resources/pages/order.title');
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getNavigationBadge(): ?string
{
    return static::getModel()::where('status' , 'pending')->count();
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
            ->columns([
                    Tables\Columns\TextColumn::make('id')->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->label(__('filament-panels::resources/pages/order.fields.status'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('order_token')
                    ->label(__('filament-panels::resources/pages/order.fields.order_code'))
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
