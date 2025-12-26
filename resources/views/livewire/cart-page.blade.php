<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-theme-text mb-8">Your Shopping Cart</h1>

    @if (session()->has('message'))
        <div class="bg-green-500 text-white p-4 rounded-lg mb-6">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-500 text-white p-4 rounded-lg mb-6">
            {{ session('error') }}
        </div>
    @endif

    @if($cart && $cart->cartItems->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="md:col-span-2">
                <div class="bg-theme-bg/50 border border-theme-border rounded-lg shadow-md">
                    <ul role="list" class="divide-y divide-theme-border">
                        @foreach($cart->cartItems as $item)
                            <li wire:key="cart-item-{{ $item->id }}"
                                x-data="{ isVisible: false }"
                                x-init="$nextTick(() => { isVisible = true })"
                                x-show="isVisible"
                                x-transition:enter="transition ease-out duration-500"
                                x-transition:enter-start="opacity-0 transform translate-y-5"
                                x-transition:enter-end="opacity-100 transform translate-y-0"
                                style="transition-delay: {{ $loop->index * 50 }}ms;"
                                class="flex p-6">
                                <div class="relative h-24 w-24 flex-shrink-0 overflow-hidden rounded-md border border-theme-border"
                                     x-data="{ imageLoaded: false }"
                                >
                                    {{-- Image Skeleton --}}
                                    <div x-show="!imageLoaded" class="absolute inset-0 bg-black shimmer-bg">
                                        {{-- No text --}}
                                    </div>
                                    @if($item->product->image_path)
                                        <img x-show="imageLoaded"
                                             @load="imageLoaded = true"
                                             src="{{ asset('storage/' . $item->product->image_path) }}" alt="{{ $item->product->name }}"
                                             class="h-full w-full object-cover object-center transition-opacity duration-300"
                                             :class="{ 'opacity-0': !imageLoaded, 'opacity-100': imageLoaded }"
                                        >
                                    @else
                                        <div x-show="imageLoaded" class="h-full w-full bg-black flex items-center justify-center">
                                            <span class="text-xs text-gray-400">No Image</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="ml-4 flex flex-1 flex-col">
                                    <div>
                                        <div class="flex justify-between text-base font-medium text-theme-text">
                                            <h3><a href="#">{{ $item->product->name }}</a></h3>
                                            <p class="ml-4">${{ number_format(($item->quantity * $item->product->price) / 100, 2) }}</p>
                                        </div>
                                    </div>
                                    <div class="flex flex-1 items-end justify-between text-sm">
                                        <div class="flex items-center">
                                            <button type="button" wire:click="decrement({{ $item->id }})" class="font-medium text-theme-accent hover:text-theme-accent/80 p-1">-</button>
                                            <span class="mx-2 text-theme-text">{{ $item->quantity }}</span>
                                            <button type="button" wire:click="increment({{ $item->id }})" class="font-medium text-theme-accent hover:text-theme-accent/80 p-1">+</button>
                                        </div>
                                        <div class="flex">
                                            <button type="button" wire:click="remove({{ $item->id }})" class="font-medium text-red-500 hover:text-red-400">Remove</button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="md:col-span-1">
                <div class="bg-theme-bg/50 border border-theme-border rounded-lg shadow-md p-6">
                    <h2 class="text-lg font-medium text-theme-text">Order summary</h2>
                    <div class="mt-6 space-y-4">
                        <div class="flex justify-between text-base font-medium text-theme-text">
                            <p>Subtotal</p>
                            <p>${{ number_format($totalPrice / 100, 2) }}</p>
                        </div>
                        <p class="mt-0.5 text-sm text-theme-text/70">Shipping and taxes will be calculated at the next step.</p>
                        <button
                            wire:click="checkout"
                            wire:loading.attr="disabled"
                            class="w-full flex items-center justify-center rounded-md border border-transparent bg-theme-accent px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-theme-accent/80 disabled:opacity-50"
                        >
                            <span wire:loading.remove wire:target="checkout">Checkout</span>
                            <span wire:loading wire:target="checkout">Processing...</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-16 bg-theme-bg/50 border border-theme-border rounded-lg">
            <p class="text-xl text-theme-text/70">Your cart is empty.</p>
            <a href="{{ route('shop') }}" class="mt-6 inline-block rounded-md border border-transparent bg-theme-accent px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-theme-accent/80">
                Continue Shopping
            </a>
        </div>
    @endif
</div>
