<?php

namespace App\Filament\Resources\GuestResource\Pages;

use App\Filament\Resources\GuestResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewGuest extends ViewRecord
{
    protected static string $resource = GuestResource::class;

    public function infolist(\Filament\Infolists\Infolist $infolist): \Filament\Infolists\Infolist
    {
        return $infolist
            ->schema([
                \Filament\Infolists\Components\Fieldset::make('')
                    ->extraAttributes(['class' => 'bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 p-4 rounded shadow'])
                    ->schema([
                        \Filament\Infolists\Components\TextEntry::make('name')
                            ->label(__('filament-panels::resources/pages/user.fields.name')),
                        \Filament\Infolists\Components\TextEntry::make('email')
                            ->label(__('filament-panels::resources/pages/user.fields.email')),
                        \Filament\Infolists\Components\TextEntry::make('phone')
                            ->label(__('filament-panels::resources/pages/user.fields.phone')),
                        \Filament\Infolists\Components\TextEntry::make('street')
                            ->label(__('filament-panels::resources/pages/user.fields.street')),
                        \Filament\Infolists\Components\TextEntry::make('block')
                            ->label(__('filament-panels::resources/pages/user.fields.block')),
                        \Filament\Infolists\Components\TextEntry::make('area')
                            ->label(__('filament-panels::resources/pages/user.fields.area')),
                        \Filament\Infolists\Components\TextEntry::make('building')
                            ->label(__('filament-panels::resources/pages/user.fields.building')),
                        \Filament\Infolists\Components\TextEntry::make('complex')
                            ->label(__('filament-panels::resources/pages/user.fields.complex')),
                        \Filament\Infolists\Components\TextEntry::make('floore_number')
                            ->label(__('filament-panels::resources/pages/user.fields.floore_number')),
                        \Filament\Infolists\Components\TextEntry::make('flat_number')
                            ->label(__('filament-panels::resources/pages/user.fields.flat_number')),
                        \Filament\Infolists\Components\TextEntry::make('land_mark')
                            ->label(__('filament-panels::resources/pages/user.fields.land_mark')),

                        \Filament\Infolists\Components\TextEntry::make('created_at')
                            ->label(__('filament-panels::resources/pages/user.fields.created_at'))
                            ->dateTime(),
                    ]),
            ]);
    }
}
