<?php

namespace App\Filament\Admin\Resources\ReservationResource\Actions;

use App\Actions\CancelReservationAction;
use App\Enums\ReservationStatus;
use App\Models\Reservation;
use Filament\Actions\Action;
use Filament\Notifications\Notification;

class CancelAction extends Action
{
    public static function make(string $name = null): static
    {
        return parent::make($name)
            ->label('Cancel')
            ->disabled(fn (Reservation $record) => ! in_array($record->status, [ReservationStatus::PENDING, ReservationStatus::LATE]))
            ->icon(ReservationStatus::CANCELED->getIcon())
            ->color(ReservationStatus::CANCELED->getColor())
            ->modalWidth('max-w-xl')
            ->modalAlignment('center')
            ->modalFooterActionsAlignment('center')
            ->modalHeading('Cancel this reservation')
            ->modalIcon(ReservationStatus::CANCELED->getIcon())
            ->modalDescription('Are you sure you want to cancel this reservation?')
            ->modalSubmitActionLabel('Yes, cancel reservation')
            ->modalCancelActionLabel('No')
            ->action(function (Reservation $record, CancelReservationAction $cancelReservationAction) {
                $cancelReservationAction->run($record);
                Notification::make()->success()->title('Reservation canceled')->send();
            });
    }
}
