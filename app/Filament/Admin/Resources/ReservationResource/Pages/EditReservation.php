<?php

namespace App\Filament\Admin\Resources\ReservationResource\Pages;

use App\Filament\Admin\Resources\ReservationResource;
use App\Filament\Admin\Resources\ReservationResource\Actions\CancelAction;
use App\Filament\Admin\Resources\ReservationResource\Actions\FulfillAction;
use App\Filament\Admin\Resources\ReservationResource\Actions\MissAction;
use App\Filament\Admin\Resources\ReservationResource\Widgets\ReservationOverview;
use Filament\Resources\Pages\EditRecord;

class EditReservation extends EditRecord
{
    protected static string $resource = ReservationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            FulfillAction::make('fulfill_reservation'),
            MissAction::make('miss_reservation'),
            CancelAction::make('cancel_reservation'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            ReservationOverview::class,
        ];
    }
}
