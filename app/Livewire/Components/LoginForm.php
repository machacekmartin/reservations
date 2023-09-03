<?php

namespace App\Livewire\Components;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\View\View;
use Livewire\Component;

class LoginForm extends Component implements HasForms
{
    use InteractsWithForms;

    public string $email;
    public string $password;

    public function render(): View
    {
        return view('livewire.components.login-form');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('email')
                    ->placeholder('user@reservations.test')
                    ->email()
                    ->required(),
                TextInput::make('password')
                    ->password()
                    ->minLength(4)
                    ->required(),
            ]);
    }

    public function notify(): void
    {
        $this->dispatch('notify', 'LULIK');
    }

    public function login(): void
    {
        $logged = auth()->attempt([
            'email' => $this->email,
            'password' => $this->password,
        ]);

        if ($logged) {
            redirect()->route('reservations');
        } else {
            session()->flash('error', 'email and password are wrong.');
        }
    }
}
