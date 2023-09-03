<?php

use App\Actions\CancelReservationAction;
use App\Enums\ReservationStatus;
use App\Exceptions\CannotTransitionReservationStatus;
use App\Models\Reservation;

it('marks a reservation as canceled', function () {
    $reservation = Reservation::factory()->create();

    app(CancelReservationAction::class)->run($reservation);

    expect($reservation)
        ->canceled_at->not->toBeNull()
        ->status->toBe(ReservationStatus::CANCELED);
});

it('throws error when attempting to mark reservation as canceled because of wrong current status', function (ReservationStatus $status) {
    $reservation = Reservation::factory()->create(['status' => $status]);

    app(CancelReservationAction::class)->run($reservation);

    expect($reservation)
        ->canceled_at->toBeNull()
        ->status->toBe($status);

})->with([
    ReservationStatus::LATE,
    ReservationStatus::CANCELED, // this one should have canceled_at, but it won't  since we create them by overriding status only..
    ReservationStatus::FULFILLED,
    ReservationStatus::MISSED,
])->throws(CannotTransitionReservationStatus::class);
