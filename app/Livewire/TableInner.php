<?php

namespace App\Livewire;

use App\Models\Table;
use Illuminate\View\View;
use Livewire\Component;

class TableInner extends Component
{
    public Table $table;

    public function render(): View
    {
        return view('livewire.table-inner');
    }
}
