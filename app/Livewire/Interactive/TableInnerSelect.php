<?php

namespace App\Livewire\Interactive;

use App\Models\Table;
use Illuminate\View\View;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class TableInnerSelect extends Component
{
    public Table $table;

    #[Reactive]
    public bool $selected;

    public function render(): View
    {
        return view('livewire.interactive.table-inner-select');
    }
}
