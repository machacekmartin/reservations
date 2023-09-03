<?php

namespace App\Livewire;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
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
