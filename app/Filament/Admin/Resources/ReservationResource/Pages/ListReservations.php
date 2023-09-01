<?php

namespace App\Filament\Admin\Resources\ReservationResource\Pages;

use App\Filament\Admin\Resources\ReservationResource;
use App\Filament\Admin\Resources\ReservationResource\Widgets\ReservationsStats;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReservations extends ListRecords
{
    protected static string $resource = ReservationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            ReservationsStats::class,
        ];
    }
}
