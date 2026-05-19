<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\GeminiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use RuntimeException;
use Throwable;

class GeminiApiController extends Controller
{
    public function chat(Request $request, GeminiService $gemini): JsonResponse
    {
        $data = $request->validate([
            'message' => 'required|string|max:8000',
            'history' => 'sometimes|array',
            'history.*.role' => 'required_with:history|in:user,model',
            'history.*.text' => 'required_with:history|string',
        ]);

        try {
            $result = $gemini->chat($data['message'], $data['history'] ?? []);
        } catch (RuntimeException $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 502);
        } catch (Throwable $e) {
            return response()->json([
                'message' => 'Error inesperado al consultar Gemini.',
                'error' => $e->getMessage(),
            ], 500);
        }

        return response()->json([
            'reply' => $result['text'],
        ]);
    }
}
