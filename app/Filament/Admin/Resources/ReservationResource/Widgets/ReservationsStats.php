<?php

namespace App\Filament\Admin\Resources\ReservationResource\Widgets;

use App\Enums\ReservationStatus;
use App\Models\Reservation;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Builder;

class ReservationsStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            // where start is only today
            Stat::make('Todays pending / late',
                $this->pending()->where('start_at', '>=', now()->startOfDay())->where('end_at', '<=', now()->endOfDay())->count() . ' / ' .
                $this->late()->where('start_at', '>=', now()->startOfDay())->where('end_at', '<=', now()->endOfDay())->count()
            )
                ->description('Overall ' . $this->pending()->count() . ' pending and ' . $this->late()->count() . ' late')
                ->icon(ReservationStatus::PENDING->getIcon())
                ->color(ReservationStatus::PENDING->getColor()),

            Stat::make('Todays fulfilled ', $this->fulfilled()->where('start_at', '>=', now()->startOfDay())->where('end_at', '<=', now()->endOfDay())->count())
                ->description('Overall fulfilled: ' . $this->fulfilled()->count())
                ->icon(ReservationStatus::FULFILLED->getIcon())
                ->color(ReservationStatus::FULFILLED->getColor()),

            Stat::make('Todays canceled ', $this->canceled()->where('start_at', '>=', now()->startOfDay())->where('end_at', '<=', now()->endOfDay())->count())
                ->description('Overall canceled: ' . $this->canceled()->count())
                ->icon(ReservationStatus::CANCELED->getIcon())
                ->color(ReservationStatus::CANCELED->getColor()),

            Stat::make('Todays missed ', $this->missed()->where('start_at', '>=', now()->startOfDay())->where('end_at', '<=', now()->endOfDay())->count())
                ->description('Overall missed: ' . $this->missed()->count())
                ->icon(ReservationStatus::LATE->getIcon())
                ->color(ReservationStatus::LATE->getColor()),
        ];
    }

    protected function getColumns(): int
    {
        return 4;
    }

    private function pending(): Builder
    {
        return Reservation::query()->where('status', ReservationStatus::PENDING);
    }

    private function late(): Builder
    {
        return Reservation::query()->where('status', ReservationStatus::LATE);
    }

    private function fulfilled(): Builder
    {
        return Reservation::query()->where('status', ReservationStatus::FULFILLED);
    }

    private function canceled(): Builder
    {
        return Reservation::query()->where('status', ReservationStatus::CANCELED);
    }

    private function missed(): Builder
    {
        return Reservation::query()->where('status', ReservationStatus::MISSED);
    }
}
