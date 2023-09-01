<?php

namespace App\Filament\Admin\Resources\ReservationResource\Widgets;

use App\Models\Reservation;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ReservationOverview extends BaseWidget
{
    public Reservation $record;

    protected function getStats(): array
    {
        return [
            Stat::make('Reservation length', $this->record->start_at->diffInMinutes($this->record->end_at) . ' minutes')
                ->description('Starts at ' . $this->record->start_at->format('H:i') . ' and ends at ' . $this->record->end_at->format('H:i')),

            Stat::make('Owner of reservation', $this->record->user->name)
                ->description($this->record->user->email . ' | ' . $this->record->user->phone),

            Stat::make('Status', $this->record->status->getLabel())
                ->icon($this->record->status->getIcon())
                ->color($this->record->status->getColor()),
        ];
    }

    protected function getColumns(): int
    {
        return 3;
    }
}
