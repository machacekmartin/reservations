<?php

namespace App\Livewire;

use App\Models\Table;

class SelectInteractiveTables extends InteractiveTables
{
    /**
     * @var array<int>
     */
    public array $selectedTables = [];

    public function onTableClick(Table $table): void
    {
        if (! $table->available) {
            return;
        }

        $key = array_search($table->id, $this->selectedTables);
        $key !== false ? array_splice($this->selectedTables, (int) $key, 1) : $this->selectedTables[] = $table->id;

        $this->dispatch('tables-selected', $this->selectedTables);
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
        return 'table-inner-select';
    }

    public function getTableInnerViewData(Table $table): array
    {
        return [
            'table' => $table,
            'selected' => in_array($table->id, $this->selectedTables),
        ];
    }
}
