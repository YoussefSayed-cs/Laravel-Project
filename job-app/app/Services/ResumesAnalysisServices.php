<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class ResumesAnalysisServices
{
    // رابط Gemini 1.5 Flash (الأسرع والأفضل للملفات)
    protected string $baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent';

    /**
     * الخطوة الأولى: استخراج البيانات من الـ CV
     */
    public function extractResumeInformation(string $fileUri): array
{
    try {
        // التأكد من استخدام الديسك الصحيح والمسار القادم من قاعدة البيانات
        if (!Storage::disk('cloud')->exists($fileUri)) {
            // السطر ده هيطبع لك في اللوج المسار اللي الـ AI بيدور فيه
            Log::error("Gemini cannot find file at: " . $fileUri);
            return $this->emptySchema();
        }

        $fileContent = Storage::disk('cloud')->get($fileUri);
        $base64Pdf = base64_encode($fileContent);

        $response = Http::withHeaders([
            'x-goog-api-key' => config('services.gemini.key'),
            'Content-Type'   => 'application/json',
        ])->post($this->baseUrl, [
            'contents' => [
                [
                    'parts' => [
                        ['text' => "Extract resume details into JSON: summary, skills, experience, education."],
                        [
                            'inlineData' => [
                                'mimeType' => 'application/pdf',
                                'data' => $base64Pdf
                            ]
                        ]
                    ]
                ]
            ],
            'generationConfig' => [
                'responseMimeType' => 'application/json',
            ]
        ]);

        return json_decode($response->json('candidates.0.content.parts.0.text'), true) ?? $this->emptySchema();

    } catch (\Throwable $e) {
        Log::error('Extraction Failed: ' . $e->getMessage());
        return $this->emptySchema();
    }
}

    /**
     * الخطوة الثانية: تحليل الـ CV مقابل الوظيفة
     */
    public function analyzeResume($job_vacancy, array $resumeData): array
    {
        try {
            // استخدام حقول الوظيفة (تأكد من مسميات الحقول في قاعدة بياناتك)
            $jobInfo = [
                'title' => $job_vacancy->title ?? $job_vacancy->utils ?? 'Software Engineer',
                'description' => $job_vacancy->description ?? ''
            ];

            $prompt = "Compare this resume with the job requirements. Return ONLY JSON: {aiGeneratedScore: int(0-100), aiGeneratedFeedback: string}.
                       Job: " . json_encode($jobInfo) . "
                       Resume: " . json_encode($resumeData);

            $response = Http::withHeaders([
                'x-goog-api-key' => config('services.gemini.key'),
                'Content-Type'   => 'application/json',
            ])->post($this->baseUrl, [
                'contents' => [
                    ['parts' => [['text' => $prompt]]]
                ],
                'generationConfig' => [
                    'temperature' => 0.2,
                    'responseMimeType' => 'application/json',
                ]
            ]);

            $text = $response->json('candidates.0.content.parts.0.text');
            return json_decode($text, true) ?? ['aiGeneratedScore' => 0, 'aiGeneratedFeedback' => 'Analysis failed.'];

        } catch (\Throwable $e) {
            Log::error('Resume Analysis Failed: ' . $e->getMessage());
            return ['aiGeneratedScore' => 0, 'aiGeneratedFeedback' => 'Service error.'];
        }
    }

    private function emptySchema(): array
    {
        return [
            'summary' => '',
            'skills' => [],
            'experience' => [],
            'education' => [],
        ];
    }
}
