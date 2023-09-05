<div x-data="{
    dragging: null,
    start: { x: 0, y: 0 },
    current: { x: 0, y: 0 },
    press(id, x, y) {
        this.dragging = id;
        document.documentElement.style.overflow = 'hidden'
        this.current.x = x;
        this.current.y = y;
    },
    drag(id, x, y) {
        if (this.dragging !== id) return;

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
        document.documentElement.style.overflow = 'auto'
        this.dragging = null;
    },
}">
    @foreach ($this->tables as $table)
        <div
            style="
                width: {{ $table->dimensions->width }}px;
                height: {{ $table->dimensions->height }}px;
                left: {{ $table->dimensions->x }}px;
                top: {{ $table->dimensions->y }}px;
            "
            class="absolute p-3 font-bold text-white uppercase rounded-xl bg-green-500/70"
            x-ref="draggable-{{ $table->id }}"
            x-data="{ id: 'draggable-{{ $table->id }}' }"
            x-on:mousedown.prevent="event => press(id, event.clientX, event.clientY)"
            x-on:touchstart.passive="event => press(id, event.touches[0].clientX, event.touches[0].clientY)"
            x-on:mousemove.prevent.document="event => drag(id, event.clientX, event.clientY)"
            x-on:touchmove.document="event => drag(id, event.touches[0].clientX, event.touches[0].clientY)"
            x-on:mouseup.prevent.document="unpress"
            x-on:touchend.document="unpress"
        >
            <span class="text-xl">
                {{ $table->label }}
            </span>
        </div>
    @endforeach
</div>
