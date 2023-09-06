<?php

namespace App\Contracts;

use App\Models\Table;

interface InteractiveTableEvents
{
    public function onTableClick(Table $table): void;

    public function onTableDragEnd(Table $table, int $x, int $y): void;
}
