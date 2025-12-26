<div
    x-show="open"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0 transform scale-95"
    x-transition:enter-end="opacity-100 transform scale-100"
    x-transition:leave="transition ease-in duration-75"
    x-transition:leave-start="opacity-100 transform scale-100"
    x-transition:leave-end="opacity-0 transform scale-95"
    class="absolute right-0 top-full mt-2 w-48 origin-top-right rounded-md shadow-lg border border-theme-border bg-theme-bg/80 backdrop-blur-sm focus:outline-none"
    role="menu"
    aria-orientation="vertical"
    aria-labelledby="user-menu-button"
    @click.away="open = false"
>
    <div class="py-1" role="none">
        <div class="flex items-center px-4 py-2 space-x-3">
            <div class="flex-shrink-0">
                <div class="h-10 w-10 rounded-full bg-theme-accent/20 border border-theme-accent flex items-center justify-center">
                    <span class="text-lg font-bold text-theme-accent">
                        {{ strtoupper(substr(auth()->user()->email, 0, 1)) }}
                    </span>
                </div>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-theme-text truncate">
                    {{ auth()->user()->name }}
                </p>
                <p class="text-xs text-theme-text/70 truncate">
                    {{ auth()->user()->email }}
                </p>
            </div>
        </div>

        <div class="border-t border-theme-border my-1"></div>

        <a href="{{ route('home') }}"
           class="block w-full px-4 py-2 text-left text-sm text-theme-text hover:bg-theme-accent/10"
           role="menuitem"
           wire:navigate
        >
            Home
        </a>

        <a href="{{ route('dashboard') }}"
           class="block w-full px-4 py-2 text-left text-sm text-theme-text hover:bg-theme-accent/10"
           role="menuitem"
           wire:navigate
        >
            Dashboard
        </a>

        <a href="{{ route('profile') }}"
           class="block w-full px-4 py-2 text-left text-sm text-theme-text hover:bg-theme-accent/10"
           role="menuitem"
           wire:navigate
        >
            Account Settings
        </a>

        <button
            wire:click="logout"
            type="button"
            class="block w-full px-4 py-2 text-left text-sm text-red-500 hover:bg-theme-accent/10"
            role="menuitem"
        >
            Log Out
        </button>
    </div>
</div>
