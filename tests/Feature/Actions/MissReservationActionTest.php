<?php

use App\Actions\MissReservationAction;
use App\Enums\ReservationStatus;
use App\Exceptions\CannotTransitionReservationStatus;
use App\Models\Reservation;

it('marks a reservation as missed', function () {
    $reservation = Reservation::factory()->late()->create();

    app(MissReservationAction::class)->run($reservation);

    expect($reservation)
        ->status->toBe(ReservationStatus::MISSED);
});

it('throws error when attempting to mark reservation as missed because of wrong current status', function (ReservationStatus $status) {
    $reservation = Reservation::factory()->create(['status' => $status]);

    app(MissReservationAction::class)->run($reservation);

    expect($reservation)
        ->status->toBe($status);
})->with([
    ReservationStatus::PENDING,
    ReservationStatus::CANCELED,
    ReservationStatus::FULFILLED,
    ReservationStatus::MISSED,
])->throws(CannotTransitionReservationStatus::class);
