<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Shaglani – Back Office</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=Outfit:wght@300;400;500&display=swap" rel="stylesheet" />
    <style>
        body { font-family: 'Outfit', sans-serif; }
        .font-cormorant { font-family: 'Cormorant Garamond', serif; }
        .orb-purple {
            position: absolute; top: -60px; left: -60px;
            width: 280px; height: 280px; border-radius: 9999px;
            background: radial-gradient(circle, rgba(99,102,241,0.22) 0%, transparent 70%);
            pointer-events: none;
        }
        .orb-violet {
            position: absolute; bottom: -40px; right: -40px;
            width: 220px; height: 220px; border-radius: 9999px;
            background: radial-gradient(circle, rgba(139,92,246,0.14) 0%, transparent 70%);
            pointer-events: none;
        }
        .divider-line {
            background: linear-gradient(to bottom, transparent, #e2e8f0 30%, #e2e8f0 70%, transparent);
        }
    </style>
</head>
<body class="min-h-screen flex">

    {{-- ═══════════════════════════════════════════
         LEFT PANEL — Branding
    ═══════════════════════════════════════════ --}}
    <div class="relative hidden lg:flex lg:w-[42%] bg-[#0c0f1a] flex-col justify-between p-12 overflow-hidden">

        <div class="orb-purple"></div>
        <div class="orb-violet"></div>

        {{-- Brand --}}
        <div class="flex items-center gap-3 z-10 relative">
            <div class="w-[38px] h-[38px] rounded-[10px] bg-gradient-to-br from-indigo-500 to-violet-500 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 fill-white" viewBox="0 0 24 24">
                    <path d="M20 6H4a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2zM4 8h16v2H4V8zm0 4h6v2H4v-2zm8 0h8v2h-8v-2z"/>
                </svg>
            </div>
            <span class="font-cormorant text-2xl font-semibold text-slate-100 tracking-wide">Shaglani</span>
        </div>

        {{-- Hero --}}
        <div class="z-10 relative">
            <div class="flex items-center gap-2 mb-4">
                <span class="block w-6 h-px bg-indigo-500"></span>
                <span class="text-[10px] font-normal tracking-[0.25em] uppercase text-indigo-400">Back Office</span>
            </div>
            <h1 class="font-cormorant text-[42px] leading-[1.15] text-slate-50 font-normal mb-4">
                Your Control<br>
                <em class="italic text-indigo-300">Center </em> Awaits
            </h1>
            <p class="text-[13px] text-slate-500 leading-[1.75] font-light max-w-[260px]">
                Manage jobs, companies, and the full hiring pipeline — securely and efficiently.
            </p>
        </div>

        {{-- Footer --}}
        <p class="text-[10px] text-slate-800 z-10 relative tracking-wider">
            © {{ date('Y') }} Shaglani · Restricted Access
        </p>
    </div>

    {{-- ═══════════════════════════════════════════
         RIGHT PANEL — Form
    ═══════════════════════════════════════════ --}}
    <div class="flex-1 bg-[#fafafa] flex items-center justify-center px-8 py-12 lg:px-14 relative">

        {{-- Vertical divider (desktop only) --}}
        <div class="divider-line absolute top-0 left-0 bottom-0 w-px hidden lg:block"></div>

        <div class="w-full max-w-[360px]">

            {{-- Header --}}
            <div class="mb-9">
                <h2 class="font-cormorant text-[32px] font-semibold text-slate-900 mb-1">Welcome back</h2>
                <p class="text-[13px] text-slate-400 font-light">Sign in with your authorized credentials</p>
            </div>

            {{-- Session Status --}}
            @if (session('status'))
                <div class="mb-6 text-sm text-green-600 bg-green-50 border border-green-200 rounded-xl px-4 py-3">
                    {{ session('status') }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-[18px]">
                @csrf

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-[10.5px] font-medium text-slate-500 mb-2 tracking-[0.18em] uppercase">
                        Email Address
                    </label>
                    <div class="relative">
                        <input
                            id="email"
                            name="email"
                            type="email"
                            autocomplete="email"
                            required
                            autofocus
                            value="{{ old('email') }}"
                            placeholder="Email"
                            class="w-full h-12 rounded-xl border border-slate-200 bg-white px-4 pr-11 text-sm text-slate-900 placeholder-slate-300 font-light outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 @error('email') border-red-400 focus:border-red-400 focus:ring-red-400/10 @enderror"
                        />
                        <span class="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-300 pointer-events-none">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <rect x="2" y="4" width="20" height="16" rx="2"/>
                                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                            </svg>
                        </span>
                    </div>
                    @error('email')
                        <p class="mt-1.5 text-xs text-red-500 ml-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div x-data="{ show: false }">
                    <label for="password" class="block text-[10.5px] font-medium text-slate-500 mb-2 tracking-[0.18em] uppercase">
                        Password
                    </label>
                    <div class="relative">
                        <input
                            id="password"
                            name="password"
                            :type="show ? 'text' : 'password'"
                            autocomplete="current-password"
                            required
                            placeholder="••••••••••"
                            class="w-full h-12 rounded-xl border border-slate-200 bg-white px-4 pr-11 text-sm text-slate-900 placeholder-slate-300 font-light outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 @error('password') border-red-400 focus:border-red-400 focus:ring-red-400/10 @enderror"
                        />
                        <button
                            type="button"
                            @click="show = !show"
                            class="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-300 hover:text-indigo-500 transition-colors z-10"
                        >
                            <svg x-show="!show" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                            <svg x-show="show" x-cloak class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/>
                                <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/>
                                <line x1="1" y1="1" x2="23" y2="23"/>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1.5 text-xs text-red-500 ml-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit --}}
                <div class="pt-2">
                    <button
                        type="submit"
                        class="group w-full h-[52px] rounded-xl font-medium text-[15px] tracking-wide
                               flex items-center justify-center gap-2.5
                               bg-indigo-600 text-white border-2 border-indigo-600
                               hover:bg-white hover:text-indigo-600
                               transition-all duration-200 active:scale-[0.98]"
                    >
                        Sign In
                        <svg class="w-4 h-4 transition-transform duration-200 group-hover:translate-x-1"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </button>
                </div>
            </form>

            {{-- Security badges --}}
            <div class="mt-8 pt-6 border-t border-slate-100">
                <div class="flex items-center justify-center gap-[18px]">
                    <div class="flex items-center gap-1.5 text-[10.5px] text-slate-400 font-light">
                        <svg class="w-3 h-3 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="#6366f1" stroke-width="2">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                        </svg>
                        256-bit SSL
                    </div>
                    <span class="w-px h-3 bg-slate-200"></span>
                    <div class="flex items-center gap-1.5 text-[10.5px] text-slate-400 font-light">
                        <svg class="w-3 h-3 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="#6366f1" stroke-width="2">
                            <rect x="3" y="11" width="18" height="11" rx="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                        2FA Ready
                    </div>
                    <span class="w-px h-3 bg-slate-200"></span>
                    <div class="flex items-center gap-1.5 text-[10.5px] text-slate-400 font-light">
                        <svg class="w-3 h-3 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="#6366f1" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <path d="M12 8v4l3 3"/>
                        </svg>
                        Auto Logout
                    </div>
                </div>
            </div>

        </div>
    </div>

</body>
</html>
