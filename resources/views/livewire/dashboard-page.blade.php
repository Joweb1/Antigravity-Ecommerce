<div>
    <div class="container mx-auto px-4 py-8">
        <h1 class="font-orbitron text-3xl font-bold text-theme-text mb-8">My Orders</h1>

        <div class="space-y-8">
            @forelse ($orders as $order)
                <div wire:key="order-{{ $order->id }}" class="bg-theme-bg/50 backdrop-blur-sm border border-theme-border rounded-lg shadow-md overflow-hidden">
                    <div class="p-6 border-b border-theme-border flex justify-between items-center">
                        <div>
                            <h2 class="text-lg font-bold text-theme-text">Order #{{ $order->id }}</h2>
                            <p class="text-sm text-theme-text/70">Placed on: {{ $order->created_at->format('F d, Y') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-lg font-bold text-theme-accent">${{ number_format($order->total / 100, 2) }}</p>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full capitalize
                                @switch($order->status)
                                    @case('pending') bg-yellow-500/20 text-yellow-400 @break
                                    @case('completed') bg-green-500/20 text-green-400 @break
                                    @case('shipped') bg-blue-500/20 text-blue-400 @break
                                    @case('cancelled') bg-red-500/20 text-red-400 @break
                                    @default bg-gray-500/20 text-gray-400
                                @endswitch
                            ">
                                {{ $order->status }}
                            </span>
                        </div>
                    </div>
                    <div class="p-6">
                        <ul class="space-y-4">
                            @foreach ($order->orderItems as $item)
                                <li wire:key="order-item-{{ $item->id }}" class="flex items-center space-x-4">
                                    <div class="relative w-16 h-16 rounded-md border border-theme-border overflow-hidden flex-shrink-0"
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
                                                <span class="text-xs text-gray-400">No Img</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-grow">
                                        <p class="font-semibold text-theme-text">{{ $item->product->name }}</p>
                                        <p class="text-sm text-theme-text/70">Qty: {{ $item->quantity }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-semibold text-theme-text">${{ number_format($item->price / 100, 2) }}</p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @empty
                <div class="text-center py-16 bg-theme-bg/50 border border-theme-border rounded-lg">
                    <p class="text-xl text-theme-text/70">You haven't placed any orders yet.</p>
                    <a href="{{ route('shop') }}" class="mt-6 inline-block rounded-md border border-transparent bg-theme-accent px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-theme-accent/80" wire:navigate>
                        Start Shopping
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</div>