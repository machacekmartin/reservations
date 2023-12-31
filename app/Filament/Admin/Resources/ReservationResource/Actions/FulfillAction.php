<?php

namespace App\Filament\Admin\Resources\ReservationResource\Actions;

use App\Actions\FulfillReservationAction;
use App\Enums\ReservationStatus;
use App\Models\Reservation;
use Filament\Actions\Action;
use Filament\Forms\Components\DateTimePicker;
use Filament\Notifications\Notification;
use Illuminate\Support\Carbon;

class FulfillAction extends Action
{
    public static function make(string $name = null): static
    {
        return parent::make($name)
            ->label('Arrived')
            ->disabled(fn (Reservation $record) => ! in_array($record->status, [ReservationStatus::PENDING, ReservationStatus::LATE]))
            ->icon(ReservationStatus::FULFILLED->getIcon())
            ->color(ReservationStatus::FULFILLED->getColor())
            ->modalWidth('max-w-xl')
            ->modalAlignment('center')
            ->modalFooterActionsAlignment('center')
            ->modalHeading('Guests have arrived')
            ->modalIcon(ReservationStatus::FULFILLED->getIcon())
            ->modalDescription('To mark this reservation as fulfilled, please enter the time the guests have arrived.')
            ->modalSubmitActionLabel('Confirm')
            ->form([
                DateTimePicker::make('arrived_at')
                    ->required()
                    ->seconds(false)
                    ->default(now()),
            ])
            ->action(function (array $data, Reservation $record, FulfillReservationAction $fulfillReservationAction): void {
                $fulfillReservationAction->run($record, Carbon::createFromTimeString($data['arrived_at']));
                Notification::make()->success()->title('Reservation fulfilled')->send();
            });
    }
}
