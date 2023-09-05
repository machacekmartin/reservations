<?php

namespace App\Filament\Admin\Resources\UserResource\RelationManagers;

use App\Filament\Admin\Resources\ReservationResource;
use App\Models\Reservation;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ReservationsRelationManager extends RelationManager
{
    protected static string $relationship = 'reservations';

    public function table(Table $table): Table
    {
        return $table
            ->recordUrl(fn (Reservation $record) => ReservationResource::getUrl('edit', ['record' => $record]))
            ->columns([
                TextColumn::make('status')
                    ->badge()
                    ->sortable(),
                TextColumn::make('tables.label')
                    ->getStateUsing(fn (Reservation $record) => $record->tables->pluck('label')->join(', '))
                    ->searchable(),
                TextColumn::make('guest_count')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('start_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('end_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->actions([
                DeleteAction::make(),
            ]);
    }
}
