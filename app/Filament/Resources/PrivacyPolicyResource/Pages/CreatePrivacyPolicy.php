<?php

namespace App\Filament\Resources\PrivacyPolicyResource\Pages;

use App\Filament\Resources\PrivacyPolicyResource;
use App\Models\PrivacyPolicy;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Redirect;
class CreatePrivacyPolicy extends CreateRecord
{
    protected static string $resource = PrivacyPolicyResource::class;

    protected static bool $canCreateAnother = false;

    public function mount(): void
    {
        parent::mount();

        if (PrivacyPolicy::where('id', 1)->exists()) {
            Notification::make()
                ->title(__('filament-panels::resources/pages/aboutus.Notification.title'))
                ->danger()
                ->body(__('filament-panels::resources/pages/aboutus.Notification.body'))
                ->send();

            Redirect::to(static::$resource::getUrl('index'));
        }
    }
}
