@php
    $permanentlyUnavailable = ! $table->available;

@endphp

<div class="relative">
    <div
        @class([
            'p-2 text-white transition-transform rounded-md ring ring-white/20 flex flex-col transition-all',
            'bg-gradient-to-tr from-gray-200/60 to-gray-400 cursor-default ' => $permanentlyUnavailable,
            'bg-sky-500/60 cursor-pointer hover:bg-sky-500/80 shadow-2xl' => ! $permanentlyUnavailable && ! $selected,
            'bg-gradient-to-tr from-emerald-400/80 to-sky-500/80 bg-sky-500/60 shadow-2xl' => ! $permanentlyUnavailable && $selected
        ])
        style="width: {{ $table->dimensions->width }}px; height: {{ $table->dimensions->height }}px;"
    >
        @if ($permanentlyUnavailable)
        <div class="flex items-center justify-center h-full">
            {{--  --}}
        </div>
        @else
            <div class="flex items-center justify-between">
                <span class="text-sm font-bold uppercase">
                    {{ $table->label }}
                </span>
                <span class="inline-flex items-center text-md gap-x-1">
                    <x-filament::icon class="w-5 h-5 text-white" icon="heroicon-o-user" />
                    {{ $table->capacity }}
                </span>
            </div>
            <ul class="mt-auto">
                <li class="pt-1 text-sm">
                    @if ($selected)
                        <x-filament::icon icon="heroicon-o-check-circle" class="w-6 h-6" />
                    @endif
                </li>
            </ul>
        @endif
    </div>
</div>
