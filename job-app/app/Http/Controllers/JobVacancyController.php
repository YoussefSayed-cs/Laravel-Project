<?php

namespace App\Http\Controllers;

use App\Http\Requests\AbblyJobRequest;
use App\Models\job_application;
use App\Models\job_vacancy;
use App\Models\resume;
use App\Services\ResumesAnalysisServices;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class JobVacancyController extends Controller
{
    protected ResumesAnalysisServices $resumeService;

    public function __construct(ResumesAnalysisServices $resumeService)
    {
        $this->resumeService = $resumeService;
    }

    public function show(string $id)
    {
        $job_vacancy = job_vacancy::findOrFail($id);
        return view('job-vacancies.show', compact('job_vacancy'));
    }

    public function apply(string $id)
    {
        $job_vacancy = job_vacancy::findOrFail($id);
        $resumes = Auth::user()->resume;

        return view('job-vacancies.apply', compact('job_vacancy', 'resumes'));
    }

    public function processApplications(AbblyJobRequest $request, string $id)
    {
        $job_vacancy = job_vacancy::findOrFail($id);
        $resumeID = null;

        // ✅ تحديث الهيكل الافتراضي ليتناسب مع رد Gemini (Arrays)
        $extracted = [
            'summary' => '',
            'skills' => [],
            'experience' => [],
            'education' => [],
        ];

        /*
        |------------------------------------------------------------------
        | EXISTING RESUME
        |------------------------------------------------------------------
        */
        if (str_starts_with($request->resume_option, 'existing_')) {
            $existingId = str_replace('existing_', '', $request->resume_option);

            $resume = resume::where('id', $existingId)
                ->where('userID', Auth::id())
                ->first();

            if (!$resume) {
                return back()->withErrors(['resume_option' => 'Invalid resume selected']);
            }

            $resumeID = $resume->id;

            // التأكد من استرجاع البيانات بصيغة مصفوفة (Array)
            $extracted = [
                'summary' => $resume->summary ?? '',
                'skills' => is_array($resume->skills) ? $resume->skills : json_decode($resume->skills ?? '[]', true),
                'experience' => is_array($resume->experience) ? $resume->experience : json_decode($resume->experience ?? '[]', true),
                'education' => is_array($resume->education) ? $resume->education : json_decode($resume->education ?? '[]', true),
            ];
        }

        /*
        |------------------------------------------------------------------
        | NEW RESUME
        |------------------------------------------------------------------
        */
        elseif ($request->resume_option === 'new_resume') {
            $file = $request->file('resume_file');
            $fileName = 'resume_' . time() . '.pdf';
            $path = $file->storeAs('resume', $fileName, 'cloud');

            // ✅ استخراج البيانات باستخدام Gemini
            try {
                $extracted = $this->resumeService->extractResumeInformation($path);
            } catch (\Throwable $e) {
                Log::warning('AI extraction failed: ' . $e->getMessage());
            }

            $resume = resume::create([
                'filename' => $file->getClientOriginalName(),
                'fileUri' => $path,
                'userID' => Auth::id(),
                'contactDetails' => [
                    'name' => Auth::user()->name,
                    'email' => Auth::user()->email,
                ],
                'summary' => $extracted['summary'] ?? '',
                'skills' => $extracted['skills'] ?? [],
                'experience' => $extracted['experience'] ?? [],
                'education' => $extracted['education'] ?? [],
            ]);

            $resumeID = $resume->id;
        }

        /*
        |------------------------------------------------------------------
        | AI EVALUATION
        |------------------------------------------------------------------
        */
        try {
            // نرسل البيانات المستخرجة (سواء كانت من CV قديم أو جديد) للتحليل
            $evaluation = $this->resumeService->analyzeResume($job_vacancy, $extracted);
        } catch (\Throwable $e) {
            Log::warning('AI evaluation skipped: ' . $e->getMessage());
            $evaluation = [
                'aiGeneratedScore' => 0,
                'aiGeneratedFeedback' => 'AI evaluation is temporarily unavailable.',
            ];
        }

        $jobApplication = job_application::create([
            'status' => 'pending',
            'aiGeneratedScore' => $evaluation['aiGeneratedScore'] ?? 0,
            'aiGeneratedFeedback' => $evaluation['aiGeneratedFeedback'] ?? 'No AI feedback',
            'jobVacancyID' => $job_vacancy->id,
            'resumeID' => $resumeID,
            'userID' => Auth::id(),
        ]);

        $owner = $job_vacancy->company->Owner;
        if ($owner) {
            $owner->notify(new \App\Notifications\newJobApply(Auth::user(), $job_vacancy, $jobApplication, $jobApplication->id));
        }

        $admins = \App\Models\User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            if ($owner && $admin->id === $owner->id) continue;
            $admin->notify(new \App\Notifications\newJobApply(Auth::user(), $job_vacancy, $jobApplication, $jobApplication->id));
        }

        return redirect()->route('job-applications.index', $job_vacancy->id)
            ->with('success', 'Your application has been submitted successfully!');

    }
}
