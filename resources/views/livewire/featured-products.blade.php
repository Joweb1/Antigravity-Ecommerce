<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
    @foreach($products as $product)
        <div wire:key="featured-product-{{ $product->id }}"
             x-data="{ isVisible: false, imageLoaded: false }"
             x-init="$nextTick(() => { isVisible = true })"
             x-show="isVisible"
             x-transition:enter="transition ease-out duration-500"
             x-transition:enter-start="opacity-0 transform translate-y-5"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             style="transition-delay: {{ $loop->index * 50 }}ms;"
             class="open-product-modal product-card border border-theme-border p-6 rounded-lg bg-theme-bg/50 backdrop-blur-sm text-center"
             data-product-id="{{ $product->id }}">

            <div class="relative h-48 w-full mb-4 overflow-hidden rounded-md">
                {{-- Image Skeleton --}}
                <div x-show="!imageLoaded" class="absolute inset-0 bg-black shimmer-bg">
                    {{-- No text --}}
                </div>
                @if($product->image_path)
                    <img x-show="imageLoaded"
                         @load="imageLoaded = true"
                         src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}"
                         class="h-full w-full object-cover object-center transition-opacity duration-300"
                         :class="{ 'opacity-0': !imageLoaded, 'opacity-100': imageLoaded }"
                    >
                @else
                    <div x-show="imageLoaded" class="h-full w-full bg-black flex items-center justify-center">
                        <span class="text-xs text-gray-400">No Image</span>
                    </div>
                @endif
            </div>

            <h3 class="text-xl font-semibold text-theme-text">{{ $product->name }}</h3>
            <p class="text-theme-accent font-bold mt-2">${{ number_format($product->price / 100, 2) }}</p>
            <p class="text-sm text-theme-text/60 mt-2">{{ Str::limit($product->description, 100) }}</p>
            <button type="button" @click="$dispatch('open-product-modal', { productId: {{ $product->id }} })" class="mt-4 px-6 py-2 bg-theme-accent rounded-md hover:bg-theme-accent/80 transition inline-block">View Details</button>
        </div>
    @endforeach
</div>
