<div
    x-data="{
        profileOpened: false,
        hideProfileDropdown() { this.profileOpened = false },
        toggleProfileDropdown() { this.profileOpened = ! this.profileOpened }
    }"
    x-on:click.away="hideProfileDropdown">
    <button type="button"
        id="user-menu-button"
        aria-haspopup="true"
        aria-expanded="false"
        class="relative flex text-sm transition-all bg-gray-800 rounded-full ring ring-primary-500 hover:outline-none hover:ring-2 hover:ring-white hover:ring-offset-2 hover:ring-offset-gray-800"
        x-on:click="toggleProfileDropdown"
    >
        <span class="sr-only">Open user menu</span>
        <img class="w-8 h-8 rounded-full md:w-10 md:h-10" src="{{ $avatarUrl }}" alt="avatar">
    </button>
    <div
        role="menu"
        aria-orientation="vertical"
        aria-labelledby="user-menu-button"
        tabindex="-1"
        class="absolute z-10 w-48 mt-2 overflow-hidden origin-top-right bg-white divide-y rounded-md shadow-lg right-4 ring-1 ring-black ring-opacity-5 focus:outline-none"
        x-show="profileOpened"
        x-cloak
        x-transition
    >
        <a
            href="{{ route('edit-account') }}"
            wire:navigate
            id="user-menu-item-1"
            role="menuitem"
            tabindex="-1"
            class="flex items-center p-3 text-sm text-gray-700 md:px-5 md:py-4 hover:bg-gray-100 gap-x-3"
        >
            <x-filament::icon class="w-5 h-5 text-gray-600 " icon="heroicon-o-user-circle" />
            Account
        </a>

        <a
            href="{{ route('reservations') }}"
            wire:navigate
            id="user-menu-item-1"
            role="menuitem"
            tabindex="-1"
            class="flex items-center p-3 text-sm text-gray-700 md:px-5 md:py-4 hover:bg-gray-100 gap-x-3"
        >
            <x-filament::icon class="w-5 h-5 text-gray-600 " icon="heroicon-o-calendar" />
            Reservations
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button
                type="submit"
                id="user-menu-item-2"
                tabindex="-1"
                class="flex items-center w-full p-3 text-sm text-gray-700 bg-gray-50 md:px-5 md:py-4 gap-x-3"
            >
                <x-filament::icon class="w-5 h-5 text-gray-600 " icon="heroicon-o-arrow-left-on-rectangle" />
                Logout
            </button>
        </form>
    </div>
</div>
