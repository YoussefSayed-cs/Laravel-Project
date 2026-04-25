<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Shagalni') }} - Authentication</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><rect width=%22100%22 height=%22100%22 rx=%2220%22 fill=%22%234f46e5%22></rect><text x=%2250%22 y=%2270%22 font-size=%2265%22 font-family=%22Arial, sans-serif%22 font-weight=%22bold%22 text-anchor=%22middle%22 fill=%22white%22>S</text></svg>">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Alpine.js Cloak -->
    <style>
        [x-cloak] {
            display: none !important;
        }
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, h5, h6, .font-heading { font-family: 'Outfit', sans-serif; }
        
        .bg-mesh {
            background-color: #0B0F19;
            background-image: 
                radial-gradient(at 40% 20%, hsla(250,100%,74%,0.08) 0px, transparent 50%),
                radial-gradient(at 80% 0%, hsla(189,100%,56%,0.08) 0px, transparent 50%),
                radial-gradient(at 0% 50%, hsla(340,100%,76%,0.08) 0px, transparent 50%);
        }
    </style>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-mesh text-slate-300 min-h-screen flex items-center justify-center relative overflow-hidden antialiased">
    
    <!-- Floating Background Shapes -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-[10%] left-[10%] w-[500px] h-[500px] bg-brand-500/10 rounded-full blur-3xl opacity-50"></div>
        <div class="absolute bottom-[20%] right-[10%] w-[400px] h-[400px] bg-indigo-500/10 rounded-full blur-3xl opacity-50"></div>
    </div>

    <!-- Main Content Container -->
    <div class="relative z-10 w-full min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0"
        x-data="{ show: false }" x-init="setTimeout(() => show = true, 100)">
        
        <!-- Back to Home Link -->
        <div class="absolute top-8 left-8" x-cloak x-show="show" x-transition:enter="transition ease-out duration-700"
            x-transition:enter-start="opacity-0 -translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
            <a href="/" class="flex items-center gap-2 text-slate-400 hover:text-white transition-colors group">
                <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                <span class="text-sm font-medium">Back to Home</span>
            </a>
        </div>

        <!-- Application Logo -->
        <div class="mb-8" x-cloak x-show="show" x-transition:enter="transition ease-out duration-700"
            x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
            <a href="/" class="flex flex-col items-center gap-3">
                <div class="w-14 h-14 bg-gradient-to-br from-brand-500 to-indigo-600 rounded-2xl flex items-center justify-center text-white font-bold text-3xl shadow-lg shadow-brand-500/20">
                    S
                </div>
                <span class="font-heading font-bold text-2xl tracking-tight text-white">Shagalni</span>
            </a>
        </div>

        <!-- Content Card -->
        <div x-cloak x-show="show" x-transition:enter="transition ease-out duration-700 delay-100"
            x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0"
            class="w-full sm:max-w-md px-8 py-10 bg-slate-800/40 backdrop-blur-xl border border-slate-700/50 rounded-3xl shadow-2xl transition-all duration-300">
            {{ $slot }}
        </div>
        
        <div class="mt-8 text-center" x-cloak x-show="show" x-transition:enter="transition ease-out duration-700 delay-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
            <p class="text-sm text-slate-500">&copy; {{ date('Y') }} Shagalni. All rights reserved.</p>
        </div>
    </div>
</body>

</html>