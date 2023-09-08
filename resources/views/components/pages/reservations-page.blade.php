<x-layouts.user>
    <ul role="list" class="grid grid-cols-1 gap-3 lg:grid-cols-2">
        @forelse ($reservations as $reservation)
            <li>
                <livewire:reservation-card :reservation="$reservation" />
            </li>
        @empty
            <li class="flex flex-col items-center w-full py-40 mx-auto text-gray-400 bg-white border border-gray-200 rounded-xl col-span-full">
                <x-filament::icon icon="heroicon-o-calendar" class="w-12 h-12 mb-2 opacity-50" />

                No reservations... yet..
            </li>
        @endforelse
    </ul>
</x-layouts.user>
