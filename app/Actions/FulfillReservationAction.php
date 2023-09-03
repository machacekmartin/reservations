<?php

namespace App\Actions;

use App\Enums\ReservationStatus;
use App\Exceptions\CannotTransitionReservationStatus;
use App\Models\Reservation;
use Illuminate\Support\Carbon;

class FulfillReservationAction
{
    public function run(Reservation $reservation, Carbon $at): void
    {
        throw_unless(
            in_array($reservation->status, [ReservationStatus::PENDING, ReservationStatus::LATE]),
            CannotTransitionReservationStatus::for($reservation, 'Reservation cannot be fulfilled')
        );

        $reservation->arrived_at = $at;
        $reservation->status = ReservationStatus::FULFILLED;
        $reservation->save();
    }
}
