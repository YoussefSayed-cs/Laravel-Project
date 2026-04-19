<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Users {{ request()->input('archived') == 'true' ? '(Archived)' : '' }}
        </h2>
    </x-slot>

    <div class="p-8">
        <x-toast-notification />

        <!-- Action Buttons -->
        <div class="flex justify-between items-center mb-8 flex-wrap gap-3">
            <div>
                @if (request()->has('archived') && request()->input('archived') == 'true')
                    <!-- Active Users -->
                    <a href="{{ route('users.index') }}"
                        class="inline-flex items-center px-5 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-800 transition font-semibold">
                        ← Active Users
                    </a>
                @else
                    <!-- Archived Users -->
                    <a href="{{ route('users.index', ['archived' => 'true']) }}"
                        class="inline-flex items-center px-5 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-800 transition font-semibold">
                        📦 Archived Users
                    </a>
                @endif
            </div>
        </div>

        <!-- Search Form -->
        <div class="mb-6">
            <form action="{{ route('users.index') }}" method="GET" class="flex gap-3 flex-wrap">
                <div class="flex flex-1 min-w-80">
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                        placeholder="Search user by name or email...">

                    @if(request('filter'))
                        <input type="hidden" name="filter" value="{{ request('filter') }}">
                    @endif

                    <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded-r-lg hover:bg-blue-600 transition font-semibold">
                        🔍 Search
                    </button>
                </div>

                @if(request('search'))
                    <a href="{{ route('users.index', ['filter' => request('filter')]) }}"
                        class="px-6 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition font-semibold">
                        ✕ Clear
                    </a>
                @endif
            </form>
        </div>

        <!-- Table -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Name</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Email</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Role</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($users as $user)
                            <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-sm font-semibold text-gray-900">
                                    {{ $user->name ?? 'Unknown User' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    {{ $user->email ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    @if($user->role == 'admin')
                                        <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-semibold">
                                            👑 Admin
                                        </span>
                                    @elseif($user->role == 'company-owner')
                                        <span class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-xs font-semibold">
                                            🏢 Company Owner
                                        </span>
                                    @else
                                        <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold">
                                            👤 User
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <div class="flex gap-3">
                                        @if (request()->input('archived') == 'true')
                                            <!-- Restore Button -->
                                            <form action="{{ route('users.restore', $user->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="text-green-600 hover:text-green-800 font-semibold hover:underline">
                                                    ✓ Restore
                                                </button>
                                            </form>
                                        @else
                                            @if($user->role != 'admin')
                                                <!-- Edit Button -->
                                                <a href="{{ route('users.edit', $user->id)}}"
                                                    class="text-blue-600 hover:text-blue-800 font-semibold hover:underline">
                                                    ✏️ Edit
                                                </a>

                                                <!-- Archive Button -->
                                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-orange-600 hover:text-orange-800 font-semibold hover:underline">
                                                        🗂️ Archive
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-gray-400 font-semibold">No actions</span>
                                            @endif
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                    <p class="text-lg font-semibold">No users found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $users->links() }}
        </div>
    </div>

</x-app-layout>
