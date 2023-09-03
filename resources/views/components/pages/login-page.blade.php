<x-layouts.auth>
    <div>
        <x-filament::icon class="w-12 h-12 rotate-[-10deg] text-rose-600 fi-sidebar-group-icon dark:text-rose-500" icon="heroicon-o-calendar-days" />
        <h2 class="mt-4 text-2xl font-bold leading-9 tracking-tight text-gray-900">
            Sign in to make a reservation
        </h2>
        <p class="mt-2 mb-4 text-sm leading-6 text-gray-500">
            Don't have an account?
            <a href="{{ route('register') }}" wire:navigate class="font-semibold text-rose-600 hover:text-rose-500">Make one.</a>
        </p>

        <livewire:login-form />
    </div>
</x-layouts.auth>
