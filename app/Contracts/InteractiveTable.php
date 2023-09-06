<?php

namespace App\Contracts;

use App\Models\Table;

interface InteractiveTable
{
    public function onTableClick(Table $table): void;

    public function onTableDragEnd(Table $table, int $x, int $y): void;

    public function getTableDraggable(Table $table): bool;

    /**
     * @return array<int|string, bool|string>
     */
    public function getTableClasses(Table $table): array;
}
