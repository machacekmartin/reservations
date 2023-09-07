<div>
    <div class="mb-6">
        <h2 class="mb-2 font-semibold">1. Which day</h2>
        <form>
            {{ $this->form }}
        </form>
    </div>

    <h2 class="mb-2 font-semibold">2. Select available tables</h2>
    <x-interactive-canvas>
        <livewire:select-interactive-tables />
    </x-interactive-canvas>

    <div>
        <h2 class="mb-2 font-semibold">3. Time range</h2>
        <ul>
            @foreach ($this->times as $time)
                <li>
                    {{ $time['time']->format('H:i') }}
                    {{ $time['reserved'] ? 'reserved' : 'available' }}
                </li>
            @endforeach
        </ul>
    </div>
</div>
