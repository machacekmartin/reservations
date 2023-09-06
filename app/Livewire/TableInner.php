<?php

namespace App\Livewire;

use App\Models\Table;
use Livewire\Component;

class TableInner extends Component
{
    public Table $table;

    public function render()
    {
        return view('livewire.table-inner');
    }
}
