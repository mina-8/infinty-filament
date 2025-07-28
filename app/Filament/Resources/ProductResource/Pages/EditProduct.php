<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\Models\ProductOption;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Components;
use Illuminate\Support\Str;
use Pixelpeter\FilamentLanguageTabs\Forms\Components\LanguageTabs;
use Rawilk\FilamentQuill\Filament\Forms\Components\QuillEditor;
use Illuminate\Support\Facades\Storage;

class EditProduct extends EditRecord
{
    use EditRecord\Concerns\HasWizard;
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
            ->before(function () {
                    $record = $this->record;

                    // Delete associated image
                    if (!empty($record->images) && Storage::disk('public')->exists($record->images)) {
                        Storage::disk('public')->delete($record->images);
                    }

                    // Delete associated main_image
                    if (!empty($record->main_image) && Storage::disk('public')->exists($record->main_image)) {
                        Storage::disk('public')->delete($record->main_image);
                    }

                    // Delete associated usage instructions
                    ProductOption::where('product_id', $record->id)->delete();
                }),
        ];
    }

    protected function getSteps(): array
    {
        return [
            Step::make(__('filament-panels::resources/pages/product.fields.header'))
                ->description(__('filament-panels::resources/pages/product.fields.description'))
                ->schema([
                    Components\Group::make([
                        Components\Select::make('subcategory_id')
                            ->label(__('filament-panels::resources/pages/product.fields.subcategory_id'))
                            ->relationship('subcategory', 'title')
                            ->required(),

                        LanguageTabs::make([
                            Components\TextInput::make('title')
                                ->label(__('filament-panels::resources/pages/product.fields.title'))
                                ->required(),

                            QuillEditor::make('content')
                                ->label(__('filament-panels::resources/pages/product.fields.content')),

                            Components\Hidden::make('slug')
                                ->label('Slug'),
                        ]),
                    ]),

                    Components\TextInput::make('product_code')
                                ->label(__('filament-panels::resources/pages/product.fields.product_code'))
                                ->required()
                                ->suffixAction(
                                    Components\Actions\Action::make('generatecode')
                                    ->label(__('filament-panels::resources/pages/product.fields.generatecode'))
                                    ->icon('heroicon-o-pencil-square')
                                    ->action( function($livewire , $state){
                                        $livewire->form->fill([
                                            'product_code' => strtoupper(Str::random(14))
                                        ]);
                                    })
                                ),

                    Components\Toggle::make('avilable')
                        ->label(__('filament-panels::resources/pages/product.fields.available'))
                        ->default(1),

                    Components\Select::make('state')
                            ->label(__('filament-panels::resources/pages/product.fields.state'))
                            ->options([
                                'new' => __('filament-panels::resources/pages/product.fields.state_product.new'),
                                'special' => __('filament-panels::resources/pages/product.fields.state_product.special'),
                                'top' => __('filament-panels::resources/pages/product.fields.state_product.top'),
                                'kids' => __('filament-panels::resources/pages/product.fields.state_product.kids'),
                            ])
                            ->required(),

                    Components\Select::make('rate')
                            ->label(__('filament-panels::resources/pages/product.fields.rate'))
                            ->options([
                                '0' => '0',
                                '1' => '1',
                                '2' => '2',
                                '3' => '3',
                                '4' => '4',
                                '5' => '5'
                            ])
                            ->default(0),

                    Components\FileUpload::make('main_image')
                        ->label(__('filament-panels::resources/pages/product.fields.main_image'))
                        ->image()
                        ->disk('public')
                        ->directory('uploads/product')
                        ->visibility('public')
                        ->maxSize(4096)
                        ->getUploadedFileNameForStorageUsing(function ($file) {
                            $extension = $file->getClientOriginalExtension();
                            return Str::uuid() . '.' . $extension;
                        })
                        ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp'])
                        ->required(),

                    Components\FileUpload::make('images')
                        ->label(__('filament-panels::resources/pages/product.fields.images'))
                        ->image()
                        ->disk('public')
                        ->directory('uploads/product')
                        ->visibility('public')
                        ->maxSize(4096)
                        ->getUploadedFileNameForStorageUsing(function ($file) {
                            $extension = $file->getClientOriginalExtension();
                            return Str::uuid() . '.' . $extension;
                        })
                        ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp'])
                        ->multiple(),

                ]),

            Step::make(__('filament-panels::resources/pages/product.fields.product_option'))
                ->description(__('filament-panels::resources/pages/product.fields.product_option_des'))
                ->schema([
                    Components\Repeater::make('product_option')
                        ->label(__('filament-panels::resources/pages/product.fields.product_option_make'))
                        ->schema([
                            LanguageTabs::make([
                                Components\TextInput::make('title')
                                    ->label(__('filament-panels::resources/pages/product.fields.optiontitle'))
                                    ->required(),
                                ]),
                                Components\TextInput::make('price')
                                    ->label(__('filament-panels::resources/pages/product.fields.price')),
                        ])
                        ->addActionLabel(__('filament-panels::resources/pages/product.fields.add_option'))
                        ->collapsible()
                        ->itemLabel(fn(array $state): ?string => $state['title']['en'] ?? $state['title']['ar'] ?? null)
                        ->required(),
                ]),
        ];
    }

    protected function getDefaultProductOption(): array
    {
        // Load existing usage instructions for the product
        return ProductOption::where('product_id', $this->record->id)
            ->get()
            ->map(function ($product_option) {
                // Get the raw attributes to ensure we have the actual stored data
                $attributes = $product_option->getAttributes();

                // For Spatie translatable fields, they are stored as JSON in the database
                // but accessed as arrays through the model's accessor
                $title = is_string($attributes['title']) ? json_decode($attributes['title'], true) : $attributes['title'];


                return [
                    'id' => $product_option->id,
                    'title' => $title,
                    'price' => $attributes['price'],
                ];
            })
            ->toArray();
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['product_option'] = $this->getDefaultProductOption();
        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $record = $this->record;

        // Handle images file replacement
        if (isset($data['images']) && $data['images'] !== $record->images) {
            if (!empty($record->images) && Storage::disk('public')->exists($record->images)) {
                Storage::disk('public')->delete($record->images);
            }
        }

        // Handle main_image file replacement
        if (isset($data['main_image']) && $data['main_image'] !== $record->main_image) {
            if (!empty($record->main_image) && Storage::disk('public')->exists($record->main_image)) {
                Storage::disk('public')->delete($record->main_image);
            }
        }

        // Generate slugs for updated titles
        if (!empty($data['title']['ar'])) {
            $data['slug']['ar'] = str_replace(' ', '-', $data['title']['ar']);
        }

        if (!empty($data['title']['en'])) {
            $data['slug']['en'] = str_replace(' ', '-', $data['title']['en']);
        }


        return $data;
    }

    protected function afterSave(): void
    {
        // Handle usage instructions
        $ProductOption = $this->form->getState()['product_option'] ?? [];
        $existingIds = ProductOption::where('product_id', $this->record->id)->pluck('id')->toArray();
        $submittedIds = array_filter(array_column($ProductOption, 'id'));

        // Delete removed usage instructions
        $idsToDelete = array_diff($existingIds, $submittedIds);
        if (!empty($idsToDelete)) {
            ProductOption::whereIn('id', $idsToDelete)->delete();
        }

        // Create or update usage instructions
        foreach ($ProductOption as $options) {
            $data = [
                'product_id' => $this->record->id,
                'title' => $options['title'],
                'price' => $options['price'],
            ];

            if (isset($options['id']) && in_array($options['id'], $existingIds)) {
                // Update existing instruction
                ProductOption::where('id', $options['id'])->update($data);
            } else {
                // Create new instruction
                ProductOption::create($data);
            }
        }
    }
}
