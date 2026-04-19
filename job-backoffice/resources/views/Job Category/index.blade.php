<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Job Categories {{ request()->input('archived') == 'true' ? '(Archived)' : '' }}
        </h2>
    </x-slot>

    <div class="p-8">
        <x-toast-notification />

        <!-- Action Buttons -->
        <div class="flex justify-between items-center mb-6 flex-wrap gap-3">
            <div>
                @if (request()->has('archived') && request()->input('archived') == 'true')
                    <!-- Active Categories -->
                    <a href="{{ route('job-categories.index') }}"
                        class="inline-flex items-center px-5 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-800 transition font-semibold">
                        ← Active Categories
                    </a>
                @else
                    <!-- Archived Categories -->
                    <a href="{{ route('job-categories.index', ['archived' => 'true']) }}"
                        class="inline-flex items-center px-5 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-800 transition font-semibold">
                        📦 Archived Categories
                    </a>
                @endif
            </div>

            <!-- Add Job Category Button -->
            <a href="{{ route('job-categories.create') }}"
                class="inline-flex items-center px-5 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition font-semibold">
                ➕ Add Job Category
            </a>
        </div>

        <!-- Table -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Category Name</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($job_categories as $category)
                            <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-sm font-semibold text-gray-900">
                                    <span class="text-2xl mr-2">{{ $category->emoji }}</span>
                                    {{ $category->name }}
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <div class="flex gap-3">
                                        @if (request()->input('archived') == 'true')
                                            <!-- Restore Button -->
                                            <form action="{{ route('job-categories.restore', $category->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="text-green-600 hover:text-green-800 font-semibold hover:underline">
                                                    ✓ Restore
                                                </button>
                                            </form>
                                        @else
                                            <!-- Edit Button -->
                                            <a href="{{ route('job-categories.edit', $category->id)}}"
                                                class="text-blue-600 hover:text-blue-800 font-semibold hover:underline">
                                                ✏️ Edit
                                            </a>

                                            <!-- Archive Button -->
                                            <form action="{{ route('job-categories.destroy', $category->id) }}" method="POST" class="inline">
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
                                <td colspan="2" class="px-6 py-12 text-center text-gray-500">
                                    <p class="text-lg font-semibold">No categories found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $job_categories->links() }}
        </div>
    </div>

</x-app-layout>
