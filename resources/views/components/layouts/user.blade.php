<x-layouts.app>
    <nav class="bg-gray-900 border-b-2 rounded-b-lg shadow md:border-b-4 border-b-gray-500 ">
        <div class="relative flex items-center justify-between h-16 px-4 md:h-20 md:px-8">
            <div class="relative flex items-center flex-shrink-0">
                <x-filament::icon class="w-6 h-6 md:w-8 md:h-8 rotate-[-10deg] text-rose-600  dark:text-rose-500" icon="heroicon-o-calendar-days" />
                <x-filament::icon class="w-6 h-6 md:w-8 md:h-8 rotate-[-10deg] text-rose-600  dark:text-rose-500 absolute opacity-30 -left-1 scale-125" icon="heroicon-o-calendar-days" />
            </div>
            <button type="button"
                class="relative inline-flex items-center gap-x-1.5 rounded-md bg-rose-500 p-2 md:p-3 text-sm font-semibold text-white shadow-sm hover:bg-rose-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
                <svg class="-ml-0.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                </svg>
                Create reservation
            </button>

            <livewire:profile-dropdown />
        </div>
    </nav>

    {{ $slot }}

</x-layouts.app>
