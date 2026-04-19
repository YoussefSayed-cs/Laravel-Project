<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Job Vacancies {{ request()->input('archived') == 'true' ? '(Archived)' : '' }}
        </h2>
    </x-slot>

    <div class="p-8">
        <x-toast-notification />

        <!-- Action Buttons -->
        <div class="flex justify-between items-center mb-6 flex-wrap gap-3">
            <div>
                @if (request()->has('archived') && request()->input('archived') == 'true')
                    <!-- Active -->
                    <a href="{{ route('job-vacancies.index') }}"
                        class="inline-flex items-center px-5 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-800 transition font-semibold">
                        ← Active Job Vacancies
                    </a>
                @else
                    <!-- Archived -->
                    <a href="{{ route('job-vacancies.index', ['archived' => 'true']) }}"
                        class="inline-flex items-center px-5 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-800 transition font-semibold">
                        📦 Archived Job Vacancies
                    </a>
                @endif
            </div>

            <!-- Add Job Vacancy Button -->
            <a href="{{ route('job-vacancies.create') }}"
                class="inline-flex items-center px-5 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition font-semibold">
                ➕ Add Job Vacancy
            </a>
        </div>

        <!-- Table -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Title</th>

                            @if (auth()->user()->role == 'admin')
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Company</th>
                            @endif

                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Location</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Type</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Salary</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($vacancies as $vacancy)
                            <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-sm font-semibold text-gray-900">
                                    <a class="text-blue-600 hover:text-blue-800 hover:underline"
                                        href="{{ route('job-vacancies.show', $vacancy->id) }}">
                                        {{ $vacancy->title }}
                                    </a>
                                </td>

                                @if (auth()->user()->role == 'admin')
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    {{ $vacancy->company->name ?? 'N/A' }}
                                </td>
                                @endif

                                <td class="px-6 py-4 text-sm text-gray-700">
                                    {{ $vacancy->location }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    {{ $vacancy->type }}
                                </td>
                                <td class="px-6 py-4 text-sm font-semibold text-green-600">
                                    {{ $vacancy->salary }}
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <div class="flex gap-3">
                                        @if (request()->input('archived') == 'true')
                                            <!-- Restore Button -->
                                            <form action="{{ route('job-vacancies.restore', $vacancy->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="text-green-600 hover:text-green-800 font-semibold hover:underline">
                                                    ✓ Restore
                                                </button>
                                            </form>
                                        @else
                                            <!-- Edit Button -->
                                            <a href="{{ route('job-vacancies.edit', $vacancy->id)}}"
                                                class="text-blue-600 hover:text-blue-800 font-semibold hover:underline">
                                                ✏️ Edit
                                            </a>

                                            <!-- Archive Button -->
                                            <form action="{{ route('job-vacancies.destroy', $vacancy->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-orange-600 hover:text-orange-800 font-semibold hover:underline">
                                                    🗂️ Archive
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                    <p class="text-lg font-semibold">No Vacancies found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $vacancies->links() }}
        </div>
    </div>
</x-app-layout>
