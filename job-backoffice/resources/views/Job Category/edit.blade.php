<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Edit Job Category
        </h2>
    </x-slot>

    <div class="p-8">
        <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-lg p-8">
            <form action="{{ route('job-categories.update', $category->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Form Header -->
                <div class="mb-8">
                    <h3 class="text-xl font-bold text-gray-900">Category Information</h3>
                    <p class="text-sm text-gray-600 mt-1">Update the job category details below</p>
                </div>

                <!-- Category Name -->
                <div class="mb-8">
                    <label for="name" class="block text-sm font-semibold text-gray-900 mb-2">Category Name</label>
                    <input type="text" name="name" id="name"
                        value="{{ old('name', $category->name) }}"
                        placeholder="e.g., Software Development"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition {{ $errors->has('name') ? 'border-red-500 focus:ring-red-500' : '' }}">
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="flex justify-end gap-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('job-categories.index') }}"
                        class="px-6 py-2 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50 transition font-semibold">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition font-semibold focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Update Category
                    </button>
                </div>
            </form>
        </div>
    </div>

</x-app-layout>
