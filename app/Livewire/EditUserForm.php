<?php

namespace App\Livewire;

use App\Models\User;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Panel\Concerns\HasNotifications;
use Filament\Support\Colors\Color;
use Livewire\Component;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;

class EditUserForm extends Component implements HasForms
{
    use InteractsWithForms;
    use HasNotifications;

    public array $data;
    public User $user;

    public function mount(User $user): void
    {
        $this->form->fill($user->toArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('avatar')
                    ->avatar()
                    ->columnSpan(1),

                TextInput::make('email')
                    ->disabled(),

                TextInput::make('name')
                    ->required()
                    ->alphaNum()
                    ->minLength(4)
                    ->maxLength(50),

                //must be phone format
                PhoneInput::make('phone')
                    ->rule('phone'),

                Actions::make([
                    Action::make('submit')
                        ->action(fn () => $this->submit())
                        ->label('Save changes')
                        ->color(Color::Rose)
                        ->icon('heroicon-o-check'),

                    Action::make('cancel')
                        ->action(fn () => $this->cancel())
                        ->color(Color::Gray)
                        ->label('Cancel')
                        ->extraAttributes(['class' => 'ml-auto'])
                        ->link()
                ])
            ])
            ->statePath('data')
            ->model($this->user);
    }

    private function submit(): void
    {
        $this->form->validate();

        $this->user->update($this->form->getState());

        Notification::make()->success()
            ->title('Account information updated')
            ->send();
    }

    private function cancel(): void
    {
        $this->form->fill($this->user->toArray());
    }
}
