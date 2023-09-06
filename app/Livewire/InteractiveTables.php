<?php

namespace App\Livewire;

use App\Models\Table;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;

class InteractiveTables extends Component implements HasActions, HasForms
{
    use InteractsWithActions;
    use InteractsWithForms;

    private bool $allowDrag = false;

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

    public function getAllowDrag(Table $table): bool
    {
        return $this->allowDrag;
    }

    /**
     * @return array<string, bool>
     */
    public function getTableClasses(Table $table): array
    {
        return [
            'absolute p-3 font-bold text-white uppercase transition-transform shadow-2xl draggable rounded-xl ring ring-white/20 ' => true,
        ];
    }
}
