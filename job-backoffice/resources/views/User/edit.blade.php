<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Edit User Password
        </h2>
    </x-slot>

    <div class="p-8">
        <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-lg p-8">
            <form action="{{ route('users.update', ['user' => $users->id, 'redirectToList' => request()->query('redirectToList')]) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Form Header -->
                <div class="mb-8">
                    <h3 class="text-xl font-bold text-gray-900">User Information</h3>
                    <p class="text-sm text-gray-600 mt-1">View user details and update password</p>
                </div>

                <!-- User Details Section -->
                <div class="mb-8 p-6 bg-gray-50 rounded-lg border border-gray-200">
                    <h4 class="text-sm font-bold text-gray-700 uppercase mb-4">User Details</h4>

                    <!-- User Name -->
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-900 mb-1">Name</label>
                        <p class="px-4 py-2 bg-white border border-gray-200 rounded-lg text-gray-700">
                            {{ $users->name ?? '—' }}
                        </p>
                    </div>

                    <!-- User Email -->
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-900 mb-1">Email</label>
                        <p class="px-4 py-2 bg-white border border-gray-200 rounded-lg text-gray-700">
                            {{ $users->email ?? '—' }}
                        </p>
                    </div>

                    <!-- User Role -->
                    <div class="mb-0">
                        <label class="block text-sm font-semibold text-gray-900 mb-1">Role</label>
                        <p class="px-4 py-2 bg-white border border-gray-200 rounded-lg text-gray-700">
                            @if($users->role == 'admin')
                                <span class="inline-block px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-semibold">👑 Admin</span>
                            @elseif($users->role == 'company-owner')
                                <span class="inline-block px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-xs font-semibold">🏢 Company Owner</span>
                            @else
                                <span class="inline-block px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold">👤 User</span>
                            @endif
                        </p>
                    </div>
                </div>

                <!-- Password Section -->
                <div class="mb-8">
                    <label for="password" class="block text-sm font-semibold text-gray-900 mb-2">New Password</label>
                    <div class="relative" x-data="{ showPassword: false }">
                        <input
                            id="password"
                            name="password"
                            :type="showPassword ? 'text' : 'password'"
                            placeholder="Enter new password..."
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition pr-12 {{ $errors->has('password') ? 'border-red-500 focus:ring-red-500' : '' }}"
                        />
                        <button
                            type="button"
                            @click="showPassword = !showPassword"
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700 transition"
                        >
                            <!-- Eye Icon - Closed -->
                            <svg
                                x-show="!showPassword"
                                class="w-5 h-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>

                            <!-- Eye Icon - Open -->
                            <svg
                                x-show="showPassword"
                                class="w-5 h-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-4.803m5.596-3.856a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="flex justify-end gap-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('users.index') }}"
                        class="px-6 py-2 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50 transition font-semibold">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition font-semibold focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Update Password
                    </button>
                </div>
            </form>
        </div>
    </div>

</x-app-layout>
