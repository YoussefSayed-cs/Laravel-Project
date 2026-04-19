<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Update Job Vacancy
        </h2>
    </x-slot>

    <div class="p-8">
        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-lg p-8">
            <form action="{{ route('job-vacancies.update', ['job_vacancy' => $vacancy->id, 'redirectToList' => request()->query('redirectToList')]) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Form Header -->
                <div class="mb-8">
                    <h3 class="text-xl font-bold text-gray-900">Job Vacancy Details</h3>
                    <p class="text-sm text-gray-600 mt-1">Update the job vacancy information below</p>
                </div>

                <!-- Title -->
                <div class="mb-6">
                    <label for="title" class="block text-sm font-semibold text-gray-900 mb-2">Title</label>
                    <input type="text" name="title" id="title"
                        value="{{ old('title', $vacancy->title) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition {{ $errors->has('title') ? 'border-red-500 focus:ring-red-500' : '' }}">
                    @error('title')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Location -->
                <div class="mb-6">
                    <label for="location" class="block text-sm font-semibold text-gray-900 mb-2">Location</label>
                    <input type="text" name="location" id="location"
                        value="{{ old('location', $vacancy->location) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition {{ $errors->has('location') ? 'border-red-500 focus:ring-red-500' : '' }}">
                    @error('location')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Salary -->
                <div class="mb-6">
                    <label for="salary" class="block text-sm font-semibold text-gray-900 mb-2">Expected Salary (USD)</label>
                    <input type="number" name="salary" id="salary"
                        value="{{ old('salary', $vacancy->salary) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition {{ $errors->has('salary') ? 'border-red-500 focus:ring-red-500' : '' }}">
                    @error('salary')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Type -->
                <div class="mb-6">
                    <label for="type" class="block text-sm font-semibold text-gray-900 mb-2">Employment Type</label>
                    <select name="type" id="type"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition {{ $errors->has('type') ? 'border-red-500 focus:ring-red-500' : '' }}">
                        <option value="">-- Select Type --</option>
                        <option value="Full-Time" {{ old('type', $vacancy->type) == 'Full-Time' ? 'selected' : '' }}>Full-Time</option>
                        <option value="Contract" {{ old('type', $vacancy->type) == 'Contract' ? 'selected' : '' }}>Contract</option>
                        <option value="Remote" {{ old('type', $vacancy->type) == 'Remote' ? 'selected' : '' }}>Remote</option>
                        <option value="Hybrid" {{ old('type', $vacancy->type) == 'Hybrid' ? 'selected' : '' }}>Hybrid</option>
                    </select>
                    @error('type')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Company -->
                <div class="mb-6">
                    <label for="companyID" class="block text-sm font-semibold text-gray-900 mb-2">Company</label>
                    <select name="companyID" id="companyID"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition {{ $errors->has('companyID') ? 'border-red-500 focus:ring-red-500' : '' }}">
                        <option value="">-- Select Company --</option>
                        @foreach ($companies as $company)
                            <option value="{{ $company->id }}" {{ old('companyID', $vacancy->companyID) == $company->id ? 'selected' : '' }}>
                                {{ $company->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('companyID')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Job Category -->
                <div class="mb-6">
                    <label for="categoryID" class="block text-sm font-semibold text-gray-900 mb-2">Job Category</label>
                    <select name="categoryID" id="categoryID"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition {{ $errors->has('categoryID') ? 'border-red-500 focus:ring-red-500' : '' }}">
                        <option value="">-- Select Category --</option>
                        @foreach ($jobCategories as $jobCategory)
                            <option value="{{ $jobCategory->id }}" {{ old('categoryID', $vacancy->categoryID) == $jobCategory->id ? 'selected' : '' }}>
                                {{ $jobCategory->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('categoryID')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-8">
                    <label for="description" class="block text-sm font-semibold text-gray-900 mb-2">Description</label>
                    <textarea rows="5" name="description" id="description"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none {{ $errors->has('description') ? 'border-red-500 focus:ring-red-500' : '' }}">{{ old('description', $vacancy->description) }}</textarea>
                    @error('description')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="flex justify-end gap-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('job-vacancies.index') }}"
                        class="px-6 py-2 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50 transition font-semibold">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition font-semibold focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Update Job Vacancy
                    </button>
                </div>
            </form>
        </div>
    </div>

</x-app-layout>
