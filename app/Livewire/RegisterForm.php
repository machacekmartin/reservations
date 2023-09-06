<?php

namespace App\Livewire;

use App\Models\User;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;

/**
 * @property-read Form $form
 */
class RegisterForm extends Component implements HasForms
{
    use InteractsWithForms;

    public string $email;
    public string $name;
    public string $password;
    public string $password_confirmation;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make()->schema([
                    TextInput::make('email')
                        ->placeholder('walter@white.bb')
                        ->unique('users', 'email')
                        ->email()
                        ->required(),
                    TextInput::make('name')
                        ->placeholder('Walter White')
                        ->alphaNum()
                        ->minLength(4)
                        ->maxLength(50)
                        ->required(),
                ]),
                TextInput::make('password')
                    ->password()
                    ->confirmed()
                    ->minLength(8)
                    ->prefixIcon('heroicon-o-lock-closed')
                    ->autocomplete(false)
                    ->required(),
                TextInput::make('password_confirmation')
                    ->password()
                    ->prefixIcon('heroicon-o-lock-closed')
                    ->autocomplete(false)
                    ->required(),
                Actions::make([
                    Action::make('register')
                        ->label('Register')
                        ->action(fn () => $this->register())
                        ->icon('heroicon-o-arrow-long-right')
                        ->iconPosition('after')
                        ->extraAttributes(['class' => 'w-full']),
                ]),
            ]);
    }

    public function register(): void
    {
        $this->form->validate();

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
        ]);

        $user->assignRole('user');

        auth()->login($user);

        redirect()->to(route('reservations'));
    }
}
