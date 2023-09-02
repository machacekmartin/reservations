<?php

namespace App\Filament\Admin\Resources\ReservationResource\Pages;

use App\Filament\Admin\Resources\ReservationResource;
use App\Filament\Admin\Resources\ReservationResource\Actions\CancelReservationAction;
use App\Filament\Admin\Resources\ReservationResource\Actions\FulfillReservationAction;
use App\Filament\Admin\Resources\ReservationResource\Actions\MissReservationAction;
use App\Filament\Admin\Resources\ReservationResource\Widgets\ReservationOverview;
use Filament\Resources\Pages\EditRecord;

class EditReservation extends EditRecord
{
    protected static string $resource = ReservationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            FulfillReservationAction::make('fulfill_reservation'),
            MissReservationAction::make('miss_reservation'),
            CancelReservationAction::make('cancel_reservation'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            ReservationOverview::class,
        ];
    }
}
