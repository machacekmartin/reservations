<?php

namespace App\Builders;

use App\Enums\ReservationStatus;
use Illuminate\Database\Eloquent\Builder;

class ReservationBuilder extends Builder
{
    public function pending()
    {
        return $this->where('status', ReservationStatus::PENDING);
    }

    public function late()
    {
        return $this->where('status', ReservationStatus::LATE);
    }

    public function canceled()
    {
        return $this->where('status', ReservationStatus::CANCELED);
    }

    public function fulfilled()
    {
        return $this->where('status', ReservationStatus::FULFILLED);
    }

    public function missed()
    {
        return $this->where('status', ReservationStatus::MISSED);
    }
}
