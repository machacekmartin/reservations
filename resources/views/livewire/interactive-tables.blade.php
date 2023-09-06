<div x-data="{
    draggingId: null,
    dragged: false,
    start: { x: 0, y: 0 },
    current: { x: 0, y: 0 },
    press(id, x, y) {
        this.dragged = false;

        this.draggingId = id;
        this.current.x = x;
        this.current.y = y;

        this.$refs[id].offsetTop - this.start.y;
    },
    drag(id, x, y) {
        if (this.draggingId !== id) return;
        this.dragged = true;

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

        this.$wire.onTableDragEnd(id, left, top)
    },
    click(id) {
        if (this.dragged) return;
        $wire.onTableClick(id)
    }
}"
    x-on:mouseup.document.prevent="unpress"
    x-on:touchend.document="unpress">
    @foreach ($this->tables as $table)
        <div
            id="{{ $table->id }}"
            style="width: {{ $table->dimensions->width }}px; height: {{ $table->dimensions->height }}px; left: {{ $table->dimensions->x }}px; top: {{ $table->dimensions->y }}px"
            wire:ignore
            x-on:click.prevent="click({{ $table->id }})"
            @class($this->getTableClasses($table))
            @if($this->getAllowDrag($table))
            x-data="{ id: 'draggable-{{ $table->id }}' }"
            x-ref="draggable-{{ $table->id }}"
            x-on:mousedown.self.prevent="vent => press(id, event.clientX, event.clientY)"
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
