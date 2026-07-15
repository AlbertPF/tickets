<?php

namespace App\Http\Controllers;

use App\Models\ChatbotInteraction;
use App\Support\DashboardDateRange;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;

class ChatbotController extends Controller
{
    private const RETRYABLE_STATUSES = [404, 408, 409, 425, 429, 500, 502, 503, 504];

    public function startInteraction(Request $request)
    {
        // Crear nueva interacción para métricas
        $interaction = ChatbotInteraction::create([
            'started_at' => now(),
            'message_count' => 0,
            'successful_responses' => 0,
            'failed_responses' => 0,
            'model_used' => null,
        ]);

        Log::info('Nueva interacción iniciada', ['interaction_id' => $interaction->id]);

        return response()->json([
            'success' => true,
            'interaction_id' => $interaction->id,
        ]);
    }

    public function endInteraction(Request $request)
    {
        $interactionId = $request->input('interaction_id');
        if ($interactionId) {
            $interaction = ChatbotInteraction::find($interactionId);
            if ($interaction && ! $interaction->ended_at) { // Solo si no está ya finalizado
                $interaction->update(['ended_at' => now()]);
                Log::info('Interacción finalizada con ended_at', ['interaction_id' => $interactionId]);
            }
        }

        return response()->json(['success' => true]);
    }

    public function handleMessage(Request $request)
    {
        Log::info('Chatbot request received', ['message' => $request->all()]);

        $request->validate([
            'message' => 'required|string|max:1000',
            'interaction_id' => 'nullable|integer', // ID de interacción para métricas
        ]);

        $userMessage = $request->input('message');
        $interactionId = $request->input('interaction_id');
        $apiKey = config('services.openrouter.key');

        if (empty($apiKey)) {
            Log::error('OPENROUTER_API_KEY no configurada');

            return response()->json(['error' => 'API key no configurada', 'success' => false], 500);
        }

        // Si no hay interaction_id, crear una nueva (fallback)
        if (! $interactionId) {
            $interaction = ChatbotInteraction::create([
                'started_at' => now(),
                'message_count' => 0,
                'successful_responses' => 0,
                'failed_responses' => 0,
                'model_used' => null,
            ]);
            $interactionId = $interaction->id;
            Log::info('Nueva interacción creada en handleMessage', ['interaction_id' => $interactionId]);
        }

        $systemPrompt = $this->getSystemPrompt();

        $lastResult = null;

        // Intentar con cada modelo en orden de prioridad.
        foreach ($this->getModels() as $priority => $model) {
            Log::info("Intentando con modelo: $model (prioridad: $priority)");

            $result = $this->tryModel($model, $systemPrompt, $userMessage, $apiKey);
            $lastResult = $result;

            if ($result['success']) {
                $this->updateMetrics($interactionId, true, $result['model_used'], false);

                return $result['response'];
            }

            if ($this->shouldTryNextModel($result['status'])) {
                Log::warning('Se intentará el siguiente modelo de OpenRouter', [
                    'model' => $model,
                    'status' => $result['status'],
                    'upstream_error' => $result['upstream_error'],
                ]);

                continue;
            }

            $this->updateMetrics($interactionId, false, $model, false);

            return $result['response'];
        }

        $this->updateMetrics($interactionId, false, null, true);

        // En desarrollo se devuelve el último error real para facilitar el diagnóstico.
        if (config('app.debug') && $lastResult) {
            return $lastResult['response'];
        }

        return $this->getFallbackResponse();
    }

    private function tryModel($model, $systemPrompt, $userMessage, $apiKey)
    {
        try {
            $response = Http::connectTimeout(10)->timeout(60)->withHeaders([
                'Authorization' => "Bearer $apiKey",
                'Content-Type' => 'application/json',
                'HTTP-Referer' => url('/'),
                'X-Title' => 'Sistema de Tickets - Chatbot',
            ])->retry(1, 2000)
                ->post(config('services.openrouter.endpoint'), [
                    'model' => $model,
                    'messages' => [
                        ['role' => 'system', 'content' => $systemPrompt],
                        ['role' => 'user', 'content' => $userMessage],
                    ],
                    'temperature' => 0.7,
                    'max_tokens' => config('services.openrouter.max_tokens', 2048),
                ]);

            if ($response->successful()) {
                $responseData = $response->json();

                if (
                    isset($responseData['choices']) && ! empty($responseData['choices']) &&
                    isset($responseData['choices'][0]['message']['content'])
                ) {

                    $aiReply = $responseData['choices'][0]['message']['content'];
                    $modelUsed = $responseData['model'] ?? $model;
                    Log::info('Respuesta procesada exitosamente', [
                        'model_requested' => $model,
                        'model_used' => $modelUsed,
                        'aiReply' => $aiReply,
                    ]);

                    return [
                        'success' => true,
                        'status' => $response->status(),
                        'upstream_error' => null,
                        'model_used' => $modelUsed,
                        'response' => response()->json([
                            'reply' => $aiReply,
                            'success' => true,
                            'model_used' => $modelUsed,
                            'tokens_used' => $responseData['usage']['total_tokens'] ?? 0,
                        ]),
                    ];
                }

                return $this->failedModelResult(
                    $model,
                    502,
                    'OpenRouter respondió correctamente, pero no incluyó contenido en choices[0].message.content.'
                );
            }

            $status = $response->status();
            $upstreamError = $this->getOpenRouterError($response->json(), $response->body());

            return $this->failedModelResult($model, $status, $upstreamError);
        } catch (Throwable $e) {
            return $this->failedModelResult($model, 503, $e->getMessage(), $e);
        }
    }

