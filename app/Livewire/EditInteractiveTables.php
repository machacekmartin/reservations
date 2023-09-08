<?php

namespace App\Livewire;

use App\Filament\Admin\Resources\TableResource;
use App\Models\Table;
use Filament\Actions\Action;

class EditInteractiveTables extends InteractiveTables
{
    public function onTableClick(Table $table): void
    {
        $this->mountAction('clickAction', ['record' => $table]);
    }

    public function onTableDragEnd(Table $table, int $x, int $y): void
    {
        $table->dimensions->x = $x;
        $table->dimensions->y = $y;

        $table->save();
    }

    public function getTableDraggable(Table $table): bool
    {
        return true;
    }

    public function getTableClasses(Table $table): array
    {
        return [];
    }

    public function getTableInnerView(Table $table): string
    {
        return 'table-inner';
    }

    public function getTableInnerViewData(Table $table): array
    {
        return [
            'table' => $table,
        ];
    }

    public function clickAction(): mixed
    {
        /** @phpstan-ignore-next-line */
        $arguments = $this->mountedActionsArguments[0];

        return Action::make('click-action')
            ->record($arguments['record'])
            ->fillForm(fn ($record) => $record->toArray())
            ->action(function (Table $record, array $data) {
                $record->update($data);
            })
            ->form(fn ($form) => TableResource::form($form));
    }
}
