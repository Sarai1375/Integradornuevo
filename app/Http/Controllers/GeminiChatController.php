<?php

namespace App\Http\Controllers;

use App\Services\GeminiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use RuntimeException;
use Throwable;

class GeminiChatController extends Controller
{
    public function index(): View
    {
        return view('chat.gemini', [
            'model' => config('services.gemini.model', 'gemini-2.5-flash'),
            'configured' => config('services.gemini.api_key') !== null && config('services.gemini.api_key') !== '',
        ]);
    }

    public function send(Request $request, GeminiService $gemini): JsonResponse
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
            return response()->json(['message' => $e->getMessage()], 502);
        } catch (Throwable $e) {
            return response()->json([
                'message' => 'Error inesperado al consultar Gemini.',
                'error' => $e->getMessage(),
            ], 500);
        }

        return response()->json(['reply' => $result['text']]);
    }
}
