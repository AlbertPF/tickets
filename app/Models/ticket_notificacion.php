<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ticket_notificacion extends Model
{
    use HasFactory;

    protected $table = 'ticket_notificacion';
    protected $primaryKey = 'id_notificacion';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_notificacion',
        'id_ticket',
        'id_usuario',
        'abierta',
        'enviada_en',
        'abierta_en',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'id_ticket', 'id_ticket');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    // Boot method para generar el ID personalizado
    protected static function boot()
    {
        parent::boot();
 
        static::creating(function ($model) {
             $model->id_notificacion = $model->generateCustomId();
        });
    }

     // Método para generar el ID personalizado
    protected function generateCustomId()
    {
        // Obtener el último ID generado
        $lastTicketNot = self::orderByRaw(
            "CAST(SUBSTRING(id_notificacion, 4) AS UNSIGNED) DESC"
        )->first();

        if ($lastTicketNot) {
            // Extraer el número del ID y sumarle 1
            $lastIdNumber = intval(substr($lastTicketNot->id_notificacion, 3)) + 1;
        } else {
            // Si no hay registros, comenzar en 1
            $lastIdNumber = 1;
        }

        // Formatear el ID con el prefijo 'usu' y ceros a la izquierda
        return 'not' . str_pad($lastIdNumber, 4, '0', STR_PAD_LEFT);
    }
}
