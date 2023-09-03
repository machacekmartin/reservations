<?php

namespace App\Actions;

use App\Enums\ReservationStatus;
use App\Exceptions\CannotTransitionReservationStatus;
use App\Models\Reservation;

class MissReservationAction
{
    public function run(Reservation $reservation): void
    {
        throw_if(
            $reservation->status !== ReservationStatus::LATE,
            CannotTransitionReservationStatus::for($reservation, 'Reservation cannot be marked as missed')
        );

        $reservation->status = ReservationStatus::MISSED;
        $reservation->save();
    }
}
