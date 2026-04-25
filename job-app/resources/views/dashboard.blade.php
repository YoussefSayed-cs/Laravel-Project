<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl bg-gradient-to-r from-white to-white/60 bg-clip-text text-transparent leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="space-y-10">
        {{-- Welcome Header --}}
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-brand-900/50 to-indigo-900/50 border border-brand-500/20 p-8 md:p-12 shadow-2xl">
            <!-- Decorative Elements -->
            <div class="absolute -right-10 -top-10 w-64 h-64 bg-brand-500/20 rounded-full blur-3xl"></div>
            <div class="absolute -left-10 -bottom-10 w-64 h-64 bg-indigo-500/20 rounded-full blur-3xl"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8">
                <div>
                    <h3 class="font-heading text-3xl md:text-4xl font-bold text-white mb-3">
                        Welcome back, {{ Auth::user()->name }}!
                    </h3>
                    <p class="text-indigo-200 text-lg max-w-xl">
                        Explore the latest job opportunities tailored to your skill set and career aspirations.
                    </p>
                </div>
                <div class="flex items-center gap-4">
                    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-4 border border-white/10 text-center min-w-[120px]">
                        <p class="text-white/60 text-xs uppercase tracking-wider font-bold mb-1">Applied</p>
                        <p class="text-white text-2xl font-bold">12</p>
                    </div>
                    <div class="bg-brand-500/20 backdrop-blur-md rounded-2xl p-4 border border-brand-500/20 text-center min-w-[120px]">
                        <p class="text-brand-300 text-xs uppercase tracking-wider font-bold mb-1">Matching</p>
                        <p class="text-white text-2xl font-bold">45</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filters & Search Section --}}
        <div class="glass-card rounded-2xl p-6 shadow-xl border border-white/5">
            <div class="flex flex-col lg:flex-row gap-6 justify-between items-center">
                
                {{-- Search Bar --}}
                <form action="{{ route('dashboard') }}" method="GET" class="w-full lg:max-w-md">
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-slate-500 group-focus-within:text-brand-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                               class="block w-full pl-12 pr-4 py-3.5 bg-slate-900/50 border border-slate-700/50 rounded-xl text-white placeholder-slate-500 focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500/50 transition-all outline-none"
                               placeholder="Search job titles or keywords...">
                        
                        @if(request('filter'))
                            <input type="hidden" name="filter" value="{{ request('filter') }}">
                        @endif
                        
                        @if(request('search'))
                            <a href="{{ route('dashboard', ['filter' => request('filter')]) }}" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-500 hover:text-red-400 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </a>
                        @endif
                    </div>
                </form>

                {{-- Type Filters --}}
                <div class="flex items-center gap-2 overflow-x-auto pb-2 lg:pb-0 no-scrollbar">
                    @php
                        $filters = ['Full-Time', 'Remote', 'Hybrid'];
                        $activeClass = "bg-brand-600 text-white border-brand-500 shadow-lg shadow-brand-500/20";
                        $inactiveClass = "bg-slate-800/50 text-slate-400 border-slate-700/50 hover:border-slate-600 hover:text-white";
                    @endphp

                    @foreach($filters as $filter)
                        <a href="{{ route('dashboard', ['filter' => $filter, 'search' => request('search')]) }}"
                           class="whitespace-nowrap px-5 py-2.5 rounded-xl text-sm font-bold border transition-all duration-200 {{ request('filter') == $filter ? $activeClass : $inactiveClass }}">
                            {{ $filter }}
                        </a>
                    @endforeach

                    @if(request('filter'))
                        <a href="{{ route('dashboard', ['search' => request('search')]) }}"
                           class="flex items-center justify-center w-10 h-10 rounded-xl bg-red-500/10 border border-red-500/20 text-red-500 hover:bg-red-500 hover:text-white transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </a>
                    @endif
                </div>
            </div>
        </div>

        {{-- Jobs Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse ($jobs as $job)
                <div class="glass-card rounded-2xl p-6 transition-all duration-300 hover:bg-white/5 group border border-white/5 relative overflow-hidden">
                    <div class="absolute -right-16 -top-16 w-32 h-32 bg-brand-500/5 rounded-full blur-2xl group-hover:bg-brand-500/15 transition-all"></div>
                    
                    <div class="flex items-start justify-between mb-4 relative z-10">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 bg-slate-800 rounded-xl flex items-center justify-center text-brand-400 font-bold text-xl border border-slate-700/50 group-hover:border-brand-500/30 transition-colors uppercase">
                                {{ substr($job->company->name ?? 'C', 0, 1) }}
                            </div>
                            <div>
                                <a href="{{ route('job-vacancy.show', $job->id) }}" class="text-xl font-bold text-white group-hover:text-brand-300 transition-colors">
                                    {{ $job->title }}
                                </a>
                                <p class="text-slate-400 font-medium">{{ $job->company->name }}</p>
                            </div>
                        </div>
                        <span class="px-3 py-1 rounded-lg bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 text-xs font-bold uppercase tracking-wider">
                            {{ $job->type }}
                        </span>
                    </div>

                    <div class="flex flex-wrap items-center gap-4 text-sm text-slate-500 mb-6 relative z-10">
                        <span class="flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            {{ $job->location }}
                        </span>
                        <span class="flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            ${{ number_format($job->salary) }} / Year
                        </span>
                    </div>

                    <div class="flex items-center justify-between pt-4 border-t border-white/5 relative z-10">
                        <span class="text-xs text-slate-600 font-medium">Posted {{ $job->created_at->diffForHumans() }}</span>
                        <a href="{{ route('job-vacancy.show', $job->id) }}" class="text-sm font-bold text-brand-400 group-hover:text-brand-300 flex items-center gap-1">
                            Details
                            <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </div>
                </div>
            @empty
                <div class="md:col-span-2 text-center py-20 bg-slate-900/50 rounded-3xl border border-slate-800 border-dashed">
                    <div class="bg-slate-800/50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-2">No matches found</h3>
                    <p class="text-slate-500 max-w-sm mx-auto">We couldn't find any jobs matching your current search or filters. Try adjusting them!</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="mt-8">
            {{ $jobs->links() }}
        </div>
    </div>
</x-app-layout>