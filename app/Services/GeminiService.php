<?php

namespace App\Services;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class GeminiService
{
    private string $apiKey;
    private string $model;
    private string $baseUrl;
    private float $temperature;
    private int $maxOutputTokens;
    private ?string $systemPrompt;

    public function __construct()
    {
        $this->apiKey = (string) config('services.gemini.api_key');
        $this->model = (string) config('services.gemini.model', 'gemini-2.5-flash');
        $this->baseUrl = rtrim((string) config('services.gemini.base_url', 'https://generativelanguage.googleapis.com/v1beta'), '/');
        $this->temperature = (float) config('services.gemini.temperature', 0.7);
        $this->maxOutputTokens = (int) config('services.gemini.max_output_tokens', 1024);
        $this->systemPrompt = config('services.gemini.system_prompt');
    }

    /**
     * Envia un mensaje a Gemini con historial opcional.
     *
     * @param string $message  Mensaje del usuario.
     * @param array<int, array{role: string, text: string}> $history Historial previo.
     * @return array{text: string, raw: array}
     */
    public function chat(string $message, array $history = []): array
    {
        if ($this->apiKey === '') {
            throw new RuntimeException('GEMINI_API_KEY no esta configurada en .env');
        }

        $contents = [];

        foreach ($history as $turn) {
            $role = ($turn['role'] ?? 'user') === 'model' ? 'model' : 'user';
            $text = (string) ($turn['text'] ?? '');
            if ($text === '') {
                continue;
            }
            $contents[] = [
                'role' => $role,
                'parts' => [['text' => $text]],
            ];
        }

        $contents[] = [
            'role' => 'user',
            'parts' => [['text' => $message]],
        ];

        $payload = [
            'contents' => $contents,
            'generationConfig' => [
                'temperature' => $this->temperature,
                'maxOutputTokens' => $this->maxOutputTokens,
            ],
        ];

        if ($this->systemPrompt) {
            $payload['systemInstruction'] = [
                'parts' => [['text' => $this->systemPrompt]],
            ];
        }

        $url = "{$this->baseUrl}/models/{$this->model}:generateContent";

        try {
            $response = Http::timeout(30)
                ->withQueryParameters(['key' => $this->apiKey])
                ->acceptJson()
                ->asJson()
                ->post($url, $payload)
                ->throw()
                ->json();
        } catch (RequestException $e) {
            $body = $e->response?->body() ?? $e->getMessage();
            throw new RuntimeException("Error llamando a Gemini: {$body}", $e->getCode(), $e);
        }

        $text = $this->extractText($response);

        return [
            'text' => $text,
            'raw' => $response,
        ];
    }

    private function extractText(array $response): string
    {
        $candidates = $response['candidates'] ?? [];
        if (! isset($candidates[0]['content']['parts'])) {
            return '';
        }

        $parts = $candidates[0]['content']['parts'];
        $text = '';
        foreach ($parts as $part) {
            if (isset($part['text'])) {
                $text .= $part['text'];
            }
        }

        return trim($text);
    }
}
