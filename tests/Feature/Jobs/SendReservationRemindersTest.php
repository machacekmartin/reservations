<?php

use App\Jobs\SendReservationReminders;
use App\Mail\RemindReservation;
use App\Models\Reservation;
use Illuminate\Support\Facades\Mail;

use function Pest\Laravel\travelTo;

it('sends out reservation reminder to user and sets reminded flag', function () {
    Mail::fake();

    $reservation = Reservation::factory()->create();

    travelTo($reservation->remind_at);

    SendReservationReminders::dispatch();

    Mail::assertSent(RemindReservation::class, function (RemindReservation $email) use ($reservation) {
        return $email->hasTo($reservation->user->email);
    });

    expect($reservation->fresh())
        ->reminded->toBeTrue();
});

it('does not send out reservation reminder', function (Reservation $reservation) {
    Mail::fake();

    SendReservationReminders::dispatch();

    Mail::assertNotSent(RemindReservation::class);

    expect($reservation->wasChanged())->toBeFalse();
})->with([
    'not pending status' => fn () => Reservation::factory()->late()->create(),
    'already reminded' => fn () => Reservation::factory()->create(['reminded' => true]),
    'reminder not activated' => fn () => Reservation::factory()->create(['remind_at' => null]),
    'reminder is in the future' => fn () => Reservation::factory()->create(['remind_at' => now()->addMinute()]),
]);

it('send out multiple compliant reservation reminders', function () {
    Mail::fake();

    $reservations = Reservation::factory(5)->sequence(
        ['reminded' => true],
        ['remind_at' => null],
        ['remind_at' => now()->addMinute()],
        ['remind_at' => now()],
        ['remind_at' => now()->subMinutes(1)],
    )->create();

    SendReservationReminders::dispatch();

    Mail::assertSentCount(2);

    expect($reservations->fresh()->pluck('reminded')->toArray())
        ->toBe([true, false, false, true, true]);
});
