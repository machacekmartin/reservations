<?php

use App\Actions\CancelReservationAction;
use App\Actions\FulfillReservationAction;
use App\Enums\ReservationStatus;
use App\Exceptions\CannotTransitionReservationStatus;
use App\Models\Reservation;

it('marks a reservation as fulfilled', function (ReservationStatus $status) {
    $reservation = Reservation::factory()->create(['status' => $status]);

    $now = now();
    app(FulfillReservationAction::class)->run($reservation, $now);

    expect($reservation)
        ->arrived_at->toDateTimeString()->toBe($now->toDateTimeString())
        ->status->toBe(ReservationStatus::FULFILLED);
})->with([
    ReservationStatus::PENDING,
    ReservationStatus::LATE,
]);

it('throws error when attempting to mark reservation as fulfilled because of wrong current status', function (ReservationStatus $status) {
    $reservation = Reservation::factory()->create(['status' => $status]);

    app(FulfillReservationAction::class)->run($reservation, now());

    expect($reservation)
        ->arrived_at->toBeNull()
        ->status->toBe($status);
})->with([
    ReservationStatus::CANCELED,
    ReservationStatus::FULFILLED, // this one should have arrived_at, but it won't  since we create them by overriding status only..
    ReservationStatus::MISSED,
])->throws(CannotTransitionReservationStatus::class);
