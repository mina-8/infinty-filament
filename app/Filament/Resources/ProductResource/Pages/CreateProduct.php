<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\Models\ProductOption;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Components;
use Illuminate\Support\Str;
use Pixelpeter\FilamentLanguageTabs\Forms\Components\LanguageTabs;
use Rawilk\FilamentQuill\Filament\Forms\Components\QuillEditor;
class CreateProduct extends CreateRecord
{
    use CreateRecord\Concerns\HasWizard;
    protected static string $resource = ProductResource::class;

    protected function getSteps(): array
    {
        return [
            Step::make(__('filament-panels::resources/pages/product.fields.header'))
                ->description(__('filament-panels::resources/pages/product.fields.description'))
                ->schema([
                    Components\Group::make([
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
                        Components\Select::make('subcategory_id')
                            ->label(__('filament-panels::resources/pages/product.fields.subcategory_id'))
                            ->relationship('subcategory', 'title')
                            ->required(),
                        Components\Select::make('category_id')
                            ->label(__('filament-panels::resources/pages/product.fields.category_id'))
                            ->relationship('category', 'title')
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



                    Components\Toggle::make('avilable')
                        ->label(__('filament-panels::resources/pages/product.fields.available'))
                        ->default(0),

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
                // ->description(__('filament-panels::resources/pages/product.fields.product_option_des'))
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


    protected function mutateFormDataBeforeCreate(array $data): array
    {

        if (!empty($data['title']['ar'])) {
            $data['slug']['ar'] = str_replace(' ', '-', $data['title']['ar']);
        }

        if (!empty($data['title']['en'])) {
            $data['slug']['en'] = str_replace(' ', '-', $data['title']['en']);
        }

        return $data;
    }

    protected function afterCreate(): void
    {
        // حفظ تعليمات الاستخدام بعد إنشاء المنتج
        $ProductOption = $this->form->getState()['product_option'] ?? [];

        if (!empty($ProductOption) && $this->record) {
            foreach ($ProductOption as $option) {
                ProductOption::create([
                    'product_id' => $this->record->id,
                    'title' => $option['title'],
                    'price' => $option['price'],
                ]);
            }
        }
    }
}
