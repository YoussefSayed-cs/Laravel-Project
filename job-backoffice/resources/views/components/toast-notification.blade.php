<div class="fixed bottom-5 left-5 z-[9999]">
    @if (session('success'))
        <div x-data="{ show: false }"
             x-init="() => {
                $nextTick(() => { show = true });
                setTimeout(() => { show = false }, 3000);
             }"
             x-show="show"
             x-cloak
             x-transition:enter="transition transform ease-out duration-500"
             x-transition:enter-start="opacity-0 translate-y-10 scale-75"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition transform ease-in duration-300"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-75"
             class="max-w-sm bg-green-600 text-white px-5 py-4 rounded-xl shadow-2xl flex items-center gap-3 border border-green-500"
             role="alert">

            <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>

            <span class="text-sm font-semibold italic">
                {{ session('success') }}
            </span>

            <button @click="show = false" class="ml-auto hover:bg-green-700 rounded-lg p-1 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    @endif
</div>
