<?php

namespace App\Livewire;

use App\Filament\Admin\Resources\ReservationResource\Actions\CancelAction;
use App\Models\Reservation;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\View\View;
use Livewire\Component;

class ReservationCard extends Component implements HasActions, HasForms
{
    use InteractsWithActions;
    use InteractsWithForms;

    public Reservation $reservation;

    public function render(): View
    {
        return view('livewire.reservation-card');
    }

    public function cancelAction(): Action
    {
        return CancelAction::make('cancel-action')->record($this->reservation);
    }

    public function cancel(): void
    {
        $this->mountAction('cancelAction');
    }
}
