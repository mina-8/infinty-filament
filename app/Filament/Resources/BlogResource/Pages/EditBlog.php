<?php

namespace App\Filament\Resources\BlogResource\Pages;

use App\Filament\Resources\BlogResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Storage;

class EditBlog extends EditRecord
{
    protected static string $resource = BlogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
            ->requiresConfirmation()
                ->before(function () {
                    $record = $this->record;
                    if (!empty($record->image) && Storage::disk('public')->exists($record->image)) {
                        Storage::disk('public')->delete($record->image);
                    }
                }),
        ];
    }
    protected function mutateFormDataBeforeSave(array $data): array
    {
        $record = $this->record;

        if (isset($data['image']) && $data['image'] !== $record->image) {
            // Delete the old image if it exists
            if (!empty($record->image) && Storage::disk('public')->exists($record->image)) {
                Storage::disk('public')->delete($record->image);
            }
        }

        $recordTitle = is_array($record->title) ? $record->title : json_decode($record->title, true);
        $dataSlug = is_array($data['slug'] ?? null) ? $data['slug'] : [];

        // تحديث slug العربي
        if (!empty($data['title']['ar']) && (!isset($recordTitle['ar']) || $data['title']['ar'] !== $recordTitle['ar'])) {
            $dataSlug['ar'] = str_replace(' ', '-', $data['title']['ar']);
        }

        // تحديث slug الإنجليزي
        if (!empty($data['title']['en']) && (!isset($recordTitle['en']) || $data['title']['en'] !== $recordTitle['en'])) {
            $dataSlug['en'] = str_replace(' ', '-', $data['title']['en']);
        }

        $data['slug'] = $dataSlug;


        return $data;
    }
}