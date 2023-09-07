<?php

namespace App\Livewire;

use App\Models\Table;
use Carbon\CarbonInterval;
use Collator;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Support\Carbon;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class CreateReservation extends Component implements HasForms
{
    use InteractsWithForms;

    public string $date;
    public string $count;

    /**
     * @var array<int>
     */
    public array $selectedTables = [];

    public function render(): View
    {
        return view('livewire.create-reservation');
    }

    /**
     * @param array<int> $tables
     */
    #[On('tables-selected')]
    public function updateSelectedTables(array $tables): void
    {
        $this->selectedTables = $tables;
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->columns(1)
                    ->schema([
                        DatePicker::make('date')
                            ->label('What day?')
                            ->required()
                            ->prefixIcon('heroicon-o-calendar'),

                        TextInput::make('count')
                            ->label('How many people')
                            ->numeric()
                            ->minValue(1)
                            ->required()
                            ->prefixIcon('heroicon-o-user')
                    ])
            ]);
    }

    /**
     * @return array<string, mixed>
     */
    #[Computed]
    public function times(): array
    {
        $intervals = CarbonInterval::minutes(20)->toPeriod('10:00', '20:00')->toArray();

        return collect($intervals)
            ->map(function ($interval) {
                $start = $interval->toDate();

                $reserved = collect($this->selectedTables)
                    ->contains(fn ($tableId) =>
                        Table::query()->findOrFail($tableId)->isReservedAt(Carbon::instance($start))
                    );

                return [
                    'time' => $start,
                    'reserved' => $reserved,
                ];
            })->toArray();
    }
}
