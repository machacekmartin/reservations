<?php

use App\Enums\ReservationStatus;
use App\Models\Reservation;

it('successfully scopes query by reservation statuses', function () {
    Reservation::factory(3)->create();
    Reservation::factory(1)->late()->create();
    Reservation::factory(4)->canceled()->create();
    Reservation::factory(5)->fulfilled()->create();
    Reservation::factory(6)->missed()->create();

    $pending = Reservation::query()->pending()->get();
    $late = Reservation::query()->late()->get();
    $canceled = Reservation::query()->canceled()->get();
    $fulfilled = Reservation::query()->fulfilled()->get();
    $missed = Reservation::query()->missed()->get();

    expect($pending)
        ->toHaveCount(3)
        ->each(fn ($item) => $item->status->toBe(ReservationStatus::PENDING));

    expect($late)
        ->toHaveCount(1)
        ->each(fn ($item) => $item->status->toBe(ReservationStatus::LATE));

    expect($canceled)
        ->toHaveCount(4)
        ->each(fn ($item) => $item->status->toBe(ReservationStatus::CANCELED));

    expect($fulfilled)
        ->toHaveCount(5)
        ->each(fn ($item) => $item->status->toBe(ReservationStatus::FULFILLED));

    expect($missed)
        ->toHaveCount(6)
        ->each(fn ($item) => $item->status->toBe(ReservationStatus::MISSED));
});
