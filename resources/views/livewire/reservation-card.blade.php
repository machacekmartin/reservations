<div class="overflow-hidden border border-gray-200 rounded-xl">
    <div class="flex items-center h-16 p-4 pb-6 bg-white border-b gap-x-4 border-gray-900/5">
        <div class="flex items-center text-sm font-medium text-gray-900 gap-x-2">
            <x-filament::icon icon="heroicon-o-calendar" class="w-5 h-5 text-gray-600" />
            {{ $reservation->start_at->format('d. m. Y') }}
        </div>
        <div class="relative ml-auto">
            @if ($reservation->canceled_at === null)
                <x-filament::button
                    size="xs"
                    icon="heroicon-o-no-symbol"
                    outlined
                    :color="\Filament\Support\Colors\Color::Rose"
                    wire:click="cancel"
                >
                    Cancel
                </x-filament::button>
            @endif
        </div>
    </div>
    <dl class="px-6 py-4 -my-3 text-sm leading-6 divide-y divide-gray-100 bg-gray-50">
        <div class="flex justify-between py-1.5 gap-x-4">
            <dt class="text-gray-500">
                Time
            </dt>
            <dd class="text-gray-700">
                {{ $reservation->start_at->format('H:i') }} -
                {{ $reservation->end_at->format('H:i') }}
            </dd>
        </div>
        <div class="flex justify-between py-1.5 gap-x-4">
            <dt class="text-gray-500">Status</dt>
            <dd class="flex items-start gap-x-2">
                <x-filament::badge
                    :color="$reservation->status->getColor()"
                    :icon="$reservation->status->getIcon()"
                >
                    {{ $reservation->status }}
                </x-filament::badge>
            </dd>
        </div>
        <div class="flex justify-between py-1.5 gap-x-4">
            <dt class="text-gray-500">
                Reminder
            </dt>
            <dd class="text-gray-700">
                @if ($reservation->remind_at)
                    {{ $reservation->remind_at->diffInMinutes($reservation->start_at) }} minutes before start
                @else
                    -
                @endif
            </dd>
        </div>
        <div class="flex justify-between py-1.5 gap-x-4">
            <dt class="text-gray-500">
                Guests
            </dt>
            <dd class="text-gray-700">
                @if ($reservation->tables()->count() === 1)
                    1 table
                @else
                    {{ $reservation->tables()->count() }} tables
                @endif

                @if ($reservation->guest_count === 1)
                    for 1 person
                @else
                    for {{ $reservation->guest_count }} people
                @endif
            </dd>
        </div>
        <div class="flex justify-between py-1.5 gap-x-4">
            <dt class="text-gray-500">
                Note
            </dt>
            <dd class="text-gray-700">
                {{ $reservation->note ?? '-' }}
            </dd>
        </div>
    </dl>

    <x-filament-actions::modals />
</div>
