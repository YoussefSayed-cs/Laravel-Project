<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $job_application->Owner->name ?? '—' }}'s Application for {{ $job_application->jobVacancy->title ?? '—' }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">
        <x-toast-notification />

        <!-- Company Card -->
        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
            <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4">
                <div>
                    <h3 class="text-2xl font-semibold mb-2">Applications Details</h3>
                    <p class="text-sm text-gray-500 mb-1"><strong>Applicant:</strong> {{ $job_application->Owner->name ?? '—' }}</p>
                    <p class="text-sm text-gray-500 mb-1"><strong>Job Vacancy:</strong> {{ $job_application->jobVacancy->title ?? '—' }}</p>
                    <p class="text-sm text-gray-500 mb-1"><strong>Company:</strong> {{ $job_application->jobVacancy->company->name ?? '—' }}</p>
                    <p class="text-sm text-gray-500 mb-1"><strong>Status:</strong> <span class="@if($job_application->status == 'accepted') text-green-500 @elseif($job_application->status == 'rejected') text-red-500  @else text-yellow-500 @endif">{{ $job_application->status ?? '—' }}</span></p>
                    <p class="text-sm text-gray-500">
                        <strong>Resume File:</strong>
                        @if($job_application->resume?->fileUri)
                            <a href="{{ route('job-applications.resume', $job_application->id) }}"
                               target="_blank"
                               class="text-blue-600 hover:underline inline-flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                {{ $job_application->resume->filename ?? 'View Resume' }}
                            </a>
                        @else
                            —
                        @endif
                    </p>
                </div>


                   <!-- Edit and Archive Buttons-->
                <div class="flex items-center space-x-3">
                    <a href="{{ route('job-applications.edit', ['job_application' => $job_application->id,'redirectToList' => 'true']) }}" class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Edit</a>
                    
                    <form action="{{ route('job-applications.destroy', $job_application->id) }}" method="POST" onsubmit="return confirm('Archive this job application?');">
                        @csrf
                        @method('DELETE')
                        <a href="{{ route('job-applications.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">Back</a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">Archive</button>
                    </form>
                </div>
            </div>
        </div>                  

        <!-- Tabs Navigation -->
        <div class="mb-6">
            <ul class="flex border-b">
                <li class="-mb-px mr-1">
                    <a href="{{ route('job-applications.show', ['job_application' => $job_application->id, 'tab' => 'resume']) }}"
                       class="bg-white inline-block py-2 px-4 {{ request('tab') == 'resume' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-600' }}">
                        Resume
                    </a>
                </li>
                <li class="-mb-px mr-1">
                    <a href="{{ route('job-applications.show', ['job_application' => $job_application->id, 'tab' => 'AIFeedback']) }}"
                       class="bg-white inline-block py-2 px-4 {{ request('tab') == 'AIFeedback' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-600' }}">
                        AIFeedback
                    </a>
                </li>
            </ul>
        </div>

        <!-- Tab Content -->
        <div>
            <!-- Resume tab -->
            <div id="resume" class="{{ request('tab') == 'resume' || request('tab') === null ? 'block' : 'hidden' }}">
                <div class="mb-4 flex items-center justify-between">
                    <h3 class="text-lg font-bold">resume Content</h3>
                
                </div>

                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Summary</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Skills</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Experience</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Education</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                                <tr>
                                    <td class="px-6 py-4 align-top text-gray-800">{{ $job_application->resume->summary ?? '—' }}</td>
                                    <td class="px-6 py-4 align-top">
                                        @if(is_array($job_application->resume?->skills))
                                            <div class="flex flex-wrap gap-2">
                                                @foreach($job_application->resume->skills as $skill)
                                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-indigo-50 text-indigo-700 border border-indigo-100">
                                                        {{ trim($skill) }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @else
                                            {{ $job_application->resume?->skills ?? '—' }}
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 align-top">
                                        @if(is_array($job_application->resume?->experience) && count($job_application->resume->experience) > 0)
                                            <ul class="space-y-3">
                                            @foreach($job_application->resume->experience as $exp)
                                                <li class="bg-gray-50 p-3 rounded border border-gray-100">
                                                    <div class="font-semibold text-gray-800">{{ $exp['title'] ?? ($exp['role'] ?? '') }}</div>
                                                    @if(isset($exp['company']))
                                                        <div class="text-sm text-gray-600 mb-1">{{ $exp['company'] }}</div>
                                                    @endif
                                                    @if(isset($exp['description']))
                                                        <div class="text-xs text-gray-500 mt-1">{{ $exp['description'] }}</div>
                                                    @endif
                                                </li>
                                            @endforeach
                                            </ul>
                                        @elseif(is_string($job_application->resume?->experience))
                                            {{ $job_application->resume->experience }}
                                        @else
                                            —
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 align-top">
                                        @if(is_array($job_application->resume?->education) && count($job_application->resume->education) > 0)
                                            <ul class="space-y-3">
                                            @foreach($job_application->resume->education as $edu)
                                                <li class="bg-gray-50 p-3 rounded border border-gray-100">
                                                    <div class="font-semibold text-gray-800">{{ $edu['institution'] ?? ($edu['school'] ?? '') }}</div>
                                                    @if(isset($edu['degree']))
                                                        <div class="text-sm text-gray-600 mb-1">{{ $edu['degree'] }}</div>
                                                    @endif
                                                    @if(isset($edu['description']))
                                                        <div class="text-xs text-gray-500 mt-1">{{ $edu['description'] }}</div>
                                                    @endif
                                                </li>
                                            @endforeach
                                            </ul>
                                        @elseif(is_string($job_application->resume?->education))
                                            {{ $job_application->resume->education }}
                                        @else
                                            —
                                        @endif
                                    </td>
                                </tr>
    
                        </tbody>
                    </table>
                </div>
</div>
            <!-- AI Feedback tab -->
            <div id="AIFeedback" class="{{ request('tab') == 'AIFeedback' ? 'block' : 'hidden' }}">
                <div class="mb-4 flex items-center justify-between">
                    <h3 class="text-lg font-bold">AI Feedback</h3>
          
                </div>

                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 ">AI score</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 ">Feedback</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                           
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-800">{{ $job_application->aiGeneratedScore ?? '—' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-800">{{ $job_application->aiGeneratedFeedback ?? '—' }}</td>
                                </tr>
                                
                                    
                        </tbody>
                    </table>
                </div>
            </div>
        </div> <!-- end tab content wrapper -->

    </div> <!-- end container -->

</x-app-layout>