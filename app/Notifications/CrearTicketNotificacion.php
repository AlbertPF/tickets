<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;
use NotificationChannels\Telegram\TelegramMessage;

class CrearTicketNotificacion extends Notification
{
    use Queueable;

    protected $ticket;
    protected $originUser;

    public function __construct($ticket, $originUser = null)
    {
        $this->ticket = $ticket;
        $this->originUser = $originUser;
        $this->afterCommit();
    }

  
    public function via(object $notifiable): array
    {
        return ['telegram'];
    }

    public function toTelegram(object $notifiable)
    {
        //$url = route('tickets.mostrar', );
        //$url = 'https://app5.regionapurimac.gob.pe/gr-tickets/public/tickets/' . $this->ticket->id_ticket;
        $url = 'http://127.0.0.1:8000/tickets/' . $this->ticket->id_ticket;

        //$botUsername = 'GoreApurimacTicketsBot';
        $botUsername = 'GoreApurimacTicketsDevBot';
        $urlAsignar = "https://t.me/{$botUsername}?start=asignar_{$this->ticket->id_ticket}";

        $fecha = optional($this->ticket->fecha_env)->format('d/m/Y H:i') ?? now()->format('d/m/Y H:i');

        $nombreCompleto = $this->ticket->oficinaPersonal->personal->nombre .' '. 
                        $this->ticket->oficinaPersonal->personal->apellidoPaterno. ' '.
                        $this->ticket->oficinaPersonal->personal->apellidoMaterno;

        //$chatId = $notifiable->telegram_user_id;
        $content = "📢 *Nuevo Ticket Registrado*\n\n";
        $content .= "*ID:* `{$this->ticket->id_ticket}`\n";
        $content .= "*Soporte:* {$this->ticket->soporte->nombre}\n";
        $content .= "*Incidencia:* {$this->ticket->descripcion}\n";
        $content .= "*Registrado por:* {$nombreCompleto}\n";
        $content .= "*Oficina:* {$this->ticket->oficinaPersonal->oficina->nombre}\n";
        $content .= "*Fecha:* {$fecha}\n";

        if ($this->originUser) {
            $content .= "✍️ *Creado por:* {$this->originUser->nombre}\n";
        }

    return TelegramMessage::create()
            ->content($content)
            ->button('🔎 Ver Ticket', $url)
            ->button('✅ Asignarme', $urlAsignar)
            ->disableNotification(false);

        /*$token = env('TELEGRAM_BOT_TOKEN');
        $chatId = $notifiable->telegram_user_id;

        Http::post("https://api.telegram.org/bot{$token}/sendMessage", [
            'chat_id' => $chatId,
            'text' => $content,
            'parse_mode' => 'Markdown',
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [
                        ['text' => '🔎 Ver Ticket', 'url' => $url],
                        ['text' => '✅ Asignarme', 'callback_data' => 'asignar_'.$this->ticket->id_ticket],
                    ]
                ]
            ])
        ]);*/
    }

    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
