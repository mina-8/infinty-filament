<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SlideResource\Pages;
use App\Filament\Resources\SlideResource\RelationManagers;
use App\Models\Slide;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use Pixelpeter\FilamentLanguageTabs\Forms\Components\LanguageTabs;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use function PHPUnit\Framework\callback;
use Rawilk\FilamentQuill\Filament\Forms\Components\QuillEditor;
class SlideResource extends Resource
{
    protected static ?string $model = Slide::class;

    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-bar';



    public static function getNavigationGroup(): string
    {
        return __('filament-panels::layout.webist.control webiste');
    }

    public static function getNavigationSort(): ?int
    {
        return 1; // Lower numbers appear first
    }

    public static function getModelLabel(): string
    {
        return __('filament-panels::resources/pages/slide.title');
    }
    public static function getPluralModelLabel(): string
    {
        return __('filament-panels::resources/pages/slide.title');
    }
    public static function getNavigationLabel(): string
    {
        return __('filament-panels::resources/pages/slide.title');
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(1)
                    ->schema([
                        LanguageTabs::make([
                            Forms\Components\TextInput::make('title')
                                ->label(__('filament-panels::resources/pages/slide.fields.title'))
                                ->required(),
                            QuillEditor::make('content')
                                ->label(__('filament-panels::resources/pages/slide.fields.content'))
                                ->required(),

                        ]),

                        Forms\Components\Toggle::make('active_btn')
                            ->label(__('filament-panels::resources/pages/slide.fields.active_btn'))
                            ->default(false)
                            ->reactive(),
                        LanguageTabs::make([
                            Forms\Components\TextInput::make('str_btn')
                                ->label(__('filament-panels::resources/pages/slide.fields.str_btn'))
                                ->disabled(fn(callable $get) => !$get('active_btn')),

                        ]),

                        Forms\Components\TextInput::make('link')
                            ->label(__('filament-panels::resources/pages/slide.fields.link'))

                            ->disabled(fn(callable $get) => !$get('active_btn')),


                        Forms\Components\FileUpload::make('image')
                            ->label(__('filament-panels::resources/pages/slide.fields.image'))
                            ->image()
                            ->disk('public')
                            ->directory('uploads/slides')
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
                    ->label(__('filament-panels::resources/pages/blog.fields.title'))
                    ->searchable(),

                Tables\Columns\ImageColumn::make('image')
                    ->label(__('filament-panels::resources/pages/blog.fields.image'))
                    ->disk('public')
                    ->square()
                    ->size(60),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('filament-panels::resources/pages/blog.fields.created_at'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label(__('filament-panels::resources/pages/blog.actions.edit.label')),

                Tables\Actions\DeleteAction::make()
                    ->label(__('filament-panels::resources/pages/blog.actions.delete.label'))
                    ->requiresConfirmation()
                    ->before(function (Slide $record) {
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
            'index' => Pages\ListSlides::route('/'),
            'create' => Pages\CreateSlide::route('/create'),
            'edit' => Pages\EditSlide::route('/{record}/edit'),
        ];
    }
}
