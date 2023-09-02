<?php

namespace App\Jobs;

use App\Mail\RemindReservation;
use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendReservationReminders implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
        //
    }

    public function handle(): void
    {
        // Find reservations that have a reminder time set in place
        Reservation::query()
            ->pending()
            ->where('reminded', false)
            ->whereNotNull('remind_at')
            ->where('remind_at', '<=', now()->ceilMinute())
            ->orderBy('remind_at')
            ->each(function (Reservation $reservation) {
                Mail::to($reservation->user)->send(new RemindReservation($reservation));

                $reservation->reminded = true;
                $reservation->save();
            });
    }
}
