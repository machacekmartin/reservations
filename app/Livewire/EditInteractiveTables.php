<?php

namespace App\Livewire;

use App\Contracts\InteractiveTableEvents;
use App\Models\Table;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;

class EditInteractiveTables extends InteractiveTables implements InteractiveTableEvents
{
    public function getAllowDrag(Table $table): bool
    {
        return true;
    }

    public function getTableClasses(Table $table): array
    {
        return [
            'absolute p-3 font-bold text-white uppercase transition-transform shadow-2xl  rounded-xl ring ring-white/20 ' => true,
            'bg-gradient-to-tr from-slate-500/60 to-green-400/60 hover:scale-105 active:scale-110' => true,
        ];
    }

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

    public function clickAction(): mixed
    {
        /** @phpstan-ignore-next-line */
        $arguments = $this->mountedActionsArguments[0];

        return Action::make('click-action')
            ->record($arguments['record'])
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
}
