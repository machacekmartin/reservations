<?php

namespace App\Filament\Admin\Resources\UserResource\RelationManagers;

use App\Filament\Admin\Resources\ReservationResource;
use App\Models\Reservation;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class ReservationsRelationManager extends RelationManager
{
    protected static string $relationship = 'reservations';

    public function table(Table $table): Table
    {
        $table = ReservationResource::table($table);

        $table->getAction('edit')
            ?->action(fn (Reservation $record) => redirect()->to(ReservationResource::getUrl('edit', ['record' => $record])));

        return $table;
    }
}
