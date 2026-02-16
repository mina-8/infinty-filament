<?php

namespace App\Filament\Pages;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use App\Models\SettingSite as SettingSiteModel;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Pixelpeter\FilamentLanguageTabs\Forms\Components\LanguageTabs;
use Rawilk\FilamentQuill\Filament\Forms\Components\QuillEditor;

class SettingSite extends Page implements HasForms
{
    use InteractsWithForms;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.setting-site';

    // public static function getNavigationGroup(): string
    // {
    //     return __('filament-panels::layout.webist.settingsite');
    // }

    public function getHeading(): string
    {
        return __('filament-panels::resources/pages/sitesetting.title');
    }
    public function getTitle(): string
    {
        return __('filament-panels::resources/pages/sitesetting.title');
    }
    public static function getNavigationLabel(): string
    {
        return __('filament-panels::resources/pages/sitesetting.title');
    }

    public $locale;
    public $whats_app;
    public $email_website;
    public $privacy_policies;
    public $deliveries;
    public $aboutus;
    public function mount(): void
    {
        $this->form->fill([
            'whats_app' => SettingSiteModel::getValue('whats_app'),
            'email_website' => SettingSiteModel::getValue('email_website'),
            'privacy_policies' => json_decode(SettingSiteModel::getValue('privacy_policies', '[]'), true),
            'deliveries' => json_decode(SettingSiteModel::getValue('deliveries', '[]'), true),
            'aboutus' => json_decode(SettingSiteModel::getValue('aboutus', '[]'), true),
        ]);
    }

    protected function getFormSchema(): array
    {
        return [
            Tabs::make('tabs')
                ->tabs([
                    Tab::make('site setting')
                        ->label(__('filament-panels::resources/pages/sitesetting.tabs.sitesetting'))
                        ->schema([

                            LanguageTabs::make([

                                QuillEditor::make('privacy_policies')
                                    ->label(__('filament-panels::resources/pages/sitesetting.fields.privacy_policies')),
                                QuillEditor::make('deliveries')
                                    ->label(__('filament-panels::resources/pages/sitesetting.fields.deliveries'))

                            ]),
                        ]),
                    Tab::make('about_us')
                        ->label(__('filament-panels::resources/pages/sitesetting.tabs.about_us'))
                        ->schema([
                            LanguageTabs::make([

                                QuillEditor::make('aboutus')
                                    ->label(__('filament-panels::resources/pages/sitesetting.fields.aboutus')),

                            ]),
                        ]),
                    Tab::make('whats_app')
                        ->label(__('filament-panels::resources/pages/sitesetting.tabs.whats_app_email'))
                        ->schema([
                            TextInput::make('whats_app')
                                ->label(__('filament-panels::resources/pages/sitesetting.fields.whats_app'))
                                ->tel()
                                ->maxLength(20),
                            TextInput::make('email_website')
                                ->label(__('filament-panels::resources/pages/sitesetting.fields.email_website'))
                                ->email()
                                ->maxLength(255),
                        ]),
                ])
        ];
    }

    public function save(): void
    {
        $data = $this->form->getState();

        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $value = json_encode($value, JSON_UNESCAPED_UNICODE);
            }

            SettingSiteModel::setValue($key, $value);
        }

        Notification::make()
            ->title(__('filament-panels::resources/pages/sitesetting.success'))
            ->success()
            ->send();
    }
}
