<?php

namespace App\Actions;

use App\Enums\ReservationStatus;
use App\Exceptions\CannotTransitionReservationStatus;
use App\Models\Reservation;

class CancelReservationAction
{
    public function run(Reservation $reservation): void
    {
        throw_if(
            $reservation->status !== ReservationStatus::PENDING,
            CannotTransitionReservationStatus::for($reservation, 'Reservation cannot be canceled')
        );

        $reservation->canceled_at = now();
        $reservation->status = ReservationStatus::CANCELED;
        $reservation->save();
    }
}
