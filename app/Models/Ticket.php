<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $table = 'tickets';
    protected $primaryKey = 'id_ticket';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_ticket',
        'estado',
        'fecha_env',
        'descripcion',
        'id_soporte',
        'id_OfiPer'
    ];

    public function asignaciones()
    {
        return $this->hasMany(AsignacionTicket::class, 'id_ticket', 'id_ticket');
    }

    public function personal()
    {
        return $this->belongsTo(Personal::class, 'id_personal');
    }

    public function oficinaPersonal()
    {
        return $this->belongsTo(OficinaPersonal::class, 'id_OfiPer', 'id_OfiPer');
    }    

    public function soporte()
    {
        return $this->belongsTo(Soporte::class, 'id_soporte');
    }

    public function oficina()
    {
        return $this->belongsTo(Oficina::class, 'id_oficina');
    }

    // Método para obtener el nombre del estado
    public function getEstadoNombre()
    {
        switch ($this->estado) {
            case 1:
                return 'Pendiente';
            case 2:
                return 'En proceso';
            case 3:
                return 'Atendido';
            case 4: 
                return 'No logrado';   
            case 5: 
                return 'Cancelado';  
            default:
                return 'Cancelado';
        }
    }

    // Método para obtener la clase CSS según el estado
    public function getEstadoClase()
    {
        switch ($this->estado) {
            case 1:
                return 'badge-info-lighten';
            case 2:
                return 'badge-warning-lighten';
            case 3:
                return 'badge-success-lighten';
            case 4:  
                return 'badge-secondary-lighten'; 
            case 5:  
                return 'badge-danger-lighten'; 
            default:
                return 'badge-danger-lighten';
        }
    }

    public function getEstadoIcono()
    {
        switch ($this->estado) {
            case 1:
                return 'mdi mdi-file-document'; // Icono para "Registrado"
            case 2:
                return 'mdi mdi-progress-clock'; // Icono para "En proceso"
            case 3:
                return 'mdi mdi-check-circle-outline'; // Icono para "Atendido"
            case 4:
                return 'mdi mdi-close-circle-outline'; // Icono para "No logrado"
            case 5:
                return 'mdi mdi-cancel'; // Icono para "Cancelado"
            default:
                return 'mdi mdi-alert-circle-outline'; // Icono por defecto (Cancelado)
        }
    }

    // Boot method para generar el ID personalizado
    protected static function boot()
    {
        parent::boot();
 
        static::creating(function ($model) {
             $model->id_ticket = $model->generateCustomId();
        });
    }

     // Método para generar el ID personalizado
    protected function generateCustomId()
    {
        // Obtener el último ID generado
        $lastTicket = self::orderBy('id_ticket', 'desc')->first();

        if ($lastTicket) {
            // Extraer el número del ID y sumarle 1
            $lastIdNumber = intval(substr($lastTicket->id_ticket, 3)) + 1;
        } else {
            // Si no hay registros, comenzar en 1
            $lastIdNumber = 1;
        }

        // Formatear el ID con el prefijo 'usu' y ceros a la izquierda
        return 'tik' . str_pad($lastIdNumber, 4, '0', STR_PAD_LEFT);
    }
}
