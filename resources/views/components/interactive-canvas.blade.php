<div x-data="{
    dragging: false,
    start: { x: 0, y: 0 },
    current: { x: 0, y: 0 },
    press(x, y) {
        {{-- document.documentElement.style.overflow = 'hidden' --}}
        this.dragging = true;
        this.start.x = x - $refs.scrollable.offsetLeft;
        this.start.y = y - $refs.scrollable.offsetTop;
        this.current.x = $refs.scrollable.scrollLeft;
        this.current.y = $refs.scrollable.scrollTop;
    },
    drag(x, y) {
        if (! this.dragging) return;
        const left = x - $refs.scrollable.offsetLeft;
        const top = y - $refs.scrollable.offsetTop;
        const differenceX = (left - this.start.x);
        const differenceY = (top - this.start.y);
        $refs.scrollable.scrollLeft = this.current.x - differenceX;
        $refs.scrollable.scrollTop = this.current.y - differenceY;
    },
    pause() {
        {{-- document.documentElement.style.overflow = 'auto' --}}
        this.dragging = false;
    }
}">
    <div
        class="relative  border border-gray-200 shadow rounded-2xl bg-slate-800 cursor-grab active:cursor-grabbing overflow-hidden h-[800px] min-w-[200px]"
        x-ref="scrollable"
        x-on:mousedown.self="event => press(event.clientX, event.clientY)"
        x-on:touchstart.self.passive="event => press(event.touches[0].clientX, event.touches[0].clientY)"
        x-on:mousemove.self.prevent="event => drag(event.clientX, event.clientY)"
        x-on:touchmove.self="event => drag(event.touches[0].clientX, event.touches[0].clientY)"
        x-on:mouseup.document="pause"
        x-on:mouseleave="pause"
        x-on:touchend.document="pause"
    >
        {{ $slot }}
    </div>
</div>
