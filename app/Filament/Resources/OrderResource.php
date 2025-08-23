<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
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
        return static::getModel()::where('status', 'pending')->count();
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

                Tables\Columns\TextColumn::make('customer_name')
                    ->label(__('filament-panels::resources/pages/order.fields.customer_name'))
                    ->searchable(),


                Tables\Columns\TextColumn::make('status')
                    ->label(__('filament-panels::resources/pages/order.fields.status'))
                    ->badge()
                    ->color(fn($state) => match ($state) {
                        'pending' => 'warning',
                        'paid' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray'
                    })
                    ->formatStateUsing(fn($state) => __("filament-panels::resources/pages/order.fields.state.$state"))
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
                Action::make('updatestauts')
                    ->label(__('filament-panels::resources/pages/order.fields.update_status'))
                    ->form([
                        Select::make('status')
                            ->options([
                                'paid' => __('filament-panels::resources/pages/order.fields.paid'),
                                'cancelled' => __('filament-panels::resources/pages/order.fields.cancel')
                            ])
                            ->required()
                            ->disabled(fn($record) => $record->status !== 'pending')
                    ])
                    ->action(function ($record, array $data) {
                        $record->update([
                            'status' => $data['status']
                        ]);
                    })

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
            'view' => Pages\ViewOrder::route('/{record}/view')
        ];
    }
}
