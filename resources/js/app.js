import './bootstrap';

// Initialize Alpine.js for the modal's open/close state
document.addEventListener('alpine:init', () => {
    // No explicit Alpine.data needed here as the x-data is inline in the modal component
    // We just ensure Alpine is loaded before the modal logic runs.
});

// Helper function to dispatch custom events
function dispatchEvent(name, detail = {}) {
    window.dispatchEvent(new CustomEvent(name, { detail }));
}

// Global object to manage modal state and product data
const productModal = {
    modalElement: null,
    productId: null,
    productData: null,
    currentImageIndex: 0,
    carouselInterval: null,
    
    // Cached DOM elements
    carouselContainer: null,
    noImagePlaceholder: null,
    modalProductName: null,
    modalProductPrice: null,
    modalProductDescription: null,
    modalProductStock: null,
    modalCarouselDots: null,
    modalProductQuantity: null,
    modalAddToCartBtn: null,
    modalCarouselPrev: null,
    modalCarouselNext: null,

    init() {
        this.modalElement = document.getElementById('product-display-modal');
        if (!this.modalElement) {
            console.error('Product modal element not found.');
            return;
        }

        // Get all necessary DOM elements and store them
        this.carouselContainer = document.getElementById('modal-product-image-carousel');
        this.noImagePlaceholder = document.getElementById('modal-no-image-placeholder');
        this.modalProductName = document.getElementById('modal-product-name');
        this.modalProductPrice = document.getElementById('modal-product-price');
        this.modalProductDescription = document.getElementById('modal-product-description');
        this.modalProductStock = document.getElementById('modal-product-stock');
        this.modalCarouselDots = document.getElementById('modal-carousel-dots');
        this.modalProductQuantity = document.getElementById('modal-product-quantity');
        this.modalAddToCartBtn = document.getElementById('modal-add-to-cart-btn');
        this.modalCarouselPrev = document.getElementById('modal-carousel-prev');
        this.modalCarouselNext = document.getElementById('modal-carousel-next');


        // Event listeners for carousel navigation
        if (this.modalCarouselPrev) this.modalCarouselPrev.addEventListener('click', () => this.prevImage());
        if (this.modalCarouselNext) this.modalCarouselNext.addEventListener('click', () => this.nextImage());
        if (this.modalAddToCartBtn) this.modalAddToCartBtn.addEventListener('click', () => this.addToCart());

        // Listen for open modal event
        window.addEventListener('open-product-modal', (e) => this.fetchAndShowProduct(e.detail.productId));
    },

    async fetchAndShowProduct(productId) {
        if (!productId) {
            console.error('No product ID provided to showProductModal.');
            return;
        }

        this.productId = productId;
        this.currentImageIndex = 0; // Reset carousel index

        this.showLoadingState();
        dispatchEvent('open-product-modal'); // Open modal with loading state

        try {
            const response = await fetch(`/products/${productId}`);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            this.productData = await response.json();
            this.populateModal();
            this.hideLoadingState();
        } catch (error) {
            console.error('Error fetching product details:', error);
            // Optionally, show an error message in the modal
            this.hideLoadingState();
            dispatchEvent('close-product-modal');
        }
    },

    showLoadingState() {
        if (this.carouselContainer) {
            this.carouselContainer.classList.add('shimmer-bg');
            this.carouselContainer.innerHTML = ''; // Clear images
        }
        if (this.noImagePlaceholder) {
            this.noImagePlaceholder.style.display = 'none';
        }

        if (this.modalProductName) this.modalProductName.textContent = 'Loading...';
        if (this.modalProductPrice) this.modalProductPrice.textContent = '';
        if (this.modalProductDescription) this.modalProductDescription.textContent = 'Loading product details...';
        if (this.modalProductStock) this.modalProductStock.textContent = '';
        if (this.modalCarouselDots) this.modalCarouselDots.innerHTML = '';
        if (this.modalProductQuantity) this.modalProductQuantity.value = 1;
        if (this.modalAddToCartBtn) this.modalAddToCartBtn.setAttribute('disabled', 'true');

        if (this.modalCarouselPrev) this.modalCarouselPrev.style.display = 'none';
        if (this.modalCarouselNext) this.modalCarouselNext.style.display = 'none';
    },

    hideLoadingState() {
        if (this.carouselContainer) this.carouselContainer.classList.remove('shimmer-bg');
        if (this.modalAddToCartBtn) this.modalAddToCartBtn.removeAttribute('disabled');
    },

    populateModal() {
        if (!this.productData) return;

        const p = this.productData;

        if (this.modalProductName) this.modalProductName.textContent = p.name;
        if (this.modalProductPrice) this.modalProductPrice.textContent = `$${(p.price / 100).toFixed(2)}`;
        if (this.modalProductDescription) this.modalProductDescription.textContent = p.description;
        if (this.modalProductStock) this.modalProductStock.textContent = `${p.stock_quantity} in stock`;
        if (this.modalProductQuantity) {
            this.modalProductQuantity.max = p.stock_quantity;
            this.modalProductQuantity.value = 1; // Reset quantity
        }
        if (this.modalAddToCartBtn) this.modalAddToCartBtn.setAttribute('data-product-id', p.id);

        this.updateCarousel();
    },

    updateCarousel() {
        if (!this.carouselContainer || !this.modalCarouselDots || !this.noImagePlaceholder) return;

        this.carouselContainer.innerHTML = ''; // Clear previous images
        this.modalCarouselDots.innerHTML = ''; // Clear previous dots

        // For now, product data only has one image_path. If it had an array, we'd loop.
        // Assuming 'p' is already set from productData
        const p = this.productData;
        const images = p && p.image_path ? [p.image_path] : [];

        if (images.length > 0) {
            this.noImagePlaceholder.style.display = 'none';
            images.forEach((imgPath, index) => {
                const imgElement = document.createElement('img');
                imgElement.src = `/storage/${imgPath}`; // Assuming image_path is relative to storage
                imgElement.alt = p.name;
                imgElement.classList.add('absolute', 'inset-0', 'h-full', 'w-full', 'object-cover', 'object-center', 'transition-opacity', 'duration-300');
                imgElement.style.opacity = (index === this.currentImageIndex) ? '1' : '0';
                this.carouselContainer.appendChild(imgElement);

                const dot = document.createElement('button');
                dot.classList.add('h-2', 'w-2', 'rounded-full', 'bg-theme-text/30', 'hover:bg-theme-accent', 'transition');
                if (index === this.currentImageIndex) {
                    dot.classList.add('bg-theme-accent');
                }
                dot.addEventListener('click', () => this.goToImage(index));
                this.modalCarouselDots.appendChild(dot);
            });
            if (this.modalCarouselPrev) this.modalCarouselPrev.style.display = images.length > 1 ? 'block' : 'none';
            if (this.modalCarouselNext) this.modalCarouselNext.style.display = images.length > 1 ? 'block' : 'none';

        } else {
            this.noImagePlaceholder.style.display = 'flex';
            if (this.modalCarouselPrev) this.modalCarouselPrev.style.display = 'none';
            if (this.modalCarouselNext) this.modalCarouselNext.style.display = 'none';
        }
    },

    goToImage(index) {
        // Ensure this.productData is available before proceeding
        if (!this.productData) return;
        const p = this.productData;
        const imagesCount = p && p.image_path ? 1 : 0; // Adjust if multiple images are supported

        if (imagesCount === 0) return;
        this.currentImageIndex = index;
        this.updateCarousel();
    },

    prevImage() {
        if (!this.productData) return;
        const p = this.productData;
        const imagesCount = p && p.image_path ? 1 : 0; // Adjust if multiple images are supported

        if (imagesCount === 0) return;
        this.currentImageIndex = (this.currentImageIndex - 1 + imagesCount) % imagesCount;
        this.updateCarousel();
    },

    nextImage() {
        if (!this.productData) return;
        const p = this.productData;
        const imagesCount = p && p.image_path ? 1 : 0; // Adjust if multiple images are supported

        if (imagesCount === 0) return;
        this.currentImageIndex = (this.currentImageIndex + 1) % imagesCount;
        this.updateCarousel();
    },

    addToCart() {
        if (!this.modalAddToCartBtn || !this.modalProductQuantity) return;

        const productId = this.modalAddToCartBtn.getAttribute('data-product-id');
        const quantity = parseInt(this.modalProductQuantity.value);

        if (productId && quantity > 0) {
            Livewire.dispatch('addToCart', { productId: productId, quantity: quantity });

            const button = this.modalAddToCartBtn;
            const originalText = button.textContent;
            button.textContent = 'Adding...';
            button.setAttribute('disabled', 'true');

            setTimeout(() => {
                button.textContent = originalText;
                button.removeAttribute('disabled');
                dispatchEvent('close-product-modal');
            }, 1000);
        }
    }
};

// Initialize the product modal logic when the DOM is fully loaded
document.addEventListener('DOMContentLoaded', () => {
    productModal.init();

    document.body.addEventListener('click', (event) => {
        const productCard = event.target.closest('.open-product-modal');
        if (productCard) {
            const productId = productCard.dataset.productId;
            if (productId) {
                dispatchEvent('open-product-modal', { productId: productId });
            }
        }
    });
});