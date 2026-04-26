<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class ResumesAnalysisServices
{
    protected string $baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-flash-latest:generateContent';

    public function __construct()
    {
        if (empty(config('services.gemini.key'))) {
            Log::error('Gemini API key is missing in configuration.');
        }
    }

    /**
     * الخطوة الأولى: استخراج البيانات من الـ CV
     */
    public function extractResumeInformation(string $fileUri): array
    {
        try {
            if (!Storage::disk('cloud')->exists($fileUri)) {
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
                            ['text' => "Extract resume details and return ONLY a valid JSON object with keys: summary (string), skills (array of strings), experience (array of objects), education (array of objects). No markdown, no explanation."],
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
                ]
            ]);

            // Handle Rate Limit (Free Tier)
            if ($response->status() === 429) {
                Log::warning('Gemini Rate Limit Hit (Extraction). Sleeping for 15 seconds...');
                sleep(15);
                $response = Http::withHeaders([
                    'x-goog-api-key' => config('services.gemini.key'),
                    'Content-Type'   => 'application/json',
                ])->post($this->baseUrl, [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => "Extract resume details and return ONLY a valid JSON object with keys: summary (string), skills (array of strings), experience (array of objects), education (array of objects). No markdown, no explanation."],
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
                    ]
                ]);
            }

            if ($response->failed()) {
                Log::error('Gemini Extraction Error: ' . $response->status() . ' ' . $response->body());
                return $this->emptySchema();
            }

            $text = $response->json('candidates.0.content.parts.0.text');
            $text = preg_replace('/```json\s*(.*?)\s*```/is', '$1', $text);
            $text = preg_replace('/```\s*(.*?)\s*```/is', '$1', $text);
            return json_decode($text, true) ?? $this->emptySchema();

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
            $jobInfo = [
                'title' => $job_vacancy->title ?? $job_vacancy->utils ?? 'Software Engineer',
                'description' => $job_vacancy->description ?? ''
            ];

            $prompt = "Compare this resume with the job requirements. Return ONLY a valid JSON object with exactly these keys: {\"aiGeneratedScore\": int between 0-100, \"aiGeneratedFeedback\": string}. No markdown, no code blocks, just raw JSON.\n\nJob: " . json_encode($jobInfo) . "\n\nResume: " . json_encode($resumeData);

            $response = Http::withHeaders([
                'x-goog-api-key' => config('services.gemini.key'),
                'Content-Type'   => 'application/json',
            ])->post($this->baseUrl, [
                'contents' => [
                    ['parts' => [['text' => $prompt]]]
                ],
                'generationConfig' => [
                    'temperature' => 0.2,
                ]
            ]);

            // Handle Rate Limit (Free Tier)
            if ($response->status() === 429) {
                Log::warning('Gemini Rate Limit Hit (Analysis). Sleeping for 15 seconds...');
                sleep(15);
                $response = Http::withHeaders([
                    'x-goog-api-key' => config('services.gemini.key'),
                    'Content-Type'   => 'application/json',
                ])->post($this->baseUrl, [
                    'contents' => [
                        ['parts' => [['text' => $prompt]]]
                    ],
                    'generationConfig' => [
                        'temperature' => 0.2,
                    ]
                ]);
            }

            if ($response->failed()) {
                Log::error('Gemini Analysis Error: ' . $response->status() . ' ' . $response->body());
                return ['aiGeneratedScore' => 0, 'aiGeneratedFeedback' => 'Analysis failed.'];
            }

            $text = $response->json('candidates.0.content.parts.0.text');
            $text = preg_replace('/```json\s*(.*?)\s*```/is', '$1', $text);
            $text = preg_replace('/```\s*(.*?)\s*```/is', '$1', $text);
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
