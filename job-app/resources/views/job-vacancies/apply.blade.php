<x-app-layout>

    <x-slot name="header">
        <h2 class="font-bold text-2xl bg-gradient-to-r from-white to-white/60 bg-clip-text text-transparent leading-tight">
            Apply for Position
        </h2>
    </x-slot>

    <div class="space-y-6">
        <div class="glass-card rounded-2xl p-8 relative overflow-hidden">
            <!-- Decorative Glow -->
            <div class="absolute -right-20 -top-20 w-64 h-64 bg-brand-500/10 rounded-full blur-3xl"></div>

            <a href="{{ route('job-vacancy.show', $job_vacancy->id) }}" class="inline-flex items-center gap-2 text-brand-400 hover:text-brand-300 transition-colors mb-8 group">
                <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                <span class="text-sm font-semibold">Back to Job Details</span>
            </a>

            <div class="border-b border-white/10 pb-8 relative z-10">
                <div class="flex items-center gap-6">
                    <div class="w-20 h-20 bg-brand-500/10 rounded-2xl flex items-center justify-center text-brand-400 font-bold text-3xl uppercase border border-brand-500/20">
                        {{ substr($job_vacancy->company->name ?? 'C', 0, 1) }}
                    </div>
                    <div>
                        <h1 class="font-heading text-2xl md:text-3xl font-bold text-white mb-2">{{ $job_vacancy->title }}</h1>
                        <div class="flex items-center gap-2">
                             <p class="text-sm text-slate-400">{{ $job_vacancy->company->name }} &bull; {{ $job_vacancy->location }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <form action="{{ route('job-vacancy.processApplications', $job_vacancy->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8 mt-10 relative z-10 max-w-2xl">
                @csrf

                <!-- Resume Selection -->
                <div>
                    <h3 class="font-heading text-xl font-bold text-white mb-6">Choose Your Resume</h3>
                    
                    <div class="space-y-3">
                        @forelse($resumes as $resume)
                            <label class="flex items-center gap-4 p-4 rounded-xl border border-slate-700/50 bg-slate-800/30 hover:border-brand-500/50 hover:bg-slate-800/50 transition-all cursor-pointer group">
                                <div class="relative flex items-center">
                                    <input type="radio" name="resume_option" value="existing_{{ $resume->id }}" class="peer sr-only">
                                    <div class="w-5 h-5 bg-slate-800 border border-slate-600 rounded-full peer-checked:bg-brand-500 peer-checked:border-brand-500 transition-all flex items-center justify-center">
                                        <div class="w-2 h-2 bg-white rounded-full opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <p class="text-white font-medium group-hover:text-brand-300 transition-colors">{{ $resume->filename }}</p>
                                    <p class="text-xs text-slate-500">Updated on {{ $resume->updated_at->format('M d, Y') }}</p>
                                </div>
                                <svg class="w-5 h-5 text-slate-600 group-hover:text-brand-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </label>
                        @empty
                            <p class="text-slate-500 text-sm italic">No saved resumes found. Please upload a new one below.</p>
                        @endforelse
                    </div>
                    <x-input-error :messages="$errors->get('resume_option')" class="mt-2 text-red-400" />
                </div>

                <!-- Upload New Resume -->
                <div x-data="{ fileName: '' }">
                    <label class="flex items-center gap-4 p-4 rounded-xl border border-slate-700/50 bg-slate-800/30 hover:border-brand-500/50 hover:bg-slate-800/50 transition-all cursor-pointer group mb-4">
                        <div class="relative flex items-center">
                            <input type="radio" name="resume_option" id="new_resume_radio" value="new_resume" class="peer sr-only" :checked="fileName">
                            <div class="w-5 h-5 bg-slate-800 border border-slate-600 rounded-full peer-checked:bg-brand-500 peer-checked:border-brand-500 transition-all flex items-center justify-center">
                                <div class="w-2 h-2 bg-white rounded-full opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                            </div>
                        </div>
                        <span class="text-white font-medium">Upload a new resume</span>
                    </label>

                    <div class="mt-4">
                        <label for="resume_file" class="block w-full">
                            <div class="border-2 border-dashed border-slate-700 rounded-2xl p-10 text-center hover:border-brand-500/50 hover:bg-brand-500/5 transition-all cursor-pointer group"
                                 :class="{ 'border-brand-500/50 bg-brand-500/5': fileName }">
                                <input type="file" name="resume_file" id="resume_file" class="sr-only" accept=".pdf"
                                       @change="fileName = $event.target.files[0].name; document.getElementById('new_resume_radio').checked = true;">
                                
                                <div class="flex flex-col items-center">
                                    <div class="w-12 h-12 bg-slate-800 rounded-xl flex items-center justify-center text-slate-400 group-hover:text-brand-400 transition-colors mb-4">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                    </div>
                                    <p class="text-white font-medium" x-text="fileName || 'Click to upload PDF'"></p>
                                    <p class="text-slate-500 text-sm mt-1">Maximum file size: 5 MB</p>
                                </div>
                            </div>
                        </label>
                    </div>
                    <x-input-error :messages="$errors->get('resume_file')" class="mt-2 text-red-400" />
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full flex justify-center py-4 px-4 border border-transparent rounded-xl shadow-lg shadow-brand-500/20 text-base font-bold text-white bg-brand-600 hover:bg-brand-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 focus:ring-offset-slate-900 transition-all hover:-translate-y-0.5">
                        Submit Application
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>