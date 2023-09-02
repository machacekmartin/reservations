<?php

use App\Enums\ReservationStatus;
use App\Jobs\MarkLateReservations;
use App\Models\Reservation;

use function Pest\Laravel\travelTo;

it('marks pending reservation in past as late', function () {
    $reservation = Reservation::factory()->create();

    travelTo($reservation->start_at->addMinute());

    MarkLateReservations::dispatch();

    expect($reservation->fresh())
        ->status->toBe(ReservationStatus::LATE);
});

it('does not mark pending reservation as late because it is not in past yet', function () {
    $reservation = Reservation::factory()->create();

    travelTo($reservation->start_at->subMinute());

    MarkLateReservations::dispatch();

    expect($reservation->wasChanged())->toBeFalse();
});

it('marks multiple pending reservations in the past as late', function () {
    // Create 5 pending reservations in the past scheduled to be marked as Late
    $reservations = Reservation::factory(5)->late()->create(['status' => ReservationStatus::PENDING]);

    // Create one pending reservation in the future not supposed to be marked as Late yet
    $pending = Reservation::factory()->create();

    MarkLateReservations::dispatch();

    expect($reservations->fresh())
        ->each(fn ($item) => $item->status->toBe(ReservationStatus::LATE));

    expect($pending->fresh())
        ->status->toBe(ReservationStatus::PENDING);
});
