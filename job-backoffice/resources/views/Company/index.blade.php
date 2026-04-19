<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Companies {{ request()->input('archived') == 'true' ? '(Archived)' : '' }}
        </h2>
    </x-slot>

    <div class="p-8">
        <x-toast-notification />

        <!-- Action Buttons -->
        <div class="flex justify-between items-center mb-6 flex-wrap gap-3">
            <div>
                @if (request()->has('archived') && request()->input('archived') == 'true')
                    <!-- Active Companies -->
                    <a href="{{ route('companies.index') }}"
                        class="inline-flex items-center px-5 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-800 transition font-semibold">
                        ← Active Companies
                    </a>
                @else
                    <!-- Archived Companies -->
                    <a href="{{ route('companies.index', ['archived' => 'true']) }}"
                        class="inline-flex items-center px-5 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-800 transition font-semibold">
                        📦 Archived Companies
                    </a>
                @endif
            </div>

            <!-- Add Company Button -->
            <a href="{{ route('companies.create') }}"
                class="inline-flex items-center px-5 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition font-semibold">
                ➕ Add Company
            </a>
        </div>

        <!-- Table -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Company Name</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Address</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Industry</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Website</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($companies as $company)
                            <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-sm font-semibold text-gray-900">
                                    <a class="text-blue-600 hover:text-blue-800 hover:underline"
                                        href="{{ route('companies.show', $company->id) }}">
                                        {{ $company->name }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    {{ $company->address ?? '—' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    {{ $company->industry ?? '—' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-blue-600">
                                    @if($company->website)
                                        <a href="{{ $company->website }}" target="_blank" class="hover:text-blue-800 hover:underline truncate">
                                            {{ substr($company->website, 0, 30) }}{{ strlen($company->website) > 30 ? '...' : '' }}
                                        </a>
                                    @else
                                        <span class="text-gray-500">—</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <div class="flex gap-3">
                                        @if (request()->input('archived') == 'true')
                                            <!-- Restore Button -->
                                            <form action="{{ route('companies.restore', $company->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="text-green-600 hover:text-green-800 font-semibold hover:underline">
                                                    ✓ Restore
                                                </button>
                                            </form>
                                        @else
                                            <!-- Edit Button -->
                                            <a href="{{ route('companies.edit', $company->id)}}"
                                                class="text-blue-600 hover:text-blue-800 font-semibold hover:underline">
                                                ✏️ Edit
                                            </a>

                                            <!-- Archive Button -->
                                            <form action="{{ route('companies.destroy', $company->id) }}" method="POST" class="inline">
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
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                    <p class="text-lg font-semibold">No companies found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $companies->links() }}
        </div>
    </div>

</x-app-layout>
