<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class ResumesAnalysisServices
{
    protected string $baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent';

    /**
     * الخطوة الأولى والأهم: استخراج البيانات من الـ CV مباشرة
     * Gemini 1.5 Flash can read PDF natively via Base64
     */
    public function extractResumeInformation(string $fileUri): array
    {
        try {
            // 1️⃣ قراءة الملف من الكلاود وتحويله لـ Base64
            if (!Storage::disk('cloud')->exists($fileUri)) {
                throw new \Exception("File not found on cloud storage: $fileUri");
            }

            $fileContent = Storage::disk('cloud')->get($fileUri);
            $base64Pdf = base64_encode($fileContent);

            // 2️⃣ إرسال الـ PDF مباشرة لـ Gemini
            $response = Http::withHeaders([
                'x-goog-api-key' => config('services.gemini.key'),
                'Content-Type'   => 'application/json',
            ])->post($this->baseUrl, [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => "Extract the resume details and return ONLY a valid JSON object with these keys: summary (string), skills (array), experience (array), education (array)."],
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
                    'temperature' => 0.1,
                    'responseMimeType' => 'application/json',
                ]
            ]);

            if (!$response->successful()) {
                throw new \Exception("Gemini API Error: " . $response->body());
            }

            $result = json_decode($response->json('candidates.0.content.parts.0.text'), true);

            return $result ?? $this->emptySchema();

        } catch (\Throwable $e) {
            Log::error('Resume Extraction Failed: ' . $e->getMessage());
            return $this->emptySchema();
        }
    }

    /**
     * تحليل الـ CV مقابل الوظيفة المتاحة
     */
    public function analyzeResume($job_vacancy, array $resumeData): array
    {
        try {
            $prompt = "Compare this resume data with the job requirements. Return ONLY JSON with:
                       'aiGeneratedScore' (0-100) and 'aiGeneratedFeedback' (brief string).

                       Job: " . json_encode([
                            'title' => $job_vacancy->utils, // تأكد إن الحقل ده صح في الداتابيز عندك
                            'description' => $job_vacancy->description
                       ]) . "

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

            return json_decode($response->json('candidates.0.content.parts.0.text'), true)
                   ?? ['aiGeneratedScore' => 0, 'aiGeneratedFeedback' => 'Error in analysis.'];

        } catch (\Throwable $e) {
            Log::error('Resume Analysis Failed: ' . $e->getMessage());
            return ['aiGeneratedScore' => 0, 'aiGeneratedFeedback' => 'Service unavailable.'];
        }
    }

    /**
     * Helper to return consistent structure
     */
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
