<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Edit Company
        </h2>
    </x-slot>

    <div class="p-8">
        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-lg p-8">
            <form action="{{ route('companies.update', $company->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Form Header -->
                <div class="mb-8">
                    <h3 class="text-xl font-bold text-gray-900">Company Information</h3>
                    <p class="text-sm text-gray-600 mt-1">Update the company details below</p>
                </div>

                <!-- Company Name -->
                <div class="mb-6">
                    <label for="name" class="block text-sm font-semibold text-gray-900 mb-2">Company Name</label>
                    <input type="text" name="name" id="name"
                        value="{{ old('name', $company->name) }}"
                        placeholder="e.g., Tech Solutions Inc."
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition {{ $errors->has('name') ? 'border-red-500 focus:ring-red-500' : '' }}">
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Address -->
                <div class="mb-6">
                    <label for="address" class="block text-sm font-semibold text-gray-900 mb-2">Address</label>
                    <input type="text" name="address" id="address"
                        value="{{ old('address', $company->address) }}"
                        placeholder="e.g., 123 Main Street, New York, NY"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition {{ $errors->has('address') ? 'border-red-500 focus:ring-red-500' : '' }}">
                    @error('address')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Industry -->
                <div class="mb-6">
                    <label for="industry" class="block text-sm font-semibold text-gray-900 mb-2">Industry</label>
                    <input type="text" name="industry" id="industry"
                        value="{{ old('industry', $company->industry) }}"
                        placeholder="e.g., Technology, Finance, Healthcare"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition {{ $errors->has('industry') ? 'border-red-500 focus:ring-red-500' : '' }}">
                    @error('industry')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Website -->
                <div class="mb-8">
                    <label for="website" class="block text-sm font-semibold text-gray-900 mb-2">Website</label>
                    <input type="url" name="website" id="website"
                        value="{{ old('website', $company->website) }}"
                        placeholder="e.g., https://www.example.com"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition {{ $errors->has('website') ? 'border-red-500 focus:ring-red-500' : '' }}">
                    @error('website')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="flex justify-end gap-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('companies.index') }}"
                        class="px-6 py-2 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50 transition font-semibold">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition font-semibold focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Update Company
                    </button>
                </div>
            </form>
        </div>
    </div>

</x-app-layout>
