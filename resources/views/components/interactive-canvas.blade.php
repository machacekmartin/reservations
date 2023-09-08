<div x-data="{
    dragging: false,
    start: { x: 0, y: 0 },
    current: { x: 0, y: 0 },
    press(x, y) {
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
        this.dragging = false;
    }
}">
    <div class="h-[650px] min-w-[200px] border-gray-200 border dark:border-gray-800 rounded-2xl overflow-hidden">
        @if(\App\Models\Table::query()->count() === 0)
            <div class="flex flex-col items-center justify-center h-full text-sm text-gray-400 bg-white dark:bg-gray-900">
                <x-filament::icon icon="heroicon-o-face-frown" class="mb-2 opacity-50 w-14 h-14" />
                There are no tables in the system.. yet..
            </div>
        @else
            <div
                class="relative h-full overflow-hidden bg-slate-800 cursor-grab active:cursor-grabbing"
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
        @endif
    </div>
</div>
