<?php

namespace App\Livewire;

use App\Contracts\InteractiveTable;
use App\Models\Table;
use Filament\Actions\Action;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

class EditInteractiveTables extends InteractiveTables implements InteractiveTable
{
    public function onTableClick(Table $table): void
    {
        $this->mountAction('clickAction', ['record' => $table]);
    }

    public function onTableDragEnd(Table $table, int $x, int $y): void
    {
        $table->dimensions->x = $x;
        $table->dimensions->y = $y;

        $table->save();
    }

    public function getTableDraggable(Table $table): bool
    {
        return true;
    }

    public function getTableClasses(Table $table): array
    {
        return [
            'p-3 font-bold text-white uppercase transition-transform shadow-2xl rounded-xl ring ring-white/20 hover:scale-105 active:scale-110',
            'bg-gradient-to-tr from-blue-500/60 to-green-400/60' => $table->available,
            'bg-gradient-to-tr from-gray-200/60 to-gray-400' => ! $table->available,
        ];
    }

    public function getTableInnerView(Table $table): string
    {
        return 'table-inner';
    }

    public function clickAction(): mixed
    {
        /** @phpstan-ignore-next-line */
        $arguments = $this->mountedActionsArguments[0];

        return Action::make('click-action')
            ->record($arguments['record'])
            ->fillForm(fn ($record) => $record->toArray())
            ->action(function (Table $record, array $data) {
                $record->update($data);
            })
            ->modalWidth('2xl')
            ->modalHeading(fn (Table $record) => 'Edit table ' . $record->label)
            ->form([
                Section::make()
                    ->columns(6)
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('label')
                            ->required()
                            ->columnSpan(4),
                        TextInput::make('capacity')
                            ->required()
                            ->numeric(),
                        Toggle::make('available')
                            ->label('Available')
                            ->inline(false),
                    ]),
                Section::make()
                    ->columns(4)
                    ->schema([
                        TextInput::make('dimensions.width')
                            ->numeric()
                            ->minValue(20)
                            ->required(),
                        TextInput::make('dimensions.height')
                            ->numeric()
                            ->minValue(20)
                            ->required(),
                        TextInput::make('dimensions.x')
                            ->numeric()
                            ->minValue(20)
                            ->rules('required')
                            ->required(),
                        TextInput::make('dimensions.y')
                            ->numeric()
                            ->minValue(20)
                            ->required(),
                    ]),
            ]);
    }
}
