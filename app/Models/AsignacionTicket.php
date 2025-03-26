<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsignacionTicket extends Model
{
    use HasFactory;

    protected $table = 'asignacion_ticket';
    protected $primaryKey = 'id_Asigticket';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'estado',
        'id_Asigticket',
        'fecha_asig',
        'fecha_fin',
        'descripcion',
        'id_ticket',
        'id_usuario'
    ];   

    // Relación con ticket
    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'id_ticket', 'id_ticket');
    }

    // Relación con usuario (si usas un modelo Usuario)
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
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
             $model->id_Asigticket = $model->generateCustomId();
        });
    }

     // Método para generar el ID personalizado
    protected function generateCustomId()
    {
        // Obtener el último ID generado
        $lastAsigTickets = self::orderBy('id_Asigticket', 'desc')->first();

        if ($lastAsigTickets) {
            // Extraer el número del ID y sumarle 1
            $lastIdNumber = intval(substr($lastAsigTickets->id_Asigticket, 3)) + 1;
        } else {
            // Si no hay registros, comenzar en 1
            $lastIdNumber = 1;
        }

        // Formatear el ID con el prefijo 'usu' y ceros a la izquierda
        return 'atk' . str_pad($lastIdNumber, 4, '0', STR_PAD_LEFT);
    }
}
