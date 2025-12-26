<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;700;900&family=Orbitron:wght@400;700;900&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-theme-text antialiased bg-theme-bg">
        <div class="relative min-h-screen">
            {{-- Home Button --}}
            <a href="{{ route('home') }}"
               class="absolute top-4 right-4 z-20 p-2 bg-theme-bg/50 backdrop-blur-sm rounded-full border border-theme-border text-theme-text hover:text-theme-accent transition"
               aria-label="Back to Home"
               wire:navigate>
                <span class="material-icons-outlined">close</span>
            </a>

            {{-- Floating Blur Background --}}
            <div class="absolute inset-0 z-0 opacity-50 overflow-hidden">
                <div class="blur-circle bg-purple-600 top-[-20%] left-[-5%] w-96 h-96 animate-float1"></div>
                <div class="blur-circle bg-blue-500 bottom-[-20%] right-[-5%] w-96 h-96 animate-float2" style="animation-delay: 3s;"></div>
                <div class="blur-circle bg-pink-500 top-[50%] left-[10%] w-72 h-72 animate-float3" style="animation-delay: 6s;"></div>
                <div class="blur-circle bg-teal-500 top-[10%] right-[15%] w-64 h-64 animate-float4" style="animation-delay: 9s;"></div>
                <div class="blur-circle bg-yellow-500 bottom-[5%] left-[30%] w-80 h-80 animate-float5" style="animation-delay: 12s;"></div>
            </div>
            
            {{-- Content Slot --}}
            <div class="relative z-10 min-h-screen flex flex-col justify-center items-center">
                 {{ $slot }}
            </div>
        </div>
    </body>
</html>