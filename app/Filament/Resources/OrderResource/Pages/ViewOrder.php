<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists;
use Filament\Infolists\Components\Fieldset;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Actions;
use Filament\Forms;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Fieldset::make(__('Order Details'))
                ->label(__('filament-panels::resources/pages/order.view.order_details'))
                    ->extraAttributes(['class' => 'bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 p-4 rounded shadow'])
                    ->schema([
                        Infolists\Components\TextEntry::make('status')
                            ->label(__('filament-panels::resources/pages/order.fields.status'))
                            ->badge()
                            ->color(fn ($state) => match ($state) {
                                'pending' => 'warning',
                                'paid' => 'success',
                                'cancelled' => 'danger',
                                default => 'gray',
                            })
                            ->formatStateUsing(fn ($state) => __("filament-panels::resources/pages/order.fields.state.$state")),

                        Infolists\Components\TextEntry::make('customer_name')
                            ->label(__('filament-panels::resources/pages/order.fields.customer_name')),

                        Infolists\Components\TextEntry::make('payment_method')
                            ->label(__('filament-panels::resources/pages/order.fields.payment_method')),

                        Infolists\Components\TextEntry::make('created_at')
                            ->label(__('filament-panels::resources/pages/order.fields.created_at'))
                            ->dateTime(),
                    ]),

                Fieldset::make(__('Order Items'))
                ->label(__('filament-panels::resources/pages/order.view.item_details'))
                    ->schema([
                        RepeatableEntry::make('orderitems')
                        ->label(__('filament-panels::resources/pages/order.view.items'))
                            ->schema([
                                Infolists\Components\TextEntry::make('productitem.title')
                                ->label(__('filament-panels::resources/pages/order.view.product')),
                                Infolists\Components\TextEntry::make('quantity')
                                ->label(__('filament-panels::resources/pages/order.view.quantity')),
                                Infolists\Components\TextEntry::make('optionitem.price')
                                ->label(__('filament-panels::resources/pages/order.view.price')),
                            ])
                          ,
                    ]),
            ]);
    }

    /**
     * Add header actions (e.g. Edit / Update status)
     */
    protected function getHeaderActions(): array
    {
        return [
            // Action to update only status
            Actions\Action::make('updateStatus')
                ->label(__('filament-panels::resources/pages/order.fields.update_status'))
                ->form([
                    Forms\Components\Select::make('status')
                        ->options([
                            'paid' => __('filament-panels::resources/pages/order.fields.paid'),
                                'cancelled' => __('filament-panels::resources/pages/order.fields.cancel')
                        ])
                        ->required()
                        ->default(fn ($record) => $record->status)

                ])
                ->action(function ($record, array $data) {
                    $record->update([
                        'status' => $data['status'],
                    ]);
                })
                ->visible(fn($record) => $record->status === 'pending')
                ->color('primary'),

            // Normal Edit action (if you want full edit)
            // Actions\EditAction::make(),
        ];
    }
}
