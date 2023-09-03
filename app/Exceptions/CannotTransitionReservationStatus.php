<?php

namespace App\Exceptions;

use App\Models\Reservation;
use Exception;

class CannotTransitionReservationStatus extends Exception
{
    public Reservation $reservation;

    public static function for(Reservation $reservation, string $message): self
    {
        $instance = new self($message);

        $instance->reservation = $reservation;

        return $instance;
    }

    /**
     * @return array<string, mixed>
     */
    public function context(): array
    {
        return $this->reservation->toArray();
    }
}
