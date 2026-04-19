<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ $company->name }}
        </h2>
    </x-slot>

    <div class="p-8">
        <x-toast-notification />

        <!-- Company Card -->
        <div class="bg-white shadow-lg rounded-lg p-8 mb-8 border-l-4 border-blue-500">
            <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-6">
                <div class="flex-1">
                    <h3 class="text-3xl font-bold mb-4 text-gray-900">{{ $company->name }}</h3>

                    <div class="space-y-3 mb-6">
                        @if($company->owner)
                        <p class="text-gray-700">
                            <span class="font-semibold text-gray-900">👤 Owner:</span>
                            <span class="text-gray-600">{{ $company->owner->name ?? '—' }}</span>
                        </p>
                        @endif
                        <p class="text-gray-700">
                            <span class="font-semibold text-gray-900">📍 Address:</span>
                            <span class="text-gray-600">{{ $company->address ?? '—' }}</span>
                        </p>
                        <p class="text-gray-700">
                            <span class="font-semibold text-gray-900">🏭 Industry:</span>
                            <span class="text-gray-600">{{ $company->industry ?? '—' }}</span>
                        </p>
                        @if($company->description)
                        <p class="text-gray-700">
                            <span class="font-semibold text-gray-900">📝 Description:</span>
                            <span class="text-gray-600 block mt-1">{{ $company->description }}</span>
                        </p>
                        @endif
                        <p class="text-gray-700">
                            <span class="font-semibold text-gray-900">🌐 Website:</span>
                            @if($company->website)
                                <a href="{{ $company->website }}" target="_blank" class="text-blue-600 hover:underline break-all">
                                    {{ $company->website }}
                                </a>
                            @else
                                <span class="text-gray-600">—</span>
                            @endif
                        </p>
                    </div>
                </div>

                <div class="flex flex-col gap-3 w-full md:w-auto">
                    @if (auth()->user()->role == 'company-owner')
                        <a href="{{ route('my-company.edit') }}"
                           class="px-5 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition font-semibold text-center">
                           ✏️ Edit
                        </a>
                    @else
                        <a href="{{ route('companies.edit', ['company' => $company->id, 'redirectToList' => 'false']) }}"
                           class="px-5 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition font-semibold text-center">
                           ✏️ Edit
                        </a>
                    @endif

                    @if (auth()->user()->role == 'admin')
                        <form action="{{ route('companies.destroy', $company->id) }}" method="POST" onsubmit="return confirm('Archive this company?');" class="w-full">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full px-5 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition font-semibold">
                                🗂️ Archive
                            </button>
                        </form>

                        <a href="{{ route('companies.index') }}"
                           class="px-5 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition font-semibold text-center">
                           ← Back
                        </a>
                    @endif
                </div>
            </div>
        </div>

        @if(auth()->user()->role == 'admin')
        <!-- Tabs -->
        <div class="mb-6 border-b border-gray-200">
            <ul class="flex gap-4">
                <li>
                    <a href="{{ route('companies.show', ['company' => $company->id, 'tab' => 'jobs']) }}"
                       class="inline-block py-3 px-4 font-semibold border-b-2 transition {{ (request('tab') == 'jobs' || request('tab') == '') ? 'text-blue-600 border-blue-600' : 'text-gray-600 border-transparent hover:text-gray-900' }}">
                        💼 Jobs ({{ ($company->jobVacancies ?? collect())->count() }})
                    </a>
                </li>
                <li>
                    <a href="{{ route('companies.show', ['company' => $company->id, 'tab' => 'applications']) }}"
                       class="inline-block py-3 px-4 font-semibold border-b-2 transition {{ request('tab') == 'applications' ? 'text-blue-600 border-blue-600' : 'text-gray-600 border-transparent hover:text-gray-900' }}">
                        📋 Applications ({{ ($company->applications ?? collect())->count() }})
                    </a>
                </li>
            </ul>
        </div>

        <!-- Tab Content -->
        <div>
            <!-- Jobs tab -->
            <div id="jobs" class="{{ (request('tab') == 'jobs' || request('tab') == '') ? 'block' : 'hidden' }}">
                <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Job Title</th>
                                    <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Type</th>
                                    <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Location</th>
                                    <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Salary</th>
                                    <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($company->jobVacancies ?? [] as $job)
                                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 text-sm font-semibold text-gray-900">
                                            <a href="{{ route('job-vacancies.show', $job->id) }}" class="text-blue-600 hover:text-blue-800 hover:underline">
                                                {{ $job->title }}
                                            </a>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-700">{{ $job->type ?? '—' }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-700">{{ $job->location ?? '—' }}</td>
                                        <td class="px-6 py-4 text-sm font-semibold text-green-600">{{ $job->salary ?? '—' }}</td>
                                        <td class="px-6 py-4 text-sm">
                                            <div class="flex gap-3">
                                                <a href="{{ route('job-vacancies.show', $job->id) }}" class="text-blue-600 hover:text-blue-800 font-semibold hover:underline">
                                                    👁️ View
                                                </a>
                                                <a href="{{ route('job-vacancies.edit', $job->id) }}" class="text-green-600 hover:text-green-800 font-semibold hover:underline">
                                                    ✏️ Edit
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                            <p class="text-lg font-semibold">No job vacancies found</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Applications tab -->
            <div id="applications" class="{{ request('tab') == 'applications' ? 'block' : 'hidden' }}">
                <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Applicant</th>
                                    <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Job</th>
                                    <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Status</th>
                                    <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($company->applications ?? [] as $app)
                                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 text-sm font-semibold text-gray-900">{{ $app->user->name ?? '—' }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-700">{{ $app->job->title ?? '—' }}</td>
                                        <td class="px-6 py-4 text-sm">
                                            @if($app->status == 'pending')
                                                <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-semibold">⏳ Pending</span>
                                            @elseif($app->status == 'accepted')
                                                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold">✅ Accepted</span>
                                            @elseif($app->status == 'rejected')
                                                <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-semibold">❌ Rejected</span>
                                            @else
                                                <span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-semibold">{{ $app->status }}</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm">
                                            <a href="{{ route('job-applications.show', $app->id) }}" class="text-blue-600 hover:text-blue-800 font-semibold hover:underline">
                                                👁️ View
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                            <p class="text-lg font-semibold">No applications found</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endif

    </div>

</x-app-layout>
