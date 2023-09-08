<?php

namespace App\Traits;

use Illuminate\Support\Carbon;

trait HasReservationUtilities
{
    public function isReservedAt(Carbon $date): bool
    {
        return $this->reservations()
            ->where('canceled_at', null)
            ->where('start_at', '<=', $date)
            ->where('end_at', '>=', $date)
            ->exists();
    }

    public function isReservedBetween(Carbon $from, Carbon $to): bool
    {
        return $this->reservations()
            ->where('canceled_at', null)
            ->where(function ($query) use ($from, $to) {
                $query
                    ->whereBetween('start_at', [$from, $to])
                    ->orWhereBetween('end_at', [$from, $to]);
            })
            ->exists();
    }
}
