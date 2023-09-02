<?php

namespace App\Console;

use App\Jobs\MarkLateReservations;
use App\Jobs\SendReservationReminders;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->job(new MarkLateReservations)
            ->everyMinute()
            ->withoutOverlapping();

        $schedule->job(new SendReservationReminders)
            ->everyMinute()
            ->withoutOverlapping();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        //
    }
}
