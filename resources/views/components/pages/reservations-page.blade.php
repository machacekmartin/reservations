<x-layouts.user>
    <ul role="list" class="grid grid-cols-1 gap-3 lg:grid-cols-2">
        @foreach ($reservations as $reservation)
            <li>
                <livewire:reservation-card :reservation="$reservation" />
            </li>
        @endforeach
    </ul>
</x-layouts.user>
