<?php

namespace App\Filament\Admin\Resources\ReservationResource\Pages;

use App\Enums\ReservationStatus;
use App\Filament\Admin\Resources\ReservationResource;
use App\Filament\Admin\Resources\ReservationResource\Widgets\ReservationOverview;
use App\Models\Reservation;
use Filament\Actions;
use Filament\Forms\Components\DateTimePicker;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditReservation extends EditRecord
{
    protected static string $resource = ReservationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('fulfill_reservation')
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
                ->action(function (array $data, Reservation $record): void {
                    $record->arrived_at = $data['arrived_at'];
                    $record->status = ReservationStatus::FULFILLED;
                    $record->save();
                    Notification::make()->success()->title('Reservation fulfilled')->send();
                }),

            Actions\Action::make('miss_reservation')
                ->label('Did not arrive')
                ->disabled(fn (Reservation $record) => ! in_array($record->status, [ReservationStatus::PENDING, ReservationStatus::LATE]))
                ->icon(ReservationStatus::MISSED->getIcon())
                ->color(ReservationStatus::MISSED->getColor())
                ->modalWidth('max-w-xl')
                ->modalAlignment('center')
                ->modalFooterActionsAlignment('center')
                ->modalHeading('Guests did not arrive')
                ->modalIcon(ReservationStatus::MISSED->getIcon())
                ->modalDescription('Are you sure the guests did not arrive?')
                ->modalSubmitActionLabel('Confirm')
                ->action(function (Reservation $record): void {
                    $record->status = ReservationStatus::MISSED;
                    $record->save();
                    Notification::make()->success()->title('Reservation marked as missed')->send();
                }),

            Actions\Action::make('cancel_reservation')
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
                ->action(function (Reservation $record): void {
                    $record->canceled_at = now();
                    $record->status = ReservationStatus::CANCELED;
                    $record->save();
                    Notification::make()->success()->title('Reservation canceled')->send();
                }),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            ReservationOverview::class,
        ];
    }
}
