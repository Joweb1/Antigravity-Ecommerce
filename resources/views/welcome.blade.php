<x-app-layout>
    <div class="relative text-white overflow-hidden">
        {{-- Floating Blur Background --}}
        <div class="absolute inset-0 z-0 opacity-50">
            <div class="blur-circle bg-purple-600 top-[-20%] left-[-5%] w-96 h-96 animate-float1"></div>
            <div class="blur-circle bg-blue-500 bottom-[-20%] right-[-5%] w-96 h-96 animate-float2" style="animation-delay: 3s;"></div>
            <div class="blur-circle bg-pink-500 top-[50%] left-[10%] w-72 h-72 animate-float3" style="animation-delay: 6s;"></div>
            <div class="blur-circle bg-teal-500 top-[10%] right-[15%] w-64 h-64 animate-float4" style="animation-delay: 9s;"></div>
            <div class="blur-circle bg-yellow-500 bottom-[5%] left-[30%] w-80 h-80 animate-float5" style="animation-delay: 12s;"></div>
        </div>

        {{-- Hero Section --}}
        <div id="hero-section" class="relative min-h-[calc(100vh-5rem)] flex items-center justify-center text-center px-4">
            <div class="max-w-3xl">
                <h1 id="hero-title" class="font-orbitron text-5xl sm:text-7xl md:text-8xl font-black uppercase tracking-wider">
                    Define The
                    <span class="text-theme-accent">Next</span>
                    Dimension
                </h1>
                <p id="hero-subtitle" class="mt-6 text-lg sm:text-xl text-theme-text/70 max-w-2xl mx-auto">
                    Welcome to Antigravity, where the future of commerce is now. Explore our curated selection of cutting-edge technology and redefine what's possible.
                </p>
                <div id="hero-cta" class="mt-10">
                    <a href="{{ route('shop') }}" wire:navigate
                       class="inline-flex items-center space-x-2 rounded-full border border-theme-accent/50 bg-theme-bg/50 backdrop-blur-sm px-8 py-4 text-base font-semibold text-white shadow-lg transition hover:bg-theme-accent/80 hover:shadow-theme-accent/20 focus:outline-none focus:ring-2 focus:ring-theme-accent focus:ring-offset-2 focus:ring-offset-theme-bg"
                       wire:navigate>
                        <span class="material-icons-outlined">shopping_bag</span>
                        <span>Explore The Collection</span>
                    </a>
                </div>
            </div>
        </div>

        {{-- Feature Section --}}
        <div id="feature-section" class="py-16 sm:py-24">
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                    <div class="feature-item border border-theme-border p-8 rounded-lg bg-theme-bg/50 backdrop-blur-sm">
                        <div class="inline-block p-4 bg-theme-accent/10 rounded-full mb-4">
                            <span class="material-icons-outlined text-4xl text-theme-accent">rocket_launch</span>
                        </div>
                        <h3 class="text-xl font-bold">Interstellar Delivery</h3>
                        <p class="mt-2 text-sm text-theme-text/60">
                            From our warehouse to your star system. We provide fast, reliable, and secure shipping across the galaxy.
                        </p>
                    </div>
                    <div class="feature-item border border-theme-border p-8 rounded-lg bg-theme-bg/50 backdrop-blur-sm">
                        <div class="inline-block p-4 bg-theme-accent/10 rounded-full mb-4">
                            <span class="material-icons-outlined text-4xl text-theme-accent">verified_user</span>
                        </div>
                        <h3 class="text-xl font-bold">Quantum Encryption</h3>
                        <p class="mt-2 text-sm text-theme-text/60">
                            Your data and transactions are secured with next-generation quantum encryption, ensuring total privacy.
                        </p>
                    </div>
                    <div class="feature-item border border-theme-border p-8 rounded-lg bg-theme-bg/50 backdrop-blur-sm">
                        <div class="inline-block p-4 bg-theme-accent/10 rounded-full mb-4">
                            <span class="material-icons-outlined text-4xl text-theme-accent">support_agent</span>
                        </div>
                        <h3 class="text-xl font-bold">24/7 Support</h3>
                        <p class="mt-2 text-sm text-theme-text/60">
                            Our support droids are available around the clock to assist you with any questions or anomalies.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Our Vision Section --}}
        <div id="vision-section" class="py-16 sm:py-24 bg-theme-bg/70">
            <div class="container mx-auto px-4 text-center">
                <div class="max-w-4xl mx-auto">
                    <span class="material-icons-outlined text-6xl text-theme-accent mb-4">visibility</span>
                    <h2 class="font-orbitron text-4xl font-bold text-theme-text mb-6">Our Vision: Beyond the Horizon</h2>
                    <p class="text-lg text-theme-text/70 leading-relaxed">
                        At Antigravity, we believe in pushing the boundaries of what's possible. We're not just selling products; we're curating experiences that transcend the ordinary. Our vision is to empower individuals to explore new frontiers, connect with unseen worlds, and define their own next dimension through technology that inspires awe and innovation. Join us on a journey where imagination takes flight.
                    </p>
                </div>
            </div>
        </div>

        {{-- Featured Products Section --}}
        <div id="featured-products-section" class="py-16 sm:py-24">
            <div class="container mx-auto px-4">
                <h2 class="font-orbitron text-4xl font-bold text-theme-text text-center mb-12">Featured Creations</h2>
                <livewire:featured-products />
            </div>
        </div>

        {{-- Testimonials Section --}}
        <div id="testimonials-section" class="py-16 sm:py-24 bg-theme-bg/70">
            <div class="container mx-auto px-4">
                <h2 class="font-orbitron text-4xl font-bold text-theme-text text-center mb-12">What Our Pioneers Say</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="testimonial-card border border-theme-border p-8 rounded-lg bg-theme-bg/50 backdrop-blur-sm">
                        <p class="text-lg italic text-theme-text/80 mb-4">"Antigravity has revolutionized my interstellar travels. The Chronos Communicator is simply indispensable. Unparalleled quality and innovation!"</p>
                        <p class="font-semibold text-theme-accent">- Commander Eva Rostova</p>
                        <p class="text-sm text-theme-text/60">Deep Space Explorer</p>
                    </div>
                    <div class="testimonial-card border border-theme-border p-8 rounded-lg bg-theme-bg/50 backdrop-blur-sm">
                        <p class="text-lg italic text-theme-text/80 mb-4">"The Aura Synthesizer transformed my lunar habitat. The customer support was out of this world, literally! Highly recommend Antigravity products."</p>
                        <p class="font-semibold text-theme-accent">- Dr. Aris Thorne</p>
                        <p class="text-sm text-theme-text/60">Xenobotanist</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Footer --}}
    <footer class="bg-theme-bg/80 border-t border-theme-border py-8 mt-16">
        <div class="container mx-auto px-4 text-center text-sm text-theme-text/60">
            <p>&copy; {{ date('Y') }} Antigravity Ecommerce. All rights reserved.</p>
            <p class="mt-1">Designed by Jonadab Uroh and inspired by Trustfactory.</p>
        </div>
    </footer>

    @push('scripts')
        <script>
            gsap.registerPlugin(ScrollTrigger);

            document.addEventListener('DOMContentLoaded', () => {
                // Animate hero section
                gsap.from("#hero-title", { duration: 1.2, y: 40, opacity: 0, ease: "power4.out" });
                gsap.from("#hero-subtitle", { duration: 1.2, y: 20, opacity: 0, ease: "power4.out", delay: 0.2 });
                gsap.from("#hero-cta", { duration: 1.2, y: 10, opacity: 0, ease: "power4.out", delay: 0.4 });

                // Animate feature section on scroll
                gsap.from(".feature-item", {
                    scrollTrigger: {
                        trigger: "#feature-section",
                        start: "top 80%",
                        end: "bottom top",
                        toggleActions: "play none none none"
                    },
                    duration: 1,
                    y: 60,
                    opacity: 0,
                    stagger: 0.2,
                    ease: "power4.out"
                });

                // Animate vision section on scroll
                gsap.from("#vision-section h2, #vision-section p", {
                    scrollTrigger: {
                        trigger: "#vision-section",
                        start: "top 80%",
                        toggleActions: "play none none none"
                    },
                    duration: 1,
                    y: 50,
                    opacity: 0,
                    stagger: 0.2,
                    ease: "power4.out"
                });

                // Animate featured products section on scroll
                gsap.from(".product-card", {
                    scrollTrigger: {
                        trigger: "#featured-products-section",
                        start: "top 80%",
                        toggleActions: "play none none none"
                    },
                    duration: 1,
                    y: 50,
                    stagger: 0.15,
                    ease: "power4.out"
                });

                // Animate testimonials section on scroll
                gsap.from(".testimonial-card", {
                    scrollTrigger: {
                        trigger: "#testimonials-section",
                        start: "top 80%",
                        toggleActions: "play none none none"
                    },
                    duration: 1,
                    y: 50,
                    opacity: 0,
                    stagger: 0.2,
                    ease: "power4.out"
                });
            });
        </script>
    @endpush
</x-app-layout>