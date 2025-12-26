<div class="container mx-auto px-4 py-8" id="product-list">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-theme-text">Shop</h1>
        <button wire:click="toggleLayout" class="p-2 rounded-full hover:bg-theme-bg/50 focus:outline-none focus:ring-2 focus:ring-theme-accent">
            @if ($layout === 'grid')
                <span class="material-icons-outlined text-theme-text">view_list</span>
            @else
                <span class="material-icons-outlined text-theme-text">grid_view</span>
            @endif
        </button>
    </div>

    @if (session()->has('error'))
        <div class="bg-red-500 text-white p-4 rounded-lg mb-6">
            {{ session('error') }}
        </div>
    @endif

    <div class="relative">
        {{-- Loading Overlay --}}
            <div wire:loading.flex class="fixed inset-0 bg-theme-bg/80 backdrop-blur-sm flex items-center justify-center z-[99999]">
                <div class="flex space-x-2">                <div class="h-2 w-2 bg-theme-accent rounded-full animate-bounce" style="animation-delay: -0.3s;"></div>
                <div class="h-2 w-2 bg-theme-accent rounded-full animate-bounce" style="animation-delay: -0.15s;"></div>
                <div class="h-2 w-2 bg-theme-accent rounded-full animate-bounce"></div>
            </div>
        </div>

        {{-- Actual Product List --}}
        <div wire:loading.remove class="@if($layout === 'grid') grid grid-cols-1 sm:grid-cols-2 gap-8 @else space-y-4 @endif">
            @foreach($products as $product)
                {{-- Use a single component with different classes for each layout --}}
                <div wire:key="product-{{ $product->id }}"
                     x-data="{ isVisible: false, imageLoaded: false }"
                     x-init="$nextTick(() => { isVisible = true })"
                     x-show="isVisible"
                     x-transition:enter="transition ease-out duration-500"
                     x-transition:enter-start="opacity-0 transform translate-y-5"
                     x-transition:enter-end="opacity-100 transform translate-y-0"
                     style="transition-delay: {{ $loop->index * 50 }}ms;"
                     class="open-product-modal product-item group relative border border-theme-border rounded-lg overflow-hidden bg-theme-bg/50 backdrop-blur-sm transition-all duration-300 ease-in-out hover:border-theme-accent hover:shadow-2xl hover:shadow-theme-accent/10 cursor-pointer @if($layout === 'list') flex @endif"
                     data-product-id="{{ $product->id }}">

                    {{-- Image container --}}
                    <div class="relative overflow-hidden @if($layout === 'grid') h-60 w-full @else h-32 w-32 flex-shrink-0 @endif">
                                                <div x-show="!imageLoaded" class="absolute inset-0 bg-black shimmer-bg">                            {{-- No text --}}
                        </div>
                        @if($product->image_path)
                            <img x-show="imageLoaded"
                                 @load="imageLoaded = true"
                                 src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}"
                                 class="h-full w-full object-cover object-center transition-opacity duration-300 @if($layout === 'grid') group-hover:scale-110 @endif"
                                 :class="{ 'opacity-0': !imageLoaded, 'opacity-100': imageLoaded }"
                            >
                        @else
                            <div x-show="!imageLoaded" class="absolute inset-0 bg-black shimmer-bg">
                                {{-- No text --}}
                            </div>
                            <div x-show="imageLoaded" class="h-full w-full bg-gray-700 flex items-center justify-center">
                                <span class="text-xs text-gray-400">No Image</span>
                            </div>
                        @endif
                    </div>

                    {{-- Details container --}}
                    <div class="p-4 flex flex-col flex-grow">
                        <h2 class="text-lg font-semibold text-theme-text truncate group-hover:text-theme-accent transition-colors duration-300">
                            {{ $product->name }}
                        </h2>
                        
                        @if ($layout === 'list')
                            <p class="text-sm text-theme-text/70 mt-2 flex-grow">{{ Str::limit($product->description, 100) }}</p>
                        @endif

                        <div class="mt-4 flex items-center @if($layout === 'grid') justify-between @else justify-start space-x-8 @endif">
                            <p class="text-xl font-bold text-theme-accent">
                                ${{ number_format($product->price / 100, 2) }}
                            </p>
                            <p class="text-xs text-theme-text/50">
                                {{ $product->stock_quantity }} in stock
                            </p>
                        </div>

                        @if ($layout === 'grid')
                            <button wire:click.prevent="addToCart({{ $product->id }})" wire:loading.attr="disabled" class="mt-4 w-full flex items-center justify-center rounded-md border border-transparent bg-theme-accent px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-theme-accent/80 disabled:opacity-50">
                                <span wire:loading.remove wire:target="addToCart({{ $product->id }})">Add to Cart</span>
                                <span wire:loading wire:target="addToCart({{ $product->id }})">Adding...</span>
                            </button>
                        @else
                             <div class="mt-4">
                                <button wire:click.prevent="addToCart({{ $product->id }})" wire:loading.attr="disabled" class="inline-flex items-center justify-center rounded-md border border-transparent bg-theme-accent px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-theme-accent/80 disabled:opacity-50">
                                    <span wire:loading.remove wire:target="addToCart({{ $product->id }})">Add to Cart</span>
                                    <span wire:loading wire:target="addToCart({{ $product->id }})">Adding...</span>
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $products->links() }}
        </div>
    </div>
</div>
