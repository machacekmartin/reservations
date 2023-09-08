<x-filament-panels::page>
    {{ $this->table }}

    <x-interactive-canvas>
        @if (\App\Models\Table::query()->count() !== 0)
            <livewire:interactive.edit-tables />
        @endif
    </x-interactive-canvas>
</x-filament-panels::page>
