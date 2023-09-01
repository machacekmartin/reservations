<?php

namespace App\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum ReservationStatus: string implements HasColor, HasIcon, HasLabel
{
    case PENDING = 'Pending';
    case CANCELED = 'Canceled';
    case FULFILLED = 'Fulfilled';
    case LATE = 'Late';
    case MISSED = 'Missed';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::CANCELED => 'Canceled',
            self::FULFILLED => 'Fulfilled',
            self::LATE => 'Late',
            self::MISSED => 'Missed',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::PENDING => Color::Blue,
            self::CANCELED => Color::Rose,
            self::FULFILLED => Color::Green,
            self::LATE => Color::Yellow,
            self::MISSED => Color::Pink,
        };
    }

    public function getIcon(): string | null
    {
        return match ($this) {
            self::PENDING => 'heroicon-o-clock',
            self::CANCELED => 'heroicon-o-x-circle',
            self::FULFILLED => 'heroicon-o-check-circle',
            self::LATE => 'heroicon-o-clock',
            self::MISSED => 'heroicon-o-face-frown',
        };
    }
}
