<x-app-layout>

    <x-slot name="header">
        <h2 class="font-bold text-2xl bg-gradient-to-r from-white to-white/60 bg-clip-text text-transparent leading-tight">
            Job Details
        </h2>
    </x-slot>

    <div class="space-y-6">
        <div class="glass-card rounded-2xl p-8 relative overflow-hidden">
            <!-- Decorative Glow -->
            <div class="absolute -right-20 -top-20 w-64 h-64 bg-brand-500/10 rounded-full blur-3xl"></div>

            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-brand-400 hover:text-brand-300 transition-colors mb-8 group">
                <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                <span class="text-sm font-semibold">Back to Jobs</span>
            </a>

            <div class="border-b border-white/10 pb-8 relative z-10">
                <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                    <div class="flex items-center gap-6">
                        <div class="w-20 h-20 bg-brand-500/10 rounded-2xl flex items-center justify-center text-brand-400 font-bold text-3xl uppercase border border-brand-500/20">
                            {{ substr($job_vacancy->company->name ?? 'C', 0, 1) }}
                        </div>
                        <div>
                            <h1 class="font-heading text-3xl md:text-4xl font-bold text-white mb-2">{{ $job_vacancy->title }}</h1>
                            <div class="flex flex-wrap items-center gap-4 text-slate-400">
                                <span class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                    {{ $job_vacancy->company->name }}
                                </span>
                                <span class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    {{ $job_vacancy->location }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="w-full md:w-auto flex-shrink-0">
                        <a href="{{ route('job-vacancy.apply', $job_vacancy->id) }}" class="inline-flex items-center justify-center w-full px-8 py-3.5 text-sm font-bold text-white bg-brand-600 rounded-xl hover:bg-brand-500 shadow-lg shadow-brand-500/20 hover:-translate-y-0.5 transition-all">
                            Apply Now
                        </a>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 mt-10 relative z-10">
                <!-- Left Side: Description -->
                <div class="lg:col-span-2 space-y-6">
                    <h2 class="font-heading text-xl font-bold text-white">Job Description</h2>
                    <div class="prose prose-invert prose-slate max-w-none">
                        <p class="text-slate-400 leading-relaxed whitespace-pre-line">{{ $job_vacancy->description }}</p>
                    </div>
                </div>

                <!-- Right Side: Overview -->
                <div class="lg:col-span-1">
                    <div class="bg-slate-800/30 rounded-2xl p-6 border border-slate-700/50 backdrop-blur-sm space-y-6">
                        <h2 class="font-heading text-lg font-bold text-white mb-2">Job Overview</h2>

                        <div class="space-y-4">
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-lg bg-indigo-500/10 flex items-center justify-center text-indigo-400 flex-shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-500 uppercase font-semibold tracking-wider">Published</p>
                                    <p class="text-white font-medium mt-0.5">{{ $job_vacancy->created_at->format('M d, Y') }}</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-lg bg-emerald-500/10 flex items-center justify-center text-emerald-400 flex-shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-500 uppercase font-semibold tracking-wider">Salary</p>
                                    <p class="text-white font-medium mt-0.5">{{ $job_vacancy->salary ? '$' . number_format($job_vacancy->salary) : 'Competitive' }}</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-lg bg-blue-500/10 flex items-center justify-center text-blue-400 flex-shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-500 uppercase font-semibold tracking-wider">Job Type</p>
                                    <p class="text-white font-medium mt-0.5">{{ $job_vacancy->tybe ?? 'Full-time' }}</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-lg bg-orange-500/10 flex items-center justify-center text-orange-400 flex-shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-500 uppercase font-semibold tracking-wider">Category</p>
                                    <p class="text-white font-medium mt-0.5">{{ $job_vacancy->job_category->name ?? 'Uncategorized' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>