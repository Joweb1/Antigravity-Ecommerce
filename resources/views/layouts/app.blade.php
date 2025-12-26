<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Antigravity Store') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;700;900&family=Orbitron:wght@400;700;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@studio-freight/lenis@1.0.42/dist/lenis.min.js"></script>

    <style>
        .grain {
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 400 400' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)' opacity='1'/%3E%3C/svg%3E");
        }
    </style>
</head>
<body class="bg-theme-bg text-theme-text font-sans antialiased selection:bg-theme-accent selection:text-white overflow-x-hidden">

    <!-- 1. Grain Overlay -->
    <!--
    <div class="grain fixed inset-0 z-50 opacity-[0.03] mix-blend-overlay" style="pointer-events: none;"></div>
    -->

    <!-- 2. Ambient Glow -->
    <!--
    <div class="fixed top-[-20%] left-[-10%] w-[50vw] h-[50vw] bg-theme-accent/10 blur-[120px] rounded-full pointer-events-none z-0"></div>
    -->

    <!-- 3. Custom Cursor (Alpine) -->
    <!--
    <div x-data="{
        x: 0, 
        y: 0,
        init() {
            window.addEventListener('mousemove', (e) => {
                this.x = e.clientX;
                this.y = e.clientY;
                gsap.to(this.$refs.dot, { x: this.x, y: this.y, duration: 0.1 });
                gsap.to(this.$refs.ring, { x: this.x, y: this.y, duration: 0.5, ease: 'power2.out' });
            });
        }
    }" class="fixed inset-0 pointer-events-none z-[9999]">
        <div x-ref="dot" class="fixed top-0 left-0 w-1.5 h-1.5 bg-theme-accent rounded-full -translate-x-1/2 -translate-y-1/2"></div>
        <div x-ref="ring" class="fixed top-0 left-0 w-8 h-8 border border-white/20 rounded-full -translate-x-1/2 -translate-y-1/2"></div>
    </div>
    -->

    <!-- 4. Navigation (HUD) -->
    <nav class="fixed top-0 w-full z-40 border-b border-white/5 bg-theme-bg/80 backdrop-blur-md">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <a href="{{ route('home') }}" class="text-2xl font-black uppercase tracking-tighter" wire:navigate>
                ANTI<span class="text-theme-accent">GRAVITY</span>
            </a>
            <div class="flex items-center gap-8">
                <a href="{{ route('shop') }}" wire:navigate class="text-[10px] uppercase tracking-widest font-bold hover:text-theme-accent transition flex items-center space-x-1">
                    <span class="material-icons-outlined text-base">storefront</span>
                    <span>Shop</span>
                </a>
                <livewire:cart-counter /> <!-- Create this component -->
                @auth
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="hover:opacity-80 transition">
                            <span class="p-2 bg-theme-bg/30 backdrop-blur-sm rounded-full border border-theme-border">
                                <span class="material-icons-outlined text-base">person</span>
                            </span>
                        </button>
                        <livewire:profile-dropdown />
                    </div>
                @else
                    <a href="{{ route('login') }}" wire:navigate class="hover:opacity-80 transition">
                        <span class="p-2 bg-theme-bg/30 backdrop-blur-sm rounded-full border border-theme-border">
                            <span class="material-icons-outlined text-base">login</span>
                        </span>
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- 5. Main Content -->
    <main class="relative z-10 pt-24 min-h-screen">
        {{ $slot }}
    </main>

    {{-- <livewire:cart-slide-over /> --}}

    <!-- Product Display Modal -->
    <x-product-modal />

    <!-- 6. Lenis Init -->
    <!--
    <script>
        const lenis = new Lenis();
        function raf(time) {
            lenis.raf(time);
            requestAnimationFrame(raf);
        }
        requestAnimationFrame(raf);
    </script>
    -->

    @stack('scripts')
</body>
</html>