<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ $vacancy->title }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">
        <x-toast-notification />

        <!-- Company Card -->
        <div class="bg-white shadow-lg rounded-lg p-8 mb-6 border-l-4 border-blue-500">
            <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-6">
                <div class="flex-1">
                    <h3 class="text-3xl font-bold mb-4 text-gray-900">{{ $vacancy->company->name }}</h3>

                    <div class="space-y-3 mb-6">
                        <p class="text-gray-700">
                            <span class="font-semibold text-gray-900">Location:</span>
                            <span class="text-gray-600">{{ $vacancy->location ?? '—' }}</span>
                        </p>
                        <p class="text-gray-700">
                            <span class="font-semibold text-gray-900">Employment Type:</span>
                            <span class="text-gray-600">{{ $vacancy->type ?? '—' }}</span>
                        </p>
                        <p class="text-gray-700">
                            <span class="font-semibold text-gray-900">Salary:</span>
                            <span class="text-green-600 font-bold">{{ $vacancy->salary ?? '—' }}</span>
                        </p>
                        <p class="text-gray-700">
                            <span class="font-semibold text-gray-900">Description:</span>
                            <span class="text-gray-600 block mt-1">{{ $vacancy->description ?? '—' }}</span>
                        </p>
                        @if($vacancy->company->website)
                            <p class="text-gray-700">
                                <span class="font-semibold text-gray-900">Website:</span>
                                <a href="{{ $vacancy->company->website }}" target="_blank" class="text-blue-600 hover:underline break-all">
                                    {{ $vacancy->company->website }}
                                </a>
                            </p>
                        @endif
                    </div>
                </div>

                <div class="flex flex-col gap-3 w-full md:w-auto">
                    <a href="{{ route('job-vacancies.edit', ['job_vacancy' => $vacancy->id,'redirectToList' => 'false']) }}"
                       class="px-5 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition font-semibold text-center">
                       Edit
                    </a>

                    <form action="{{ route('job-vacancies.destroy', $vacancy->id) }}" method="POST" onsubmit="return confirm('Archive this job vacancy?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full px-5 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition font-semibold">
                            Archive
                        </button>
                    </form>

                    <a href="{{ route('job-vacancies.index') }}"
                       class="px-5 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition font-semibold text-center">
                       Back
                    </a>
                </div>
            </div>
        </div>

        <!-- Applications Section -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <!-- Header -->
            <div class="border-b border-gray-200 px-8 py-6 flex items-center justify-between">
                <h3 class="text-2xl font-bold text-gray-900">Applications</h3>
                <span class="bg-blue-100 text-blue-800 px-4 py-2 rounded-full font-semibold text-sm">
                    {{ ($vacancy->job_application ?? collect())->count() }} application(s)
                </span>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-8 py-4 text-left text-sm font-bold text-gray-700">Applicant</th>
                            <th class="px-8 py-4 text-left text-sm font-bold text-gray-700">Job</th>
                            <th class="px-8 py-4 text-left text-sm font-bold text-gray-700">Status</th>
                            <th class="px-8 py-4 text-left text-sm font-bold text-gray-700">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($vacancy->job_application ?? [] as $app)
                            <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                                <td class="px-8 py-4 text-sm text-gray-900 font-semibold">
                                    {{ $app->Owner->name ?? '—' }}
                                </td>
                                <td class="px-8 py-4 text-sm text-gray-700">
                                    {{ $app->JobVacancy->title ?? '—' }}
                                </td>
                                <td class="px-8 py-4 text-sm">
                                    @if($app->status == 'pending')
                                        <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-semibold">Pending</span>
                                    @elseif($app->status == 'accepted')
                                        <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold">Accepted</span>
                                    @elseif($app->status == 'rejected')
                                        <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-semibold">Rejected</span>
                                    @else
                                        <span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-semibold">{{ $app->status }}</span>
                                    @endif
                                </td>
                                <td class="px-8 py-4 text-sm">
                                    <a href="{{ route('job-applications.show', $app->id) }}"
                                       class="text-blue-600 hover:text-blue-800 font-semibold hover:underline">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-8 py-12 text-center text-gray-500">
                                    <p class="text-lg font-semibold">No applications found.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</x-app-layout>
