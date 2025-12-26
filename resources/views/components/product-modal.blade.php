<div id="product-display-modal"
     class="fixed inset-0 z-[99999] hidden items-center justify-center bg-black bg-opacity-75 backdrop-blur-sm"
     x-data="{ open: false }"
     x-show="open"
     x-on:open-product-modal.window="open = true; document.body.classList.add('overflow-hidden')"
     x-on:close-product-modal.window="open = false; document.body.classList.remove('overflow-hidden')"
     x-on:keydown.escape.window="open = false; document.body.classList.remove('overflow-hidden')"
>
    <div x-show="open"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
         class="relative bg-theme-bg/90 border border-theme-border rounded-lg shadow-2xl overflow-hidden w-full max-w-4xl max-h-[90vh] mx-4 p-6 text-theme-text flex flex-col md:flex-row gap-6"
         @click.away="$dispatch('close-product-modal')"
    >
        {{-- Close button --}}
        <button type="button"
                class="absolute top-4 right-4 text-theme-text/70 hover:text-theme-text transition"
                @click="$dispatch('close-product-modal')">
            <span class="material-icons-outlined text-3xl">close</span>
        </button>

        {{-- Product Image Carousel --}}
        <div class="w-full md:w-1/2 flex-shrink-0 relative">
            <div id="modal-product-image-carousel" class="relative w-full h-80 bg-black shimmer-bg rounded-lg overflow-hidden">
                {{-- Images will be injected here by JavaScript --}}
                <div class="absolute inset-0 flex items-center justify-center text-theme-text/50" id="modal-no-image-placeholder">
                    No Image Available
                </div>
            </div>
            <div class="flex justify-center gap-2 mt-4" id="modal-carousel-dots">
                {{-- Dots will be injected here by JavaScript --}}
            </div>
            <button id="modal-carousel-prev" class="absolute left-2 top-1/2 -translate-y-1/2 bg-black/50 hover:bg-black/75 rounded-full p-2 text-white">
                <span class="material-icons-outlined">chevron_left</span>
            </button>
            <button id="modal-carousel-next" class="absolute right-2 top-1/2 -translate-y-1/2 bg-black/50 hover:bg-black/75 rounded-full p-2 text-white">
                <span class="material-icons-outlined">chevron_right</span>
            </button>
        </div>

        {{-- Product Details --}}
        <div class="w-full md:w-1/2 flex flex-col justify-between overflow-y-auto">
            <div>
                <h2 id="modal-product-name" class="font-orbitron text-4xl font-bold mb-2 text-theme-accent"></h2>
                <p id="modal-product-price" class="text-3xl font-bold text-theme-text mb-4"></p>
                <p id="modal-product-description" class="text-theme-text/70 text-lg mb-4"></p>
                <p id="modal-product-stock" class="text-sm text-theme-text/60 mb-6"></p>
            </div>

            {{-- Actions --}}
            <div class="mt-auto flex items-center gap-4">
                <input type="number" id="modal-product-quantity" value="1" min="1"
                       class="w-24 bg-theme-bg/60 border-theme-border text-theme-text rounded-md shadow-sm focus:border-theme-accent focus:ring-theme-accent">
                <button id="modal-add-to-cart-btn"
                        class="antigravity-button-primary flex-grow">
                    <span class="material-icons-outlined mr-2">add_shopping_cart</span> Add to Cart
                </button>
            </div>
        </div>
    </div>
</div>
