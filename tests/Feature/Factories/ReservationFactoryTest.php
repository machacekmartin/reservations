<?php

use App\Enums\ReservationStatus;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Support\Carbon;

it('generates plain reservation', function () {
    $reservation = Reservation::factory()->create();

    expect($reservation->toArray())->toHaveCount(13);

    expect($reservation)
        ->start_at->toBeInstanceOf(Carbon::class)
        ->end_at->toBeInstanceOf(Carbon::class)
        ->remind_at->toBeInstanceOf(Carbon::class)
        ->guest_count->toBeInt()
        ->note->toBeString()
        ->reminded->toBeFalse()
        ->status->toBe(ReservationStatus::PENDING)
        ->canceled_at->toBeNull()
        ->arrived_at->toBeNull()
        ->user->toBeInstanceOf(User::class);

    expect($reservation->start_at->isAfter(now()))->toBeTrue();
});

it('generates late reservation', function () {
    $reservation = Reservation::factory()->late()->create();

    expect($reservation)
        ->canceled_at->toBeNull()
        ->arrived_at->toBeNull()
        ->status->toBe(ReservationStatus::LATE);

    expect($reservation->start_at->isBefore(now()))->toBeTrue();
});

it('generates canceled reservation', function () {
    $reservation = Reservation::factory()->canceled()->create();

    expect($reservation)
        ->arrived_at->toBeNull()
        ->status->toBe(ReservationStatus::CANCELED);

    expect($reservation->canceled_at->isBefore($reservation->start_at))->toBeTrue();
});

it('generates fulfilled reservation', function () {
    $reservation = Reservation::factory()->fulfilled()->create();

    expect($reservation)
        ->canceled_at->toBeNull()
        ->status->toBe(ReservationStatus::FULFILLED);

    expect($reservation->arrived_at->isBefore($reservation->start_at))->toBeTrue();
});

it('generates missed reservation', function () {
    $reservation = Reservation::factory()->missed()->create();

    expect($reservation)
        ->status->toBe(ReservationStatus::MISSED)
        ->canceled_at->toBeNull()
        ->arrived_at->toBeNull();
});
