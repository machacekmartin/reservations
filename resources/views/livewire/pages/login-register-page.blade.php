<div class="flex min-h-screen">
    <div class="flex flex-col justify-center flex-1 px-4 py-12 sm:px-6 lg:flex-none lg:px-20 xl:px-24">
        <div class="w-full max-w-sm mx-auto lg:w-96">
            <x-filament::icon class="w-12 h-12 rotate-[-10deg] text-rose-600 fi-sidebar-group-icon dark:text-rose-500"
                icon="heroicon-o-calendar-days" />
            <h2 class="mt-4 text-2xl font-bold leading-9 tracking-tight text-gray-900">
                @if($showRegisterForm)
                    Create new account
                @else
                    Sign in to make a reservation
                @endif
            </h2>
            <p class="mt-2 mb-4 text-sm leading-6 text-gray-500">
                @if($showRegisterForm)
                    Already have an account?
                    <a href="#" class="font-semibold text-rose-600 hover:text-rose-500" wire:click="showLogin">Sign In.</a>
                @else
                    Don't have an account?
                    <a href="#" class="font-semibold text-rose-600 hover:text-rose-500" wire:click="showRegister">Make one.</a>
                @endif
            </p>
            @if($showRegisterForm)
                <!-- register -->
            @else
                <livewire:components.login-form />
            @endif
        </div>
    </div>
    <div class="relative flex-1 hidden w-0 lg:block">
        <img class="absolute inset-0 object-cover w-full h-full"
            src="https://images.unsplash.com/photo-1635548166842-bf67bacbefaa?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2574&q=80"
            alt="">
    </div>
</div>
