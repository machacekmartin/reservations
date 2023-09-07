<?php

namespace App\Contracts;

use App\Models\Table;

interface HasInteractiveTables
{
    public function onTableClick(Table $table): void;

    public function onTableDragEnd(Table $table, int $x, int $y): void;

    public function getTableDraggable(Table $table): bool;

    /**
     * @return array<int|string, bool|string>
     */
    public function getTableClasses(Table $table): array;

    public function getTableInnerView(Table $table): string;

    /**
     * @return array<string, mixed>
     */
    public function getTableInnerViewData(Table $table): array;
}
