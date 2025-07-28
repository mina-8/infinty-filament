<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Rawilk\FilamentQuill\Filament\Forms\Components\QuillEditor;
use Illuminate\Support\Str;
use Pixelpeter\FilamentLanguageTabs\Forms\Components\LanguageTabs;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationGroup(): string
    {
        return __('filament-panels::layout.webist.product');
    }

    public static function getModelLabel(): string
    {
        return __('filament-panels::resources/pages/category.title');
    }
    public static function getPluralModelLabel(): string
    {
        return __('filament-panels::resources/pages/category.title');
    }
    public static function getNavigationLabel(): string
    {
        return __('filament-panels::resources/pages/category.title');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(1)
                    ->schema([
                        Forms\Components\FileUpload::make('icon')
                            ->label(__('filament-panels::resources/pages/category.fields.icon'))
                            ->image()
                            ->imageEditorAspectRatios([
                                '16:9',
                                '4:3',
                                '1:1',
                            ])
                            ->disk('public')
                            ->directory('uploads/category')
                            ->visibility('public')
                            ->maxSize(4096)
                            ->getUploadedFileNameForStorageUsing(function ($file) {
                                $extension = $file->getClientOriginalExtension();
                                return Str::uuid() . '.' . $extension;
                            })
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp'])
                            ->required(),
                        LanguageTabs::make([
                            Forms\Components\TextInput::make('title')
                                ->label(__('filament-panels::resources/pages/category.fields.title'))
                                ->required(),
                            QuillEditor::make('content')
                                ->label(__('filament-panels::resources/pages/category.fields.content')),
                            Forms\Components\Hidden::make('slug')
                                ->label('slug'),
                        ]),

                        Forms\Components\FileUpload::make('image')
                            ->label(__('filament-panels::resources/pages/category.fields.image'))
                            ->image()
                            ->disk('public')
                            ->directory('uploads/category')
                            ->visibility('public')
                            ->maxSize(4096)
                            ->getUploadedFileNameForStorageUsing(function ($file) {
                                $extension = $file->getClientOriginalExtension();
                                return Str::uuid() . '.' . $extension;
                            })
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp'])
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->label(__('filament-panels::resources/pages/category.fields.title'))
                    ->searchable(),

                Tables\Columns\ImageColumn::make('icon')
                    ->label(__('filament-panels::resources/pages/category.fields.image'))
                    ->disk('public')
                    ->square()
                    ->size(60),
                Tables\Columns\ImageColumn::make('image')
                    ->label(__('filament-panels::resources/pages/category.fields.image'))
                    ->disk('public')
                    ->square()
                    ->size(60),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('filament-panels::resources/pages/category.fields.created_at'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label(__('filament-panels::resources/pages/category.actions.edit.label')),


                Tables\Actions\DeleteAction::make()
                    ->label(__('filament-panels::resources/pages/category.actions.delete.label'))
                    ->requiresConfirmation()
                    ->before(function (Category $record) {
                        if (!empty($record->image) && Storage::disk('public')->exists($record->image)) {
                            Storage::disk('public')->delete($record->image);
                        }
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label(__('filament-panels::resources/pages/category.actions.delete.label'))
                        ->before(function (Collection $records) {
                            foreach ($records as $record) {
                                if (!empty($record->image) && Storage::disk('public')->exists($record->image)) {
                                    Storage::disk('public')->delete($record->$record->image);
                                }
                            }
                        }),
                ]),
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
