<?php

namespace App\Builders;

use App\Enums\ReservationStatus;
use Illuminate\Database\Eloquent\Builder;

class ReservationBuilder extends Builder
{
    public function today(): self
    {
        return $this
            ->where('start_at', '>=', now()->startOfDay())
            ->where('end_at', '<=', now()->endOfDay());
    }

    public function pending(): self
    {
        return $this->where('status', ReservationStatus::PENDING);
    }

    public function late(): self
    {
        return $this->where('status', ReservationStatus::LATE);
    }

    public function canceled(): self
    {
        return $this->where('status', ReservationStatus::CANCELED);
    }

    public function fulfilled(): self
    {
        return $this->where('status', ReservationStatus::FULFILLED);
    }

    public function missed(): self
    {
        return $this->where('status', ReservationStatus::MISSED);
    }
}
