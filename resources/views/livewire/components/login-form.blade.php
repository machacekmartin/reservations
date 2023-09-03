<div>
    <form wire:submit="login">
        {{ $this->form }}

        <x-filament::button
            type="submit"
            icon="heroicon-o-arrow-long-right"
            icon-position="after"
            class="w-full mt-6"
        >
                Sign in
        </x-filament::button>
    </form>
</div>
