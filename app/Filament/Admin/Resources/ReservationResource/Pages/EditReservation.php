<?php

namespace App\Filament\Admin\Resources\ReservationResource\Pages;

use App\Enums\ReservationStatus;
use App\Filament\Admin\Resources\ReservationResource;
use App\Filament\Admin\Resources\ReservationResource\Widgets\ReservationOverview;
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
            Actions\Action::make('fulfill')
                ->disabled(fn (Reservation $record) => ! in_array($record->status, [ReservationStatus::PENDING, ReservationStatus::LATE]))
                ->icon(ReservationStatus::FULFILLED->getIcon())
                ->color(ReservationStatus::FULFILLED->getColor())
                ->modalWidth('max-w-xl')
                ->modalHeading('Guests have arrived')
                ->modalAlignment('center')
                ->modalIcon(ReservationStatus::FULFILLED->getIcon())
                ->modalDescription('To mark this reservation as fulfilled, please enter the time the guests have arrived.')
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

            Actions\Action::make('cancel')
                ->action(null)
                ->disabled(fn () => ! in_array($this->record->status, [ReservationStatus::PENDING, ReservationStatus::LATE]))
                ->icon(ReservationStatus::CANCELED->getIcon())
                ->color(ReservationStatus::CANCELED->getColor())
                ->modalWidth('max-w-xl')
                ->modalHeading('Cancel this reservation')
                ->modalAlignment('center')
                ->modalIcon(ReservationStatus::FULFILLED->getIcon())
                ->modalDescription('To mark this reservation as fulfilled, please enter the time of cancelation.')
                ->form([
                    DateTimePicker::make('canceled_at')
                        ->required()
                        ->seconds(false)
                        ->default(now()),
                ]),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            ReservationOverview::class,
        ];
    }
}
