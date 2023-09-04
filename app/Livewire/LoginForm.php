<?php

namespace App\Livewire;

use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Panel\Concerns\HasColors;
use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

/**
 * @property-read Form $form
 */
class LoginForm extends Component implements HasForms
{
    use InteractsWithForms;

    public string $email;
    public string $password;
    public bool $remember = false;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('email')
                    ->placeholder('walter@white.bb')
                    ->required()
                    ->email()
                    ->autocomplete()
                    ->autofocus(),
                TextInput::make('password')
                    ->password()
                    ->required()
                    ->prefixIcon('heroicon-o-lock-closed')
                    ->autocomplete(),
                Checkbox::make('remember')
                    ->label('Remember me')
                    ->default(false),
                Actions::make([
                    Action::make('login')
                        ->label('Sign in')
                        ->action(fn () => $this->login())
                        ->icon('heroicon-o-arrow-right')
                        ->iconPosition('after')
                        ->extraAttributes(['class' => 'w-full'])
                ])
            ]);
    }

    public function login(): void
    {
        $this->form->validate();

        $logged = auth()->attempt([
            'email' => $this->email,
            'password' => $this->password,
        ], $this->remember);

        if (! $logged) {
            throw ValidationException::withMessages([
                'email' => __('filament-panels::pages/auth/login.messages.failed'),
            ]);
        }

        redirect()->to(route('reservations'));
    }
}
