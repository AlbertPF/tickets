<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\ChatbotInteraction;

class ChatbotController extends Controller
{
    // Modelos ordenados por prioridad/estabilidad
    private $models = [
        'primary' => 'meta-llama/llama-3.2-3b-instruct:free',
        'fallback1' => 'google/gemma-2-9b-it:free',
        'fallback2' => 'meta-llama/llama-4-maverick:free',
        'fallback3' => 'tngtech/deepseek-r1t2-chimera:free',
        'fallback4' => 'alibaba/tongyi-deepresearch-30b-a3b:free'
    ];


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
            'interaction_id' => $interaction->id
        ]);
    }

    public function endInteraction(Request $request)
    {
        $interactionId = $request->input('interaction_id');
        if ($interactionId) {
            $interaction = ChatbotInteraction::find($interactionId);
            if ($interaction && !$interaction->ended_at) { // Solo si no está ya finalizado
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
        $apiKey = env('OPENROUTER_API_KEY');

        if (empty($apiKey)) {
            Log::error('OPENROUTER_API_KEY no configurada');
            return response()->json(['error' => 'API key no configurada', 'success' => false], 500);
        }

        // Si no hay interaction_id, crear una nueva (fallback)
        if (!$interactionId) {
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

        // Intentar con cada modelo en orden de prioridad
        foreach ($this->models as $priority => $model) {
            Log::info("Intentando con modelo: $model (prioridad: $priority)");

            $result = $this->tryModel($model, $systemPrompt, $userMessage, $apiKey, $interactionId);

            if ($result['success']) {
                return $result['response'];
            }

            // Si es error 429, intentar con el siguiente modelo
            if ($result['status'] === 429) {
                Log::warning("Rate limit alcanzado para modelo $model, intentando siguiente...");
                continue;
            }

            // Si es otro tipo de error, devolver el error
            if ($result['status'] !== 429) {
                return $result['response'];
            }
        }

        // Si todos los modelos fallan, devolver respuesta de fallback y actualizar métricas
        $this->updateMetrics($interactionId, false, null, true); // Fallida, fallback
        return $this->getFallbackResponse();
    }

    private function tryModel($model, $systemPrompt, $userMessage, $apiKey, $interactionId)
    {
        try {
            sleep(1); // Pequeño delay para evitar rate limiting

            $response = Http::timeout(60)->withHeaders([
                'Authorization' => "Bearer $apiKey",
                'Content-Type' => 'application/json',
                'HTTP-Referer' => url('/'),
                'X-Title' => 'Sistema de Tickets - Chatbot',
            ])->retry(1, 2000)
                ->post('https://openrouter.ai/api/v1/chat/completions', [
                    'model' => $model,
                    'messages' => [
                        ['role' => 'system', 'content' => $systemPrompt],
                        ['role' => 'user', 'content' => $userMessage],
                    ],
                    'temperature' => 0.7,
                    'max_tokens' => $this->getMaxTokensForModel($model),
                ]);

            if ($response->successful()) {
                $responseData = $response->json();

                if (
                    isset($responseData['choices']) && !empty($responseData['choices']) &&
                    isset($responseData['choices'][0]['message']['content'])
                ) {

                    $aiReply = $responseData['choices'][0]['message']['content'];
                    Log::info('Respuesta procesada exitosamente', [
                        'model_used' => $model,
                        'aiReply' => $aiReply
                    ]);

                    // Actualizar métricas (éxito)
                    $this->updateMetrics($interactionId, true, $model, false);

                    return [
                        'success' => true,
                        'response' => response()->json([
                            'reply' => $aiReply,
                            'success' => true,
                            'model_used' => $model,
                            'tokens_used' => $responseData['usage']['total_tokens'] ?? 0
                        ])
                    ];
                }
            }

            $status = $response->status();
            Log::warning("Modelo $model falló con status: $status");

            // Actualizar métricas (fallida)
            $this->updateMetrics($interactionId, false, $model, false);

            return [
                'success' => false,
                'status' => $status,
                'response' => response()->json([
                    'error' => "Modelo $model no disponible temporalmente",
                    'success' => false
                ], 500)
            ];
        } catch (\Exception $e) {
            Log::error("Excepción con modelo $model", [
                'message' => $e->getMessage()
            ]);

            // Actualizar métricas (fallida)
            $this->updateMetrics($interactionId, false, $model, false);

            return [
                'success' => false,
                'status' => 500,
                'response' => response()->json([
                    'error' => 'Error interno del servidor',
                    'success' => false
                ], 500)
            ];
        }
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
                'is_fallback' => $isFallback
            ]);
        }
    }

    private function getMaxTokensForModel($model)
    {
        $tokenLimits = [
            'meta-llama/llama-3.2-3b-instruct:free' => 400,
            'google/gemma-2-9b-it:free' => 300,
            'microsoft/phi-3-mini-128k-instruct:free' => 350,
            'qwen/qwen-2-7b-instruct:free' => 350,
            'deepseek/deepseek-r1:free' => 250,
        ];

        return $tokenLimits[$model] ?? 300;
    }

    private function getSystemPrompt()
    {
        $path = storage_path('app/prompts/system_prompt.txt');

        if (file_exists($path)) {
            return file_get_contents($path);
        }

        // Mensaje por defecto en caso de que no se encuentre el archivo
        return "Eres un asistente técnico amigable. Si el problema es complejo, sugiere crear un ticket.";
    }

    private function getFallbackResponse()
    {
        Log::warning('Todos los modelos fallaron, usando respuesta de fallback');

        return response()->json([
            'reply' => 'El asistente está temporalmente ocupado. Para problemas frecuentes: **Impresora**: verifica que esté encendida y reinicia tanto impresora como PC. **Internet lento**: desconecta el router 30 segundos y reconéctalo. **PC lenta**: reinicia la computadora y cierra programas innecesarios. Si persiste el problema, por favor crea un ticket para asistencia personalizada.',
            'success' => true,
            'is_fallback' => true,
            'model_used' => 'fallback_system'
        ]);
    }

    public function getMetrics(Request $request)
    {
        $period = $request->get('period', 'total'); // 'day', 'week', 'month', 'total'

        // Query base
        $query = ChatbotInteraction::select('*');

        switch ($period) {
            case 'day':
                $query->where('started_at', '>=', now()->subDays(7));
                break;
            case 'week':
                $query->where('started_at', '>=', now()->subWeeks(4));
                break;
            case 'month':
                $query->where('started_at', '>=', now()->subMonths(12));
                break;
            case 'total':
            default:
                // Todas las interacciones
                break;
        }

        $interactions = $query->get();

        // Métricas totales
        $totalInteracciones = $interactions->count();
        $totalMensajes = $interactions->sum('message_count');
        $totalExitosas = $interactions->sum('successful_responses');
        $totalFallidas = $interactions->sum('failed_responses');
        $tasaExito = $totalMensajes > 0 ? round(($totalExitosas / $totalMensajes) * 100, 2) : 0;

        // Modelos más usados (top 5)
        // $modelosUsados = ChatbotInteraction::selectRaw('model_used, COUNT(*) as count')
        //     ->whereNotNull('model_used')
        //     ->groupBy('model_used')
        //     ->orderByDesc('count')
        //     ->limit(5)
        //     ->get();

        // Modelos más usados (top 5 con conteo > 0)
        $modelosUsados = ChatbotInteraction::selectRaw('model_used, COUNT(*) as count')
            ->whereNotNull('model_used')
            ->groupBy('model_used')
            ->havingRaw('COUNT(*) > 0') // Solo con conteo > 0
            ->orderByDesc('count')
            ->limit(5)
            ->get()
            ->pluck('count', 'model_used')
            ->toArray();

        // Datos para gráficos
        $labels = [];
        $dataInteracciones = [];
        $dataMensajes = [];
        $dataExitosas = [];
        $dataFallidas = [];

        if ($period !== 'total') {
            // Agrupar por día/semana/mes
            $groupBy = $period === 'day' ? 'day' : ($period === 'week' ? 'week' : 'month');
            $grouped = $interactions->groupBy(function ($item) use ($groupBy) {
                return $item->started_at->format($groupBy === 'day' ? 'Y-m-d' : ($groupBy === 'week' ? 'Y-W' : 'Y-m'));
            });

            foreach ($grouped as $label => $group) {
                $labels[] = $label;
                $dataInteracciones[] = $group->count();
                $dataMensajes[] = $group->sum('message_count');
                $dataExitosas[] = $group->sum('successful_responses');
                $dataFallidas[] = $group->sum('failed_responses');
            }
        } else {
            // Para total, un solo punto
            $labels[] = 'Total';
            $dataInteracciones[] = $totalInteracciones;
            $dataMensajes[] = $totalMensajes;
            $dataExitosas[] = $totalExitosas;
            $dataFallidas[] = $totalFallidas;
        }

        return response()->json([
            'totalInteracciones' => $totalInteracciones,
            'totalMensajes' => $totalMensajes,
            'tasaExito' => $tasaExito,
            'totalFallidas' => $totalFallidas,
            'modelosUsados' => $modelosUsados,
            'labels' => $labels,
            'dataInteracciones' => $dataInteracciones,
            'dataMensajes' => $dataMensajes,
            'dataExitosas' => $dataExitosas,
            'dataFallidas' => $dataFallidas,
            'period' => $period,
        ]);
    }
}
