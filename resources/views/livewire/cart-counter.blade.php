<a href="{{ route('cart') }}" class="relative text-[10px] uppercase tracking-widest font-bold hover:text-theme-accent transition flex items-center space-x-1" wire:navigate>
    <span class="material-icons-outlined text-base">shopping_cart</span>
    @if($cartItemCount > 0)
        <span class="absolute -top-2 -right-2 bg-theme-accent text-white rounded-full text-xs w-4 h-4 flex items-center justify-center">
            {{ $cartItemCount }}
        </span>
    @endif
</a>