<?php

namespace App\Filament\Resources\DeliveryResource\Pages;

use App\Filament\Resources\DeliveryResource;
use App\Models\Delivery;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Redirect;
class CreateDelivery extends CreateRecord
{
    protected static string $resource = DeliveryResource::class;

    protected static bool $canCreateAnother = false;

    public function mount(): void
    {
        parent::mount();

        if (Delivery::where('id', 1)->exists()) {
            Notification::make()
                ->title(__('filament-panels::resources/pages/aboutus.Notification.title'))
                ->danger()
                ->body(__('filament-panels::resources/pages/aboutus.Notification.body'))
                ->send();

            Redirect::to(static::$resource::getUrl('index'));
        }
    }
}
