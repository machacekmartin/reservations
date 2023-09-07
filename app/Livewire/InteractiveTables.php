<?php

namespace App\Livewire;

use App\Contracts\HasInteractiveTables;
use App\Models\Table;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;

abstract class InteractiveTables extends Component implements HasInteractiveTables
{
    public function render(): View
    {
        return view('livewire.interactive-tables');
    }

    /**
     * @return Collection<Table>
     */
    #[Computed()]
    public function tables(): Collection
    {
        return Table::all();
    }
}
