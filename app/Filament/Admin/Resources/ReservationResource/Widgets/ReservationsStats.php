<?php

namespace App\Filament\Admin\Resources\ReservationResource\Widgets;

use App\Models\Reservation;
use Filament\Support\Colors\Color;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Builder;

class ReservationsStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            // where start is only today
            Stat::make('Todays pending reservations', $this->pendingReservations()->where('start_at', '>=', now()->startOfDay())->where('end_at', '<=', now()->endOfDay())->count())
                ->description('Overall pending: '. $this->pendingReservations()->count())
                ->icon('heroicon-o-clock')
                ->color(Color::Gray),

            Stat::make('Todays fulfilled reservations', $this->fulfilledReservations()->where('start_at', '>=', now()->startOfDay())->where('end_at', '<=', now()->endOfDay())->count())
                ->description('Overall fulfilled: '. $this->fulfilledReservations()->count())
                ->icon('heroicon-o-check-circle')
                ->color(Color::Green),

            Stat::make('Todays cancelled reservations', $this->cancelledReservations()->where('start_at', '>=', now()->startOfDay())->where('end_at', '<=', now()->endOfDay())->count())
                ->description('Overall cancelled: '. $this->cancelledReservations()->count())
                ->icon('heroicon-o-x-circle')
                ->color(Color::Rose),
        ];
    }

    private function pendingReservations(): Builder
    {
        return Reservation::query()
            ->whereNull('canceled_at')
            ->whereNull('fulfilled');
    }

    private function fulfilledReservations(): Builder
    {
        return Reservation::query()
            ->where('fulfilled', true);
    }

    private function cancelledReservations(): Builder
    {
        return Reservation::query()
            ->whereNotNull('canceled_at');
    }
}
