<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Job Applications {{ request()->input('archived') == 'true' ? '(Archived)' : '' }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">

        <x-toast-notification />

        <!-- Toggle Archived / Active -->
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-2xl font-bold text-slate-800">
                Job Applications
                @if(request()->input('archived') == 'true')
                    <span class="text-sm font-medium px-2.5 py-1 rounded-full bg-slate-100 text-slate-600 align-middle ml-2">Archived</span>
                @endif
            </h3>
            
            @if (request()->input('archived') == 'true')
                <a href="{{ route('job-applications.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-indigo-50 text-indigo-700 font-medium rounded-lg hover:bg-indigo-100 transition-colors duration-200">
                   <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Active Applications
                </a>
            @else
                <a href="{{ route('job-applications.index', ['archived' => 'true']) }}"
                   class="inline-flex items-center px-4 py-2 border border-slate-200 text-slate-600 font-medium rounded-lg hover:bg-slate-50 transition-colors duration-200">
                   <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                    View Archives
                </a>
            @endif
        </div>

        <!-- Applications Table -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Applicant</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Position</th>
                        @if(auth()->user()->role === 'admin')
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Company</th>
                        @endif
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse ($job_applications as $application)
                        <tr class="hover:bg-slate-50 transition-colors duration-150">
                            <!-- Applicant -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 flex-shrink-0 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold">
                                        {{ substr($application->Owner?->name ?? 'U', 0, 1) }}
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-slate-900">
                                            <a class="hover:text-indigo-600 transition-colors" href="{{ route('job-applications.show', $application->id) }}">
                                                {{ $application->Owner?->name ?? 'Unknown User' }}
                                            </a>
                                        </div>
                                        <div class="text-sm text-slate-500">{{ $application->Owner?->email ?? '—' }}</div>
                                    </div>
                                </div>
                            </td>

                            <!-- Job Vacancy -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-slate-900 font-medium">{{ $application->JobVacancy?->title ?? 'N/A' }}</div>
                                <div class="text-xs text-slate-500 mt-1">Applied {{ $application->created_at->diffForHumans() }}</div>
                            </td>

                            <!-- Company (admin only) -->
                            @if(auth()->user()->role === 'admin')
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                                    {{ $application->JobVacancy?->company?->name ?? 'N/A' }}
                                </td>
                            @endif

                            <!-- Status -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium capitalize
                                    @if($application->status === 'accepted') bg-emerald-100 text-emerald-800
                                    @elseif($application->status === 'rejected') bg-red-100 text-red-800
                                    @else bg-amber-100 text-amber-800
                                    @endif">
                                    @if($application->status === 'accepted')
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    @elseif($application->status === 'rejected')
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    @else
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    @endif
                                    {{ $application->status }}
                                </span>
                            </td>

                            <!-- Actions -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-4">
                                    @if(request()->input('archived') == 'true')
                                        <!-- Restore Button -->
                                        <form action="{{ route('job-applications.restore', $application->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="text-emerald-600 hover:text-emerald-900 transition-colors flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                                Restore
                                            </button>
                                        </form>
                                    @else
                                        <!-- Edit Button -->
                                        <a href="{{ route('job-applications.edit', $application->id) }}"
                                           class="text-indigo-600 hover:text-indigo-900 transition-colors">Edit</a>

                                        <!-- Archive Button -->
                                        <form action="{{ route('job-applications.destroy', $application->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-slate-400 hover:text-red-600 transition-colors">
                                                Archive
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ auth()->user()->role === 'admin' ? 5 : 4 }}" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    <p class="text-slate-500 text-lg font-medium">No Applications Found</p>
                                    <p class="text-slate-400 text-sm mt-1">There are no job applications to display at the moment.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $job_applications->links() }}
        </div>

    </div>
</x-app-layout>
