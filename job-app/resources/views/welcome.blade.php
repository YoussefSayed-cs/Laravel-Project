<x-main-layout>
    <!-- Hero Section -->
    <div class="relative pt-24 pb-20 lg:pt-36 lg:pb-28 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-4xl mx-auto">
                <div x-data="{ show: false }" x-init="setTimeout(() => show = true, 100)">
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-brand-500/10 border border-brand-500/20 text-brand-400 text-sm font-semibold mb-8 shadow-sm backdrop-blur-md"
                         x-cloak x-show="show" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                        <span class="relative flex h-2.5 w-2.5">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-brand-400 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-brand-500"></span>
                        </span>
                        Over 10,000+ jobs added this week
                    </div>
                </div>

                <div x-data="{ show: false }" x-init="setTimeout(() => show = true, 200)">
                    <h1 class="font-heading text-5xl md:text-6xl lg:text-7xl font-extrabold text-white tracking-tight leading-tight mb-6"
                        x-cloak x-show="show" x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0">
                        Find the perfect job that <br class="hidden md:block">
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-400 to-indigo-400">matches your skills.</span>
                    </h1>
                </div>

                <div x-data="{ show: false }" x-init="setTimeout(() => show = true, 300)">
                    <p class="text-lg md:text-xl text-slate-400 mb-10 max-w-2xl mx-auto"
                       x-cloak x-show="show" x-transition:enter="transition ease-out duration-700 delay-100" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                        Connect with top-tier employers, showcase your unique talent, and land the career opportunity you've been dreaming of.
                    </p>
                </div>


            </div>
        </div>
    </div>

    <!-- Trusted By -->
    <div class="border-y border-slate-800/50 bg-transparent py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <p class="text-center text-sm font-semibold text-slate-500 tracking-wider uppercase mb-8">Trusted by innovative companies worldwide</p>
            <div class="flex flex-wrap justify-center gap-12 md:gap-20 opacity-50 grayscale hover:grayscale-0 transition duration-500">
                @forelse($companies as $company)
                    <div class="font-heading font-black text-2xl flex items-center gap-2 text-slate-400">
                        <div class="w-6 h-6 bg-slate-400 rounded-sm"></div> {{ $company->name }}
                    </div>
                @empty
                    <div class="font-heading font-black text-2xl flex items-center gap-2 text-slate-400"><div class="w-6 h-6 bg-slate-400 rounded-sm"></div> ACME Corp</div>
                    <div class="font-heading font-black text-2xl flex items-center gap-2 text-slate-400"><div class="w-6 h-6 bg-slate-400 rounded-full"></div> Globex</div>
                    <div class="font-heading font-black text-2xl flex items-center gap-2 text-slate-400"><div class="w-6 h-6 bg-slate-400 rounded-tl-lg rounded-br-lg"></div> Initech</div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- How it works -->
    <div class="py-24 bg-[#0B0F19]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="font-heading text-3xl md:text-4xl font-bold text-white mb-4">How Shagalni Works</h2>
                <p class="text-slate-400 max-w-2xl mx-auto">Get hired in three simple steps. We've made it easier than ever to find the right opportunity for your career.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Step 1 -->
                <div class="bg-slate-800/30 p-8 rounded-3xl shadow-sm border border-slate-700/50 text-center hover:shadow-xl hover:shadow-brand-500/5 hover:border-brand-500/30 transition-all duration-300 hover:-translate-y-1 backdrop-blur-sm">
                    <div class="w-16 h-16 bg-brand-500/10 text-brand-400 rounded-2xl flex items-center justify-center mx-auto mb-6 rotate-3">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <h3 class="font-heading text-xl font-bold text-white mb-3">Create an Account</h3>
                    <p class="text-slate-400">Sign up and complete your profile. Highlight your skills, experience, and what you're looking for.</p>
                </div>
                
                <!-- Step 2 -->
                <div class="bg-slate-800/30 p-8 rounded-3xl shadow-sm border border-slate-700/50 text-center hover:shadow-xl hover:shadow-indigo-500/5 hover:border-indigo-500/30 transition-all duration-300 hover:-translate-y-1 backdrop-blur-sm">
                    <div class="w-16 h-16 bg-indigo-500/10 text-indigo-400 rounded-2xl flex items-center justify-center mx-auto mb-6 -rotate-3">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="font-heading text-xl font-bold text-white mb-3">Search Jobs</h3>
                    <p class="text-slate-400">Browse thousands of open positions. Use our advanced filters to find the exact match for you.</p>
                </div>
                
                <!-- Step 3 -->
                <div class="bg-slate-800/30 p-8 rounded-3xl shadow-sm border border-slate-700/50 text-center hover:shadow-xl hover:shadow-purple-500/5 hover:border-purple-500/30 transition-all duration-300 hover:-translate-y-1 backdrop-blur-sm">
                    <div class="w-16 h-16 bg-purple-500/10 text-purple-400 rounded-2xl flex items-center justify-center mx-auto mb-6 rotate-3">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="font-heading text-xl font-bold text-white mb-3">Apply & Get Hired</h3>
                    <p class="text-slate-400">Apply with a single click. Connect directly with hiring managers and land your dream job.</p>
                </div>
            </div>
        </div>
    </div>
</x-main-layout>
