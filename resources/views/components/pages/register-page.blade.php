<x-layouts.auth>
    <div>
        <x-filament::icon class="w-12 h-12 rotate-[-10deg] text-rose-600 fi-sidebar-group-icon dark:text-rose-500" icon="heroicon-o-users" />
        <h2 class="mt-4 text-2xl font-bold leading-9 tracking-tight text-gray-900">
            Create new account
        </h2>
        <p class="mt-2 mb-4 text-sm leading-6 text-gray-500">
            Already have an account?
            <a href="{{ route('login') }}" wire:navigate class="font-semibold text-rose-600 hover:text-rose-500" >Sign in.</a>
        </p>
        <livewire:register-form />
    </div>
</x-layouts.auth>
