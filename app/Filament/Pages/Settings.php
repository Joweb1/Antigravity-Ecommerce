<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use App\Models\Setting;

class Settings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog';
    protected static ?string $navigationGroup = 'Settings';

    protected static string $view = 'filament.pages.settings';

    protected static ?string $title = 'Site Settings';
    protected static ?string $navigationLabel = 'Site Settings';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'admin_email' => Setting::where('key', 'admin_email')->first()?->value,
            'smtp_host' => Setting::where('key', 'smtp_host')->first()?->value,
            'smtp_port' => Setting::where('key', 'smtp_port')->first()?->value,
            'smtp_username' => Setting::where('key', 'smtp_username')->first()?->value,
            'smtp_password' => Setting::where('key', 'smtp_password')->first()?->value,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Admin Email Settings')
                    ->description('Email address for admin notifications.')
                    ->schema([
                        TextInput::make('admin_email')
                            ->label('Admin Email')
                            ->email()
                            ->required(),
                    ]),
                Section::make('SMTP Settings')
                    ->description('Configure your email sending service.')
                    ->schema([
                        TextInput::make('smtp_host')
                            ->label('SMTP Host')
                            ->required(),
                        TextInput::make('smtp_port')
                            ->label('SMTP Port')
                            ->numeric()
                            ->required(),
                        TextInput::make('smtp_username')
                            ->label('SMTP Username')
                            ->nullable(),
                        TextInput::make('smtp_password')
                            ->label('SMTP Password')
                            ->password()
                            ->nullable()
                            ->revealable(),
                    ]),
            ])
            ->statePath('data');
    }

    public function submit(): void
    {
        $data = $this->form->getState();

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        Notification::make()
            ->title('Settings saved successfully.')
            ->success()
            ->send();
    }
}