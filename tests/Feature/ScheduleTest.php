<?php

use App\Jobs\MarkLateReservations;
use Illuminate\Console\Scheduling\Schedule;

it('schedules marking of pending reservations in the past as late', function () {
    $added = collect(app()->make(Schedule::class)->events())
        ->pluck('description')
        ->contains(MarkLateReservations::class);

    expect($added)->toBeTrue();
});
