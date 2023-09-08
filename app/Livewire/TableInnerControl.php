<?php

namespace App\Livewire;

use App\Enums\ReservationStatus;
use App\Models\Reservation;
use App\Models\Table;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;

/**
 * @property-read Reservation|null $currentReservation
 * @property-read Reservation|null $soonestReservation
 */
class TableInnerControl extends Component
{
    public Table $table;

    public string $avatarUrl;

    public string $userHref;

    public function render(): View
    {
        return view('livewire.table-inner-control');
    }

    public function getPercentage(): float
    {
        if ($this->currentReservation == null) {
            return 0;
        }

        $current = now();

        $duration = $this->currentReservation->end_at->diffInMinutes($this->currentReservation->start_at);

        $elapsed = $current->diffInMinutes($this->currentReservation->start_at);

        return $elapsed / $duration * 100;
    }

    public function getCurrentUserAvatar(): ?string
    {
        if ($this->currentReservation === null) {
            return null;
        }

        return $this->currentReservation->user->avatar ?? Filament::getUserAvatarUrl($this->currentReservation->user);
    }

    public function getIsCurrentReservationFulfilled(): bool
    {
        if ($this->currentReservation === null) {
            return false;
        }

        return $this->currentReservation->status === ReservationStatus::FULFILLED;
    }

    #[Computed]
    public function soonestReservation(): ?Reservation
    {
        return $this->table->soonestReservation;
    }

    #[Computed]
    public function currentReservation(): ?Reservation
    {
        return $this->table->currentReservation;
    }

    #[Computed]
    public function currentUser(): ?User
    {
        return $this->table->currentReservation?->user;
    }
}
