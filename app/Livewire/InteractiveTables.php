<?php

namespace App\Livewire;

use App\Contracts\HasInteractiveTables;
use App\Models\Table;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;

abstract class InteractiveTables extends Component implements HasActions, HasForms, HasInteractiveTables
{
    use InteractsWithActions;
    use InteractsWithForms;

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
