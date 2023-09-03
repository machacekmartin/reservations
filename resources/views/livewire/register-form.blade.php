<div>
    <form wire:submit="register">
        {{ $this->form }}

        <x-filament::button
            type="submit"
            icon="heroicon-o-arrow-long-right"
            icon-position="after"
            class="w-full mt-6"
        >
                Register
        </x-filament::button>
    </form>
</div>
