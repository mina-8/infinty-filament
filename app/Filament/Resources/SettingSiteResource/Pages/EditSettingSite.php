<?php

namespace App\Filament\Resources\SettingSiteResource\Pages;

use App\Filament\Resources\SettingSiteResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSettingSite extends EditRecord
{
    protected static string $resource = SettingSiteResource::class;

    // protected function getHeaderActions(): array
    // {
    //     return [
    //         Actions\DeleteAction::make(),
    //     ];
    // }
}
