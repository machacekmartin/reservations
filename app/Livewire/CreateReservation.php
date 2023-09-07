<?php

namespace App\Livewire;

use App\Models\Table;
use Carbon\CarbonInterval;
use Closure;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;
use Livewire\Component;

/**
 * @property-read Form $form
 */
class CreateReservation extends Component implements HasForms
{
    use InteractsWithForms;

    /**
     * @var array<int>
     */
    public array $selectedTables = [];

    /**
     * @var array<string, mixed>
     */
    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    /**
     * @param  array<int>  $tables
     */
    #[On('tables-selected')]
    public function updateSelectedTables(array $tables): void
    {
        $this->selectedTables = $tables;

        $this->data['start_at'] = null;
        $this->data['end_at'] = null;
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->columns(3)
                    ->schema([
                        DatePicker::make('date')
                            ->label('Day of reservation')
                            ->required()
                            ->reactive()
                            ->minDate(now()->startOfDay())
                            ->afterStateUpdated(fn (Set $set) => $set('start_at', null))
                            ->prefixIcon('heroicon-o-calendar')
                            ->dehydrated(false),

                        Select::make('start_at')
                            ->label('Start of reservation')
                            ->required()
                            ->options(fn () => $this->timeOptions())
                            ->disableOptionWhen(fn (string $value) => $this->isStartOptionDisabled($value))
                            ->disabled(fn (Get $get) => $get('date') == null || empty($this->selectedTables))
                            ->afterStateUpdated(fn (Set $set) => $set('end_at', null))
                            ->reactive()
                            ->prefixIcon('heroicon-o-clock')
                            ->rules([fn () => $this->getStartAtRule()]),

                        Select::make('end_at')
                            ->label('End of reservation')
                            ->required()
                            ->options(fn () => $this->timeOptions())
                            ->disableOptionWhen(fn (string $value, Get $get) => $this->isEndOptionDisabled($get('start_at'), $value))
                            ->disabled(fn (Get $get) => $get('start_at') == null)
                            ->reactive()
                            ->prefixIcon('heroicon-o-clock')
                            ->rules([fn (Get $get) => $this->getEndAtRule($get)])
                    ]),
                    Section::make()
                        ->columns(2)
                        ->schema([
                            Select::make('remind_at')
                                ->label('Remind me at')
                                ->default(0)
                                ->options([
                                    0 => "Don't remind me",
                                    15 => '15 minutes before reservation',
                                    30 => '30 minutes before reservation',
                                    60 => '1 hour before reservation',
                                    120 => '2 hours before reservation',
                                ])
                                ->in([0, 15, 30, 60, 120])
                                ->dehydrateStateUsing(fn (int $state, Get $get) =>
                                    Carbon::parse($get('start_at'))->addMinutes($state)->toDateTimeString()
                                ),

                            TextInput::make('guest_count')
                                ->label('Hwo many people will be coming')
                                ->required()
                                ->numeric()
                                ->minValue(1)
                                ->default(1)
                                ->maxValue(20)
                                ->prefixIcon('heroicon-o-user'),

                            Textarea::make('note')
                                ->label('Note')
                                ->placeholder('Anything else we should know?')
                                ->rows(3)
                                ->columnSpanFull()
                                ->maxLength(50)
                    ]),
                    Actions::make([
                        Action::make('save')
                            ->label('Create reservation')
                            ->size('xl')
                            ->icon('heroicon-o-check')
                            ->action(fn () => $this->submit())
                    ])
            ])->statePath('data');
    }

    private function submit(): void
    {
        $tables = $this->selectedTables;

        /** @var \App\Models\User $user */
        $user = auth()->user();

        $reservation = $user->reservations()->create(
            $this->form->getState(),
        );

        $reservation->tables()->attach($tables);

        Notification::make()->success()->title('Reservation for '. $reservation->start_at->format('H:i') . ' created')->send();
        redirect()->route('reservations');
    }

    private function isStartOptionDisabled(string $start): bool
    {
        return collect($this->selectedTables)
            ->contains(function ($tableId) use ($start) {
                return Table::query()->findOrFail($tableId)->isReservedAt(Carbon::parse($start));
            });
    }

    private function isEndOptionDisabled(?string $start, string $end): bool
    {
        if ($start >= $end) return true;

        return collect($this->selectedTables)
            ->contains(function ($tableId) use ($start, $end) {
                return Table::query()->findOrFail($tableId)->isReservedBetween(Carbon::parse($start), Carbon::parse($end));
            });
    }

    private function timeOptions(): Collection
    {
        $intervals = CarbonInterval::minutes(20)->toPeriod(
            $this->data['date'] . ' 10:00',  /** @phpstan-ignore-line */
            $this->data['date'] . ' 20:00'   /** @phpstan-ignore-line */
        )->toArray();

        return collect($intervals)->mapWithKeys(fn ($item) =>
            [$item->toDateTimeString() => $item->format('H:i')]
        );
    }

    private function getEndAtRule(Get $get): Closure
    {
        return function ($attribute, $value, Closure $fail) use ($get) {
            if ($this->isEndOptionDisabled($get('start_at'), $value)) $fail('The :attribute is invalid.');
        };
    }

    private function getStartAtRule(): Closure
    {
        return function ($attribute, $value, Closure $fail) {
            if ($this->isStartOptionDisabled($value)) $fail('The :attribute is invalid.');
        };
    }
}