    private function failedModelResult($model, $status, $upstreamError, ?Throwable $exception = null)
    {
        $logContext = [
            'model' => $model,
            'status' => $status,
            'upstream_error' => $upstreamError,
        ];

        if ($exception) {
            $logContext['exception'] = get_class($exception);
        }

        Log::warning('Falló una solicitud a OpenRouter', $logContext);

        $publicMessage = config('app.debug')
            ? "OpenRouter ($status) [$model]: $upstreamError"
            : 'El asistente no pudo procesar la solicitud en este momento.';

        return [
            'success' => false,
            'status' => (int) $status,
            'upstream_error' => $upstreamError,
            'response' => response()->json([
                'error' => $publicMessage,
                'success' => false,
                'model_used' => $model,
            ], $this->validHttpStatus($status)),
        ];
    }

    private function getOpenRouterError($responseData, $responseBody)
    {
        $message = data_get($responseData, 'error.message')
            ?? data_get($responseData, 'message')
            ?? $responseBody
            ?? 'OpenRouter no devolvió detalles del error.';

        $message = trim((string) $message);

        return Str::limit($message ?: 'OpenRouter no devolvió detalles del error.', 1000);
    }

    private function shouldTryNextModel($status)
    {
        return in_array((int) $status, self::RETRYABLE_STATUSES, true);
    }

    private function validHttpStatus($status)
    {
        $status = (int) $status;

        return $status >= 400 && $status <= 599 ? $status : 503;
    }

    private function getModels()
    {
        return array_values(array_filter(
            config('services.openrouter.models', ['openrouter/free']),
            fn ($model) => is_string($model) && trim($model) !== ''
        ));
    }

    private function updateMetrics($interactionId, $isSuccessful, $modelUsed, $isFallback)
    {
        $interaction = ChatbotInteraction::find($interactionId);
        if ($interaction) {
            $interaction->increment('message_count');
            if ($isSuccessful) {
                $interaction->increment('successful_responses');
            } else {
                $interaction->increment('failed_responses');
            }
            if ($modelUsed) {
                $interaction->update(['model_used' => $modelUsed]);
            }
            Log::info('Métricas actualizadas', [
                'interaction_id' => $interactionId,
                'message_count' => $interaction->message_count,
                'successful_responses' => $interaction->successful_responses,
                'failed_responses' => $interaction->failed_responses,
                'model_used' => $modelUsed,
                'is_fallback' => $isFallback,
            ]);
        }
    }

    private function getSystemPrompt()
    {
        $path = storage_path('app/prompts/system_prompt.txt');

        if (file_exists($path)) {
            return file_get_contents($path);
        }

        // Mensaje por defecto en caso de que no se encuentre el archivo
        return 'Eres un asistente técnico amigable. Si el problema es complejo, sugiere crear un ticket.';
    }

    private function getFallbackResponse()
    {
        Log::warning('Todos los modelos fallaron, usando respuesta de fallback');

        return response()->json([
            'reply' => 'El asistente está temporalmente ocupado. Para problemas frecuentes: **Impresora**: verifica que esté encendida y reinicia tanto impresora como PC. **Internet lento**: desconecta el router 30 segundos y reconéctalo. **PC lenta**: reinicia la computadora y cierra programas innecesarios. Si persiste el problema, por favor crea un ticket para asistencia personalizada.',
            'success' => true,
            'is_fallback' => true,
            'model_used' => 'fallback_system',
        ]);
    }

    public function getMetrics(Request $request)
    {
        $range = DashboardDateRange::fromRequest($request);
        $interactions = $range
            ->apply(ChatbotInteraction::query(), 'started_at')
            ->orderBy('started_at')
            ->get();

        // Métricas totales
        $totalInteracciones = $interactions->count();
        $totalMensajes = $interactions->sum('message_count');
        $totalExitosas = $interactions->sum('successful_responses');
        $totalFallidas = $interactions->sum('failed_responses');
        $tasaExito = $totalMensajes > 0 ? round(($totalExitosas / $totalMensajes) * 100, 2) : 0;

        $modelosUsados = $interactions
            ->whereNotNull('model_used')
            ->countBy('model_used')
            ->sortDesc()
            ->take(5)
            ->all();

        // Datos para gráficos
        $labels = [];
        $dataInteracciones = [];
        $dataMensajes = [];
        $dataExitosas = [];
        $dataFallidas = [];

        $granularity = match (true) {
            $range->inclusiveDays() <= 45 => 'day',
            $range->inclusiveDays() <= 370 => 'week',
            default => 'month',
        };

        $grouped = $interactions->groupBy(function ($interaction) use ($granularity) {
            return match ($granularity) {
                'day' => $interaction->started_at->toDateString(),
                'week' => $interaction->started_at->copy()->startOfWeek()->toDateString(),
                default => $interaction->started_at->format('Y-m'),
            };
        });

        foreach ($grouped as $label => $group) {
            $labels[] = $label;
            $dataInteracciones[] = $group->count();
            $dataMensajes[] = $group->sum('message_count');
            $dataExitosas[] = $group->sum('successful_responses');
            $dataFallidas[] = $group->sum('failed_responses');
        }

        return response()->json([
            'totalInteracciones' => $totalInteracciones,
            'totalMensajes' => $totalMensajes,
            'totalExitosas' => $totalExitosas,
            'tasaExito' => $tasaExito,
            'totalFallidas' => $totalFallidas,
            'modelosUsados' => $modelosUsados,
            'labels' => $labels,
            'dataInteracciones' => $dataInteracciones,
            'dataMensajes' => $dataMensajes,
            'dataExitosas' => $dataExitosas,
            'dataFallidas' => $dataFallidas,
            'period' => 'range',
            'granularity' => $granularity,
        ]);
    }
}
