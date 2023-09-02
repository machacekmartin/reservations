<?php

use App\Jobs\MarkLateReservations;
use App\Jobs\SendReservationReminders;
use Illuminate\Console\Scheduling\Schedule;

it('schedules marking of pending reservations in the past as late', function () {
    $added = collect(app()->make(Schedule::class)->events())
        ->pluck('description')
        ->contains(MarkLateReservations::class);

    expect($added)->toBeTrue();
});

it('schedules reservation reminders sending', function () {
    $added = collect(app()->make(Schedule::class)->events())
        ->pluck('description')
        ->contains(SendReservationReminders::class);

    expect($added)->toBeTrue();
});
