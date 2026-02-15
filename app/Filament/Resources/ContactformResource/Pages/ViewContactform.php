<?php

namespace App\Filament\Resources\ContactformResource\Pages;

use App\Filament\Resources\ContactformResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists;
use Filament\Infolists\Components\Fieldset;
class ViewContactform extends ViewRecord
{
    protected static string $resource = ContactformResource::class;

    public function mount(int|string $record): void
    {
        parent::mount($record);

        $this->record->markAsRead();
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Fieldset::make('')
                ->extraAttributes(['class' => 'bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 p-4 rounded shadow'])
                    ->schema([
                        // Infolists\Components\TextEntry::make('type')
                        //     ->label(__('filament-panels::resources/pages/contactus.fields.type'))
                        //     ->formatStateUsing(fn(string $state) => __('filament-panels::resources/pages/contactus.fields.' . $state)),
                        Infolists\Components\TextEntry::make('first_name')
                            ->label(__('filament-panels::resources/pages/contactus.fields.name'))
                            ->formatStateUsing(fn ($record) => $record->first_name . ' ' . $record->last_name),
                        Infolists\Components\TextEntry::make('email')
                            ->label(__('filament-panels::resources/pages/contactus.fields.email')),
                        Infolists\Components\TextEntry::make('phone')
                            ->label(__('filament-panels::resources/pages/contactus.fields.phone')),
                        Infolists\Components\TextEntry::make('country')
                            ->label(__('filament-panels::resources/pages/contactus.fields.country')),
                        Infolists\Components\TextEntry::make('message')
                            ->label(__('filament-panels::resources/pages/contactform.fields.message')),

                        Infolists\Components\TextEntry::make('created_at')
                            ->label(__('filament-panels::resources/pages/contactform.fields.created_at'))
                            ->dateTime(),
                    ]),

            ]);
    }
}
