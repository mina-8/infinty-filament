<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlogResource\Pages;
use App\Filament\Resources\BlogResource\RelationManagers;
use App\Models\Blog;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Pixelpeter\FilamentLanguageTabs\Forms\Components\LanguageTabs;
use Rawilk\FilamentQuill\Filament\Forms\Components\QuillEditor;

class BlogResource extends Resource
{
    protected static ?string $model = Blog::class;

    protected static ?string $navigationIcon = 'heroicon-o-bold';

    public static function getNavigationGroup(): string
    {
        return __('filament-panels::layout.webist.control webiste');
    }

    public static function getModelLabel(): string
    {
        return __('filament-panels::resources/pages/blog.title');
    }
    public static function getPluralModelLabel(): string
    {
        return __('filament-panels::resources/pages/blog.title');
    }
    public static function getNavigationLabel(): string
    {
        return __('filament-panels::resources/pages/blog.title');
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(1)
                    ->schema([
                        LanguageTabs::make([
                            TextInput::make('title')
                                ->label(__('filament-panels::resources/pages/blog.fields.title'))
                                ->required(),
                            QuillEditor::make('content')
                                ->label(__('filament-panels::resources/pages/blog.fields.content'))

                                ->required(),
                            Hidden::make('slug')

                        ]),
                        FileUpload::make('image')
                            ->label(__('filament-panels::resources/pages/blog.fields.image'))
                            ->image()
                            ->disk('public')
                            ->directory('uploads/blog')
                            ->visibility('public')
                            ->getUploadedFileNameForStorageUsing(function ($file) {
                                $extension = $file->getClientOriginalExtension();
                                return Str::uuid() . '.' . $extension;
                            })
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp'])
                            ->required(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('title')
                    ->label(__('filament-panels::resources/pages/blog.fields.title'))
                    ->searchable(),
                TextColumn::make('content')
                    ->label(__('filament-panels::resources/pages/blog.fields.content'))
                    ->limit(50)
                    ->html(),
                ImageColumn::make('image')
                    ->label(__('filament-panels::resources/pages/blog.fields.image'))
                    ->disk('public')
                    ->square()
                    ->size(60),
                TextColumn::make('created_at')
                    ->label(__('filament-panels::resources/pages/blog.fields.created_at'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation()
                    ->before(function (Blog $record) {
                        if (!empty($record->image) && Storage::disk('public')->exists($record->image)) {
                            Storage::disk('public')->delete($record->image);
                        }
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                     ->label(__('filament-panels::resources/pages/blog.actions.delete.label'))
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
            'index' => Pages\ListBlogs::route('/'),
            'create' => Pages\CreateBlog::route('/create'),
            'edit' => Pages\EditBlog::route('/{record}/edit'),
        ];
    }
}
