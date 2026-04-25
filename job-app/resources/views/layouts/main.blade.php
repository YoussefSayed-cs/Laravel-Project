<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Shagalni - Find Your Dream Job' }}</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><rect width=%22100%22 height=%22100%22 rx=%2220%22 fill=%22%234f46e5%22></rect><text x=%2250%22 y=%2270%22 font-size=%2265%22 font-family=%22Arial, sans-serif%22 font-weight=%22bold%22 text-anchor=%22middle%22 fill=%22white%22>S</text></svg>">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Alpine.js Cloak -->
    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, h5, h6, .font-heading { font-family: 'Outfit', sans-serif; }
        
        .glass-nav {
            background: rgba(11, 15, 25, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .glass-card {
            background: rgba(30, 41, 59, 0.5);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
        }

        .bg-mesh {
            background-color: #0B0F19;
            background-image: 
                radial-gradient(at 40% 20%, hsla(250,100%,74%,0.08) 0px, transparent 50%),
                radial-gradient(at 80% 0%, hsla(189,100%,56%,0.08) 0px, transparent 50%),
                radial-gradient(at 0% 50%, hsla(340,100%,76%,0.08) 0px, transparent 50%);
        }
    </style>

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-mesh text-slate-300 min-h-screen selection:bg-brand-500 selection:text-white antialiased">

    <!-- Navbar -->
    <nav class="fixed w-full z-50 glass-nav transition-all duration-300" x-data="{ scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 20)">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center gap-2 cursor-pointer">
                    <div class="w-10 h-10 bg-gradient-to-br from-brand-500 to-indigo-600 rounded-xl flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-brand-500/20">
                        S
                    </div>
                    <span class="font-heading font-bold text-2xl tracking-tight text-white">Shagalni</span>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#" class="text-sm font-medium text-slate-300 hover:text-white transition-colors">Find Jobs</a>
                    <a href="#" class="text-sm font-medium text-slate-300 hover:text-white transition-colors">Companies</a>
                    <a href="#" class="text-sm font-medium text-slate-300 hover:text-white transition-colors">Salaries</a>
                </div>

                <!-- Auth Buttons -->
                <div class="hidden md:flex items-center space-x-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm font-medium text-slate-300 hover:text-white transition-colors">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-slate-300 hover:text-white transition-colors">Log in</a>
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-semibold text-white transition-all duration-200 bg-brand-600 rounded-xl hover:bg-brand-500 hover:shadow-md hover:shadow-brand-500/20 hover:-translate-y-0.5">
                            Sign up
                        </a>
                    @endauth
                    <div class="h-6 w-px bg-slate-700 mx-2"></div>
                    <a href="#" class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-semibold text-white transition-all duration-200 bg-slate-800 rounded-xl hover:bg-slate-700 border border-slate-700">
                        Employers / Post Job
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="relative z-10 pt-20">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="border-t border-slate-800/60 py-16 mt-20 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
                <div class="col-span-1 md:col-span-1">
                    <div class="flex items-center gap-2 mb-6">
                        <div class="w-8 h-8 bg-gradient-to-br from-brand-500 to-indigo-600 rounded-lg flex items-center justify-center text-white font-bold shadow-md shadow-brand-500/20">
                            S
                        </div>
                        <span class="font-heading font-bold text-xl text-white">Shagalni</span>
                    </div>
                    <p class="text-slate-400 text-sm mb-6 leading-relaxed">
                        The most professional way to find your next career opportunity or discover top talent.
                    </p>
                </div>
                <div>
                    <h3 class="font-heading font-semibold text-white mb-4">Candidates</h3>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-sm text-slate-400 hover:text-brand-400 transition">Browse Jobs</a></li>
                        <li><a href="#" class="text-sm text-slate-400 hover:text-brand-400 transition">Browse Companies</a></li>
                        <li><a href="#" class="text-sm text-slate-400 hover:text-brand-400 transition">Career Advice</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-heading font-semibold text-white mb-4">Employers</h3>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-sm text-slate-400 hover:text-brand-400 transition">Post a Job</a></li>
                        <li><a href="#" class="text-sm text-slate-400 hover:text-brand-400 transition">Pricing</a></li>
                        <li><a href="#" class="text-sm text-slate-400 hover:text-brand-400 transition">Resources</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-heading font-semibold text-white mb-4">Company</h3>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-sm text-slate-400 hover:text-brand-400 transition">About Us</a></li>
                        <li><a href="#" class="text-sm text-slate-400 hover:text-brand-400 transition">Contact</a></li>
                        <li><a href="#" class="text-sm text-slate-400 hover:text-brand-400 transition">Privacy Policy</a></li>
                    </ul>
                </div>
            </div>
            <div class="mt-16 pt-8 border-t border-slate-800/60 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-slate-500 text-sm">© {{ date('Y') }} Shagalni. All rights reserved.</p>
                <div class="flex space-x-4">
                    <div class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center text-slate-400 hover:bg-brand-500 hover:text-white cursor-pointer transition">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center text-slate-400 hover:bg-brand-500 hover:text-white cursor-pointer transition">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                    </div>
                </div>
            </div>
        </div>
    </footer>

</body>
</html> 