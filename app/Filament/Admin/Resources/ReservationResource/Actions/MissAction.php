<?php

namespace App\Filament\Admin\Resources\ReservationResource\Actions;

use App\Actions\MissReservationAction;
use App\Enums\ReservationStatus;
use App\Models\Reservation;
use Filament\Actions\Action;
use Filament\Notifications\Notification;

class MissAction extends Action
{
    public static function make(string $name = null): static
    {
        return parent::make($name)
            ->label('Did not arrive')
            ->disabled(fn (Reservation $record) => $record->status !== ReservationStatus::LATE)
            ->icon(ReservationStatus::MISSED->getIcon())
            ->color(ReservationStatus::MISSED->getColor())
            ->modalWidth('max-w-xl')
            ->modalAlignment('center')
            ->modalFooterActionsAlignment('center')
            ->modalHeading('Guests did not arrive')
            ->modalIcon(ReservationStatus::MISSED->getIcon())
            ->modalDescription('Are you sure the guests did not arrive?')
            ->modalSubmitActionLabel('Confirm')
            ->action(function (Reservation $record, MissReservationAction $missReservationAction): void {
                $missReservationAction->run($record);
                Notification::make()->success()->title('Reservation marked as missed')->send();
            });
    }
}
