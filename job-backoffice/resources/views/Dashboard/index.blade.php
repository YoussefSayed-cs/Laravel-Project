<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="font-black text-3xl text-slate-900 tracking-tight">
                    Dashboard Overview
                </h2>
                <p class="text-sm text-slate-500 mt-1 font-medium">Welcome back! Here is your platform's latest performance data.</p>
            </div>
            <div class="flex items-center gap-3 bg-white px-4 py-2 rounded-xl shadow-sm border border-slate-100">
                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <span class="text-sm font-semibold text-slate-700">{{ now()->format('l, F j, Y') }}</span>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto py-8 sm:px-6 lg:px-8 space-y-8">
        {{-- ================= STATS CARDS ================= --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 animate-fade-in-up">

            {{-- Stat Card 1 --}}
            <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300 group">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center group-hover:scale-110 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300 shadow-sm">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full border border-emerald-100">+12%</span>
                </div>
                <h3 class="text-slate-500 text-sm font-semibold uppercase tracking-wider">Total Users</h3>
                <p class="text-4xl font-black text-slate-800 mt-2">{{ number_format($analytics['activeUsers']) }}</p>
            </div>

            {{-- Stat Card 2 --}}
            <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300 group">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center group-hover:scale-110 group-hover:bg-purple-600 group-hover:text-white transition-all duration-300 shadow-sm">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                </div>
                <h3 class="text-slate-500 text-sm font-semibold uppercase tracking-wider">Total Jobs</h3>
                <p class="text-4xl font-black text-slate-800 mt-2">{{ number_format($analytics['totalJob']) }}</p>
            </div>

            {{-- Stat Card 3 --}}
            <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300 group">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 rounded-2xl bg-amber-50 text-amber-500 flex items-center justify-center group-hover:scale-110 group-hover:bg-amber-500 group-hover:text-white transition-all duration-300 shadow-sm">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full border border-emerald-100">+5%</span>
                </div>
                <h3 class="text-slate-500 text-sm font-semibold uppercase tracking-wider">Applications</h3>
                <p class="text-4xl font-black text-slate-800 mt-2">{{ number_format($analytics['totalapplications']) }}</p>
            </div>

            {{-- Stat Card 4 --}}
            <div class="relative overflow-hidden bg-gradient-to-br from-indigo-600 via-blue-600 to-cyan-500 rounded-2xl p-6 shadow-md hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group">
                <!-- Decorative elements -->
                <div class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 rounded-full bg-white opacity-10 blur-2xl"></div>
                <div class="absolute bottom-0 left-0 -ml-8 -mb-8 w-24 h-24 rounded-full bg-white opacity-10 blur-xl"></div>
                
                <div class="relative z-10 flex items-center justify-between mb-4">
                    <div class="w-14 h-14 rounded-2xl bg-white/20 backdrop-blur-sm text-white flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                </div>
                <h3 class="relative z-10 text-blue-100 text-sm font-semibold uppercase tracking-wider">System Health</h3>
                <p class="relative z-10 text-4xl font-black text-white mt-2">98%</p>
            </div>
        </div>

        {{-- ================= CHARTS SECTION ================= --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 animate-fade-in-up" style="animation-delay: 0.1s;">

            {{-- Overview Chart --}}
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100 min-h-[400px] flex flex-col">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-xl font-bold text-slate-800">System Overview</h3>
                        <p class="text-sm text-slate-500 mt-1">Platform metrics at a glance</p>
                    </div>
                    <div class="p-2 bg-slate-50 rounded-lg">
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    </div>
                </div>
                <div class="relative flex-grow w-full">
                    <canvas id="overviewChart"></canvas>
                </div>
            </div>

            {{-- Conversion Rates Chart --}}
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100 min-h-[400px] flex flex-col">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-xl font-bold text-slate-800">Conversion Rates</h3>
                        <p class="text-sm text-slate-500 mt-1">Application to views ratio per job</p>
                    </div>
                    <div class="p-2 bg-slate-50 rounded-lg">
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path></svg>
                    </div>
                </div>
                <div class="relative flex-grow w-full flex items-center justify-center">
                    <div class="h-64 w-full">
                        <canvas id="conversionChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- ================= TABLE SECTION ================= --}}
        <div class="animate-fade-in-up" style="animation-delay: 0.2s;">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                    <div>
                        <h3 class="text-xl font-bold text-slate-800">Most Popular Jobs</h3>
                        <p class="text-sm text-slate-500 mt-1">Jobs receiving the highest volume of applications</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full whitespace-nowrap">
                        <thead class="bg-slate-50 border-b border-slate-100">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Rank & Job Title</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Company</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Job Type</th>
                                <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Total Applicants</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @forelse($analytics['mostAppliedJobs'] as $index => $job)
                                <tr class="hover:bg-indigo-50/30 transition-colors group">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 flex items-center justify-center rounded-full font-bold text-sm
                                                @if($index == 0) bg-amber-100 text-amber-600 
                                                @elseif($index == 1) bg-slate-100 text-slate-500 
                                                @elseif($index == 2) bg-orange-100 text-orange-600 
                                                @else bg-slate-50 text-slate-400 @endif">
                                                #{{ $index + 1 }}
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-bold text-slate-900 group-hover:text-indigo-600 transition-colors">
                                                    {{ $job->title }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-slate-600 font-medium">{{ $job->company->name ?? '—' }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-700">
                                            {{ $job->type }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <span class="inline-flex items-center justify-center min-w-[2.5rem] px-2.5 py-1 rounded-lg text-sm font-bold bg-indigo-50 text-indigo-700 border border-indigo-100 group-hover:bg-indigo-100 transition-colors">
                                            {{ number_format($job->totalCount) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center">
                                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 text-slate-400 mb-4">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                        </div>
                                        <p class="text-slate-500 font-medium">No application data available yet.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- ================= SCRIPTS ================= --}}

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Data prep for conversion chart
        let conversionLabels = {!! json_encode($analytics['conversionRates']->pluck('title')) !!};
        let conversionData = {!! json_encode($analytics['conversionRates']->pluck('conversionRates')) !!};
        
        let conversionColors = [
            'rgba(16, 185, 129, 0.9)', // Emerald
            'rgba(59, 130, 246, 0.9)', // Blue
            'rgba(245, 158, 11, 0.9)', // Amber
            'rgba(236, 72, 153, 0.9)', // Pink
            'rgba(139, 92, 246, 0.9)'  // Violet
        ];
        
        let allZero = conversionData.length === 0 || conversionData.every(val => parseFloat(val) === 0);
        let tooltipCallback = function(context) { return ' ' + context.label + ': ' + context.raw + '%'; };

        if (allZero) {
            conversionLabels = conversionLabels.length > 0 ? conversionLabels : ['No Data'];
            conversionData = conversionLabels.map(() => 1);
            if(conversionLabels[0] === 'No Data') {
                conversionColors = ['#f1f5f9'];
            }
            tooltipCallback = function(context) {
                return ' ' + context.label + ': 0%';
            };
        }

        // --- Overview Bar Chart ---
        const ctxOverview = document.getElementById('overviewChart');
        new Chart(ctxOverview, {
            type: 'bar',
            data: {
                labels: ['Total Users', 'Vacancies', 'Applications'],
                datasets: [{
                    label: 'Total Count',
                    data: [
                        Number("{{ $analytics['activeUsers'] }}"),
                        Number("{{ $analytics['totalJob'] }}"),
                        Number("{{ $analytics['totalapplications'] }}")
                    ],
                    backgroundColor: [
                        'rgba(99, 102, 241, 0.9)', // Indigo
                        'rgba(168, 85, 247, 0.9)', // Purple
                        'rgba(249, 115, 22, 0.9)', // Orange
                    ],
                    borderWidth: 0,
                    borderRadius: 6,
                    barThickness: 45,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(15, 23, 42, 0.9)',
                        padding: 12,
                        cornerRadius: 8,
                        titleFont: { family: 'Inter', size: 13, weight: 'bold' },
                        bodyFont: { family: 'Inter', size: 14 }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f8fafc',
                            drawBorder: false,
                        },
                        ticks: {
                            font: { family: 'Inter', size: 12 },
                            color: '#94a3b8',
                            padding: 10
                        }
                    },
                    x: {
                        grid: { display: false, drawBorder: false },
                        ticks: {
                            font: { family: 'Inter', weight: 600, size: 13 },
                            color: '#64748b',
                            padding: 10
                        }
                    }
                },
                animation: { duration: 1500, easing: 'easeOutQuart' }
            }
        });

        // --- Conversion Doughnut Chart ---
        const ctxConversion = document.getElementById('conversionChart');
        new Chart(ctxConversion, {
            type: 'doughnut',
            data: {
                labels: conversionLabels,
                datasets: [{
                    data: conversionData,
                    backgroundColor: conversionColors,
                    borderColor: '#ffffff',
                    borderWidth: 3,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            font: { family: 'Inter', size: 13, weight: '500' },
                            color: '#475569',
                            usePointStyle: true,
                            padding: 20,
                            boxWidth: 8
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(15, 23, 42, 0.9)',
                        padding: 12,
                        cornerRadius: 8,
                        bodyFont: { family: 'Inter', size: 14 },
                        callbacks: {
                            label: tooltipCallback
                        }
                    }
                },
                animation: { duration: 1500, easing: 'easeOutQuart', delay: 200 }
            }
        });
    </script>
</x-app-layout>
