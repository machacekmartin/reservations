<div
    wire:poll
    @class([
        'p-3 text-white transition-transform shadow-2xl rounded-xl ring ring-white/20 active:scale-105 flex flex-col cursor-pointer',
        'bg-gradient-to-tr from-blue-500/60 to-green-400/60' => $table->available,
        'bg-gradient-to-tr from-gray-200/60 to-gray-400' => ! $table->available,
    ])
    style="width: {{ $table->dimensions->width }}px; height: {{ $table->dimensions->height }}px;"
>
    <div class="flex items-center justify-between">
        <span class="text-xl font-bold uppercase">
            {{ $table->label }}
        </span>
        <span class="text-xs">
            {{ $table->capacity }}
        </span>
    </div>
    <ul class="mt-auto text-xs">
        <li class="pt-1 text-xs">
            {{ $table->dimensions->x }} x {{ $table->dimensions->y }}
        </li>
        <li class="pt-1 text-xs">
            {{ $table->dimensions->width }} x {{ $table->dimensions->height }}
        </li>
    </ul>
</div>
