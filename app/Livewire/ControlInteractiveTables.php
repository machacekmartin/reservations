<?php

namespace App\Livewire;

use App\Filament\Admin\Resources\ReservationResource\Actions\CancelAction;
use App\Filament\Admin\Resources\ReservationResource\Actions\FulfillAction;
use App\Filament\Admin\Resources\ReservationResource\Actions\MissAction;
use App\Models\Reservation;
use App\Models\Table;
use Filament\Actions\Action;

class ControlInteractiveTables extends InteractiveTables
{
    public function onTableClick(Table $table): void
    {
        if (! $table->currentReservation) return;

        $this->mountAction('clickAction', ['record' => $table->currentReservation]);
    }

    public function onTableDragEnd(Table $table, int $x, int $y): void
    {
        //
    }

    public function getTableDraggable(Table $table): bool
    {
        return false;
    }

    public function getTableClasses(Table $table): array
    {
        return [];
    }

    public function getTableInnerView(Table $table): string
    {
        return 'table-inner-control';
    }

    public function getTableInnerViewData(Table $table): array
    {
        return [
            'table' => $table,
        ];
    }

    public function clickAction(): Action
    {
        /** @phpstan-ignore-next-line */
        $arguments = $this->mountedActionsArguments[0];

        return Action::make('click-action')
            ->record($arguments['record'])
            ->requiresConfirmation()
            ->modalFooterActions(fn (Reservation $record) => [
                FulfillAction::make('fulfill')->record($record)->label('Guest arrived'),
                MissAction::make('miss')->record($record),
                CancelAction::make('cancel')->record($record)->label('Cancel reservation'),
            ])
            ->modalIcon('heroicon-o-pencil-square')
            ->modalDescription('What would you like to do with this reservation?')
            ->modalHeading(fn (Reservation $record) => $record->user->name ."'s reservation for ". $record->start_at->format('d. m. Y H:i'))
            ->modalWidth('2xl');
    }
}
