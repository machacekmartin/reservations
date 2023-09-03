<?php

namespace App\Exceptions;

use App\Models\Reservation;
use Exception;

class CannotTransitionReservationStatus extends Exception
{
    public Reservation $reservation;

    public static function for(Reservation $reservation, string $message): static
    {
        $instance = new self($message);

        $instance->reservation = $reservation;

        return $instance;
    }

    public function context(): array
    {
        return $this->reservation->toArray();
    }
}
