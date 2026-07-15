<?php

namespace App\Http\Controllers;

use App\Models\AsignacionTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Usuario;
use App\Models\Ticket;
use App\Models\ticket_notificacion;
use App\Support\DashboardDateRange;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TelegramController extends Controller
{
    public function webhook(Request $request)
    {
        Log::info('Webhook recibido', $request->all());
        // === BYPASS LOCAL TUNNEL SECURITY PAGE ===
        if ($request->query('bypass-tunnel-reminder')) {
            // Ignorar parámetro de localTunnel.
        }

        // Si no hay contenido (puede pasar), responder rápido.
        if (!$request->getContent()) {
            return response('No content', 200);
        }

        $update = $request->all();

        if (isset($update['callback_query'])) {
            $chatId = $update['callback_query']['from']['id'];
            $data = $update['callback_query']['data']; // ej: "asignar_tik2391"

            if (str_starts_with($data, 'asignar_')) {
                $idTicket = substr($data, strlen('asignar_'));
                $this->handleAsignar($chatId, $idTicket);

                // Responder al callback para quitar el reloj de espera.
                $token = config('services.telegram-bot-api.token') ?? env('TELEGRAM_BOT_TOKEN');
                Http::post("https://api.telegram.org/bot{$token}/answerCallbackQuery", [
                    'callback_query_id' => $update['callback_query']['id'],
                    'text' => "✅ Ticket {$idTicket} asignado correctamente",
                    'show_alert' => false
                ]);

                return response()->json(['ok' => true]);
            }
        }

        if (isset($update['message']['text'])) {
            $text = trim($update['message']['text']);
            $chatId = $update['message']['from']['id'];

            $parts = preg_split('/\s+/', $text);
            $command = strtolower($parts[0]);
            $command = preg_replace('/@.+$/', '', $command);

            //Log::info('Texto recibido: '.$text);
            //Log::info('Comando interpretado: '.$command);

            if (strpos($command, '/pendientes') === 0) {
                $limit = isset($parts[1]) && is_numeric($parts[1]) ? (int)$parts[1] : 10;
                return $this->handlePendientes($chatId, $limit);
            }

            if (strpos($command, '/comenzar') === 0) {
                $this->sendMessage(
                    $chatId,
                    "<b>Bienvenido al sistema de tickets</b>\n\n" .
                        "Podrás consultar y asignarte tickets directamente desde Telegram.",
                    'HTML'
                );
                $this->sendMessage($chatId, $this->helpText(), 'HTML');

                return response()->json(['ok' => true]);
            }

            if (strpos($command, '/ayuda') === 0) {
                $this->sendMessage($chatId, $this->helpText(), 'HTML');
                return response()->json(['ok' => true]);
            }

            if (strpos($command, '/asignar') === 0) {
                //$parts = preg_split('/\s+/', $text);
                if (!isset($parts[1])) {
                    $this->sendMessage($chatId, "Debes indicar un ID de ticket. Ejemplo: <code>/asignar tik123</code>", 'HTML');
                    return response()->json(['ok' => true]);
                }
                $idTicket = $parts[1];
                return $this->handleAsignar($chatId, $idTicket);
            }

            if (str_starts_with($text, '/start asignar_')) {
                $idTicket = substr($text, strlen('/start asignar_'));
                return $this->handleAsignar($chatId, $idTicket);
            }

            $this->sendMessage($chatId, "Comando no reconocido. Envía /pendientes para ver la lista de tickets pendientes o /ayuda para obtener ayuda.", 'HTML');
            return response()->json(['ok' => true]);
        }

        return response()->json(['ok' => true]);
    }

    protected function handlePendientes(int $chatId, int $limit = 10)
    {
        $usuario = Usuario::where('telegram_user_id', $chatId)->first();

        if (! $usuario) {
            $this->sendMessage(
                $chatId,
                "*No estás registrado*\n\nPor favor, contacta con el administrador para enlazar tu cuenta de Telegram con el sistema.",
                'Markdown'
            );
            return response()->json(['ok' => true]);
        }

        $tickets = Ticket::with(['soporte', 'oficinaPersonal.oficina', 'oficinaPersonal.personal'])
            ->whereIn('estado', [1, 4])
            ->orderBy('fecha_env', 'asc')
            ->limit($limit)
            ->get();

        if ($tickets->isEmpty()) {
            $this->sendMessage($chatId, "No hay tickets pendientes en este momento.", 'Markdown');
            return response()->json(['ok' => true]);
        }

        $chunks = [];
        $text = "<b>📋 Tickets pendientes (máx. {$limit})</b>\n\n";

        foreach ($tickets as $t) {
            $id = e($t->id_ticket);
            $soporte = e(optional($t->soporte)->nombre ?? 'N/A');
            $desc = trim(strip_tags($t->descripcion ?? ''));
            if (mb_strlen($desc) > 120) $desc = mb_substr($desc, 0, 117) . '...';
            $desc = e($desc);
            $oficina = e(optional($t->oficinaPersonal->oficina)->nombre ?? 'N/A');
            $nombrePersonal = e(optional($t->oficinaPersonal->personal)->nombre ?? '') . ' ' .
                e(optional($t->oficinaPersonal->personal)->apellidoPaterno ?? '');
            $fecha = $t->fecha_env;

            $text .= "<b>{$id}</b> 🛠️ {$soporte}\n";
            $text .= "<i>{$desc}</i>\n";
            $text .= "👤 {$nombrePersonal}\n";
            $text .= "🏢 {$oficina}\n";
            $text .= "🕒 {$fecha}\n";
            $text .= "👉 Para asignarte este ticket: <code>/asignar {$id}</code>\n";
            $text .= "────────────\n";

            if (mb_strlen($text) > 3500) {
                $chunks[] = $text;
                $text = '';
            }
        }

        if ($text !== '') $chunks[] = $text;

        foreach ($chunks as $chunk) {
            $this->sendMessage($chatId, $chunk, 'HTML');
        }

        return response()->json(['ok' => true]);
    }

    protected function handleAsignar(int $chatId, string $idTicket)
    {
        $usuario = Usuario::where('telegram_user_id', $chatId)->first();
        if (!$usuario) {
            $this->sendMessage(
                $chatId,
                "*No estás registrado*\n\nPor favor, contacta con el administrador para enlazar tu cuenta de Telegram con el sistema.",
                'Markdown'
            );
            return response()->json(['ok' => true]);
        }

        $ticket = Ticket::where('id_ticket', $idTicket)->first();

        if (!$ticket) {
            $this->sendMessage($chatId, "❌ Ticket <code>{$idTicket}</code> no encontrado.", 'HTML');
            return response()->json(['ok' => true]);
        }

        if ($ticket->estado != 1 &&  $ticket->estado != 4) {

            $estado = match ($ticket->estado) {
                '2' => 'en proceso',
                '3' => 'canalizado',
                '5' => 'cancelado',
                default => 'desconocido'
            };

            $this->sendMessage(
                $chatId,
                "⚠️ El ticket <code>{$idTicket}</code> ya no está disponible (estado actual: {$estado}).",
                'HTML'
            );

            $notificacion = ticket_notificacion::where('id_ticket', $ticket->id_ticket)
                ->where('id_usuario', $usuario->id_usuario)
                ->first();

            if ($notificacion && !$notificacion->abierta) {
                $notificacion->abierta = true;
                $notificacion->abierta_en = now();
                $notificacion->save();
            }

            return response()->json(['ok' => true]);
        }

        $primerTicketPendiente = Ticket::where('estado', 1)
            ->orderBy('fecha_env', 'asc')
            ->first();

        if ($primerTicketPendiente->id_ticket !== $ticket->id_ticket) {
            $this->sendMessage(
                $chatId,
                "⚠️ No puedes asignarte este ticket aún.\n" .
                    "Primero debes asignarte el ticket pendiente más antiguo: <code>{$primerTicketPendiente->id_ticket}</code>.",
                'HTML'
            );

            $notificacion = ticket_notificacion::where('id_ticket', $ticket->id_ticket)
                ->where('id_usuario', $usuario->id_usuario)
                ->first();

            if ($notificacion && !$notificacion->abierta) {
                $notificacion->abierta = true;
                $notificacion->abierta_en = now();
                $notificacion->save();
            }

            return response()->json(['ok' => true]);
        }

        $ticket->estado = 2;
        $ticket->save();

        AsignacionTicket::create([
            'estado' => '2',
            'fecha_asig' => Carbon::now('America/Lima'),
            'fecha_fin' => null,
            'descripcion' => null,
            'id_ticket' => $ticket->id_ticket,
            'id_usuario' => $usuario->id_usuario,
        ]);

        $notificacion = ticket_notificacion::where('id_ticket', $ticket->id_ticket)
            ->where('id_usuario', $usuario->id_usuario)
            ->first();

        if ($notificacion && !$notificacion->abierta) {
            $notificacion->abierta = true;
            $notificacion->abierta_en = now();
            $notificacion->save();
        }

        $this->sendMessage(
            $chatId,
            "✅ Te has asignado correctamente el ticket <code>{$idTicket}</code>.",
            'HTML'
        );

        return response()->json(['ok' => true]);
    }


    protected function sendMessage(int $chatId, string $text, string $parseMode = 'HTML')
    {

        $token = config('services.telegram-bot-api.token') ?? env('TELEGRAM_BOT_TOKEN');

        try {
            Http::post("https://api.telegram.org/bot{$token}/sendMessage", [
                'chat_id' => $chatId,
                'text' => $text,
                'parse_mode' => $parseMode,
                'disable_web_page_preview' => true,
            ])->throw();
            /*$response = Http::withoutVerifying() // opcional si est?s en ngrok free
                //->throw('false') // <--- evita excepci?n
                ->post("https://api.telegram.org/bot{$token}/sendMessage", [
                    'chat_id' => $chatId,
                    'text' => $text,
                    'parse_mode' => $parseMode,
                    'disable_web_page_preview' => true,
                ]);

            Log::info('Telegram response: '.$response->body());*/
        } catch (\Throwable $e) {
            Log::error('Telegram sendMessage error: ' . $e->getMessage());
        }
    }

    protected function helpText()
    {
        return implode("\n", [
            "<b>🤖 Comandos disponibles</b>",
            "/pendientes — Lista los tickets pendientes (por defecto, 10).",
            "/pendientes <code>n</code> — Lista hasta <code>n</code> tickets.",
            "/asignar <code>id</code> — Te asigna un ticket (requiere permisos).",
            "/ayuda — Muestra esta ayuda."
        ]);
    }

    public function getMetrics(Request $request)
    {
        $range = DashboardDateRange::fromRequest($request);
        $query = $range->apply(DB::table('ticket_notificacion'), 'enviada_en');

        // Total enviadas y abiertas
        $total = $query->count();
        $abiertas = (clone $query)->where('abierta', 1)->count();

        // MÃ©tricas principales
        $tasa_apertura = $total ? round(($abiertas / $total) * 100, 2) : 0;
        $no_abiertas = $total ? round(100 - $tasa_apertura, 2) : 0;

        $promedio_apertura = (clone $query)
            ->whereNotNull('abierta_en')
            ->selectRaw('AVG(TIMESTAMPDIFF(MINUTE, enviada_en, abierta_en)) as promedio')
            ->value('promedio');

        $promedio_apertura = round($promedio_apertura ?? 0, 2);

        $activityByUser = (clone $query)
            ->select('id_usuario')
            ->selectRaw('SUM(abierta) AS total_abiertas')
            ->groupBy('id_usuario');

        $usuarios_inactivos = DB::query()
            ->fromSub($activityByUser, 'actividad_usuario')
            ->selectRaw('AVG(CASE WHEN total_abiertas = 0 THEN 1 ELSE 0 END) * 100 AS porcentaje')
            ->value('porcentaje') ?? 0;

        // Tasa de apertura en el tiempo
        $apertura_tiempo = (clone $query)
            ->selectRaw('DATE(enviada_en) AS fecha, (SUM(abierta) / COUNT(*)) * 100 AS tasa')
            ->groupByRaw('DATE(enviada_en)')
            ->orderBy('fecha')
            ->get();

        // Usuarios mÃ¡s activos
        $usuarios_activos = (clone $query)
            ->join('usuarios as u', 'ticket_notificacion.id_usuario', '=', 'u.id_usuario')
            ->where('ticket_notificacion.abierta', 1)
            ->select('u.id_usuario')
            ->selectRaw("CONCAT(u.nombre, ' ', u.apellidoPaterno) AS nombre, COUNT(*) AS total")
            ->groupBy('u.id_usuario', 'u.nombre', 'u.apellidoPaterno')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        // Tasa de apertura por tipo de ticket
        $tasa_por_tipo = (clone $query)
            ->join('tickets as t', 'ticket_notificacion.id_ticket', '=', 't.id_ticket')
            ->join('soportes as s', 't.id_soporte', '=', 's.id_soporte')
            ->select('s.nombre as soporte')
            ->selectRaw('(SUM(ticket_notificacion.abierta) / COUNT(*)) * 100 AS tasa')
            ->groupBy('s.nombre')
            ->orderByDesc('tasa')
            ->get();

        // DistribuciÃ³n por hora del dÃ­a
        $distribucion_horas = (clone $query)
            ->selectRaw('HOUR(enviada_en) AS hora, COUNT(*) AS total')
            ->groupByRaw('HOUR(enviada_en)')
            ->orderBy('hora')
            ->get();

        return response()->json([
            'tasa_apertura' => round($tasa_apertura, 2),
            'no_abiertas' => round($no_abiertas, 2),
            'promedio_apertura' => round($promedio_apertura ?? 0, 2),
            'usuarios_inactivos' => round($usuarios_inactivos, 2),
            'apertura_tiempo' => $apertura_tiempo,
            'usuarios_activos' => $usuarios_activos,
            'tasa_por_tipo' => $tasa_por_tipo,
            'distribucion_horas' => $distribucion_horas,
        ]);
    }
}
