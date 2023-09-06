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

class InteractiveTables extends Component implements HasForms, HasActions
{
    use InteractsWithActions;
    use InteractsWithForms;

    private string $mode = 'edit';

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

    #[Computed()]
    public function mode(): string
    {
        return $this->mode;
    }

    private function clickAction(): mixed
    {
        return Action::make('hehe')
            ->record($this->mountedActionsArguments[0]['record'])
            ->fillForm(fn ($record) => $record->toArray())
            ->action(function (Table $record, array $data) {
                $record->dimensions->width = $data['dimensions']['width'];
                $record->dimensions->height = $data['dimensions']['height'];

                $record->save();
            })
            ->form([
                TextInput::make('label')
                    ->required(),
                TextInput::make('dimensions.width')
                    ->numeric()
                    ->required(),
                TextInput::make('dimensions.height')
                    ->numeric()
                    ->required(),
            ]);
    }

    public function open($id)
    {
        $this->mountAction('clickAction', ['record' => Table::find($id)]);
    }

    public function savePosition(Table $table, int $x, int $y): void
    {
        $table->dimensions->x = $x;
        $table->dimensions->y = $y;

        $table->save();
    }
}
