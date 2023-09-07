@php
    $permanentlyUnavailable = ! $table->available;

@endphp

<div class="relative">
    <div
        @class([
            'p-2 text-white transition-transform shadow-2xl rounded-md ring ring-white/20 flex flex-col',
            'bg-gradient-to-tr from-gray-200/60 to-gray-400 cursor-default' => $permanentlyUnavailable,
            'bg-gradient-to-tr from-sky-400/60 to-sky-500/60 cursor-pointer hover:bg-green-400/20' => ! $permanentlyUnavailable && ! $selected,
            'bg-gradient-to-tr from-green-400/60 to-green-500/60' => ! $permanentlyUnavailable && $selected
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
                <span class="inline-flex items-center text-sm gap-x-1">
                    <x-filament::icon class="w-4 h-4 text-white" icon="heroicon-o-user" />
                    {{ $table->capacity }}
                </span>
            </div>
            <ul class="mt-auto">
                <li class="pt-1 text-sm">
                    @if ($selected)
                        <x-filament::icon icon="heroicon-o-check-circle" class="w-4 h-4" />
                    @endif
                </li>
            </ul>
        @endif
    </div>
</div>
