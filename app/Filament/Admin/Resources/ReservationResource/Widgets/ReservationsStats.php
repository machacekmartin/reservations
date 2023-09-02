<?php

namespace App\Filament\Admin\Resources\ReservationResource\Widgets;

use App\Enums\ReservationStatus;
use App\Models\Reservation;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ReservationsStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            // where start is only today
            Stat::make('Todays pending / late',
                Reservation::query()->pending()->today()->count() . ' / ' .
                Reservation::query()->late()->today()->count()
            )
                ->description('Overall ' . Reservation::query()->pending()->count() . ' pending and ' . Reservation::query()->late()->count() . ' late')
                ->icon(ReservationStatus::PENDING->getIcon())
                ->color(ReservationStatus::PENDING->getColor()),

            Stat::make('Todays fulfilled ', Reservation::query()->fulfilled()->today()->count())
                ->description('Overall fulfilled: ' . Reservation::query()->fulfilled()->count())
                ->icon(ReservationStatus::FULFILLED->getIcon())
                ->color(ReservationStatus::FULFILLED->getColor()),

            Stat::make('Todays canceled ', Reservation::query()->canceled()->today()->count())
                ->description('Overall canceled: ' . Reservation::query()->canceled()->count())
                ->icon(ReservationStatus::CANCELED->getIcon())
                ->color(ReservationStatus::CANCELED->getColor()),

            Stat::make('Todays missed ', Reservation::query()->missed()->today()->count())
                ->description('Overall missed: ' . Reservation::query()->missed()->count())
                ->icon(ReservationStatus::LATE->getIcon())
                ->color(ReservationStatus::LATE->getColor()),
        ];
    }

    protected function getColumns(): int
    {
        return 4;
    }
}
