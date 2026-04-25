<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Shagalni - Dashboard</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><rect width=%22100%22 height=%22100%22 rx=%2220%22 fill=%22%234f46e5%22></rect><text x=%2250%22 y=%2270%22 font-size=%2265%22 font-family=%22Arial, sans-serif%22 font-weight=%22bold%22 text-anchor=%22middle%22 fill=%22white%22>S</text></svg>">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Styles -->
    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, h5, h6, .font-heading { font-family: 'Outfit', sans-serif; }
        
        .bg-mesh {
            background-color: #0B0F19;
            background-image: 
                radial-gradient(at 40% 20%, hsla(250,100%,74%,0.08) 0px, transparent 50%),
                radial-gradient(at 80% 0%, hsla(189,100%,56%,0.08) 0px, transparent 50%),
                radial-gradient(at 0% 50%, hsla(340,100%,76%,0.08) 0px, transparent 50%);
        }
        
        .glass-card {
            background: rgba(30, 41, 59, 0.5);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-mesh text-slate-300 overflow-x-hidden selection:bg-brand-500 selection:text-white antialiased">
    
    <!-- Background Gradient Blobs -->
    <div class="fixed inset-0 z-0 pointer-events-none overflow-hidden">
        <div class="absolute top-[-10%] left-[-10%] w-[500px] h-[500px] bg-brand-500/10 rounded-full blur-3xl opacity-50"></div>
        <div class="absolute bottom-[-10%] right-[10%] w-[400px] h-[400px] bg-indigo-500/10 rounded-full blur-3xl opacity-50"></div>
    </div>

    <!-- Content Wrapper -->
    <div class="relative z-10 min-h-screen flex flex-col">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="pt-28 pb-10 px-4 sm:px-6 lg:px-8">
                <div class="max-w-7xl mx-auto">
                    {{ $header }}
                </div>
            </header>
        @else
            <div class="pt-20"></div> {{-- Spacer if no header --}}
        @endisset

        <!-- Page Content -->
        <main class="flex-grow px-4 sm:px-6 lg:px-8 pb-12 animate-fade-in-up">
            <div class="max-w-7xl mx-auto">
                {{ $slot }}
            </div>
        </main>

        <!-- Modern Footer -->
        <footer class="border-t border-white/10 bg-black/50 backdrop-blur-sm py-12 mt-auto">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-6">
                
                <div class="text-center md:text-left">
                    <h3 class="text-xl font-bold bg-gradient-to-r from-white to-white/60 bg-clip-text text-transparent mb-2">
                        Shagalni
                    </h3>
                    <p class="text-sm text-white/40">
                        Connecting talent with opportunity.
                    </p>
                </div>

                <div class="flex gap-6 text-sm text-white/60">
                    <a href="#" class="hover:text-brand-400 transition-colors">Privacy Policy</a>
                    <a href="#" class="hover:text-brand-400 transition-colors">Terms of Service</a>
                    <a href="#" class="hover:text-brand-400 transition-colors">Contact</a>
                </div>

                <div class="text-sm text-white/30">
                    &copy; {{ date('Y') }} Shagalni. All rights reserved.
                </div>
            </div>
        </footer>
    </div>
</body>

</html>