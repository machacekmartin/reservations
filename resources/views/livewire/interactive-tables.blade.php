<div x-data="{
    draggingId: null,
    start: { x: 0, y: 0 },
    current: { x: 0, y: 0 },
    press(id, x, y) {
        this.draggingId = id;
        {{-- document.documentElement.style.overflow = 'hidden' --}}
        this.current.x = x;
        this.current.y = y;
    },
    drag(id, x, y) {
        if (this.draggingId !== id) return;

        this.start.x = this.current.x - x;
        this.start.y = this.current.y - y;

        this.current.x = x;
        this.current.y = y;

        let top = this.$refs[id].offsetTop - this.start.y;
        let left = this.$refs[id].offsetLeft - this.start.x;

        this.$refs[id].style.top = Math.max(top, 0) + 'px';
        this.$refs[id].style.left = Math.max(left, 0) + 'px';
    },
    unpress() {
        if (this.draggingId === null) return

        let id = this.draggingId.split('-')[1]
        let item = document.getElementById(id)

        const left = parseInt(item.style.left)
        const top = parseInt(item.style.top)

        this.draggingId = null

        this.$wire.savePosition(id, left, top)
    },
}"
    x-on:mouseup.document.prevent="unpress"
    x-on:touchend.document="unpress">
    @foreach ($this->tables as $table)
        <div
            style="
                width: {{ $table->dimensions->width }}px;
                height: {{ $table->dimensions->height }}px;
                left: {{ $table->dimensions->x }}px;
                top: {{ $table->dimensions->y }}px;
            "
            id="{{ $table->id }}"
            class="absolute p-3 font-bold text-white uppercase transition-transform shadow-2xl draggable rounded-xl bg-gradient-to-tr ring ring-white/20 from-slate-500/60 to-green-400/60 hover:scale-105 active:scale-110"
            {{-- wire:click="open({{ $table->id }})" --}}
            {{-- wire:ignore --}}
            @if($this->mode === 'edit')
            x-data="{ id: 'draggable-{{ $table->id }}' }"
            x-ref="draggable-{{ $table->id }}"
            x-on:mousedown.self.prevent="event => press(id, event.clientX, event.clientY)"
            x-on:touchstart.passive="event => press(id, event.touches[0].clientX, event.touches[0].clientY)"
            x-on:mousemove.prevent.document="event => drag(id, event.clientX, event.clientY)"
            x-on:touchmove.document="event => drag(id, event.touches[0].clientX, event.touches[0].clientY)"
            @endif
        >
            <span class="text-2xl">
                {{ $table->label }}
            </span>
        </div>
    @endforeach

    <x-filament-actions::modals />
</div>
