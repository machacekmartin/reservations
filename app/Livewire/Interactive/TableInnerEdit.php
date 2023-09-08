<?php

namespace App\Livewire\Interactive;

use App\Models\Table;
use Illuminate\View\View;
use Livewire\Component;

class TableInnerEdit extends Component
{
    public Table $table;

    public function render(): View
    {
        return view('livewire.interactive.table-inner-edit');
    }
}
