<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bitacora extends Model
{
    use HasFactory;
    protected $table = 'bitacora_trabajo';
    protected $primaryKey = 'id_bitacora';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_bitacora',
        'estado',
        'fecha_reg',
        'id_actividad',
        'doc_ref',
        'descripcion',
        'fecha_aten',
        'doc_aten',
        'id_oficina',
        'id_usuario'
    ];

    protected $casts = [
        'fecha_reg' => 'datetime',
        'fecha_aten' => 'datetime'
    ];

    public function actividad()
    {
        return $this->belongsTo(Actividad::class, 'id_actividad', 'id_actividad');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    public function oficina()
    {
        return $this->belongsTo(Oficina::class, 'id_oficina', 'id_oficina');
    }

    // Método para obtener el nombre del estado
    public function getEstadoNombre()
    {
        switch ($this->estado) {
            case 1:
                return 'Pendiente';
            case 2:
                return 'En Proceso';
            case 3:
                return 'Atendido';
            case 4: 
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
                return 'badge-info-lighten'; // Azul para Pendiente
            case 2:
                return 'badge-warning-lighten'; // Amarillo para En Proceso
            case 3:
                return 'badge-success-lighten'; // Verde para Atendido
            case 4:  
                return 'badge-danger-lighten'; // Rojo para Cancelado
            default:
                return 'badge-danger-lighten'; // Rojo para Cancelado
        }
    }

    // Método para obtener el icono según el estado
    public function getEstadoIcono()
    {
        switch ($this->estado) {
            case 1:
                return 'mdi mdi-clock-outline'; // Icono de reloj para "Pendiente"
            case 2:
                return 'mdi mdi-progress-clock'; // Icono de progreso para "En Proceso"
            case 3:
                return 'mdi mdi-check-circle-outline'; // Icono de check para "Atendido"
            case 4:
                return 'mdi mdi-cancel'; // Icono de cancelado
            default:
                return 'mdi mdi-alert-circle-outline'; // Icono por defecto (Cancelado)
        }
    }

    // Boot method para generar el ID personalizado
    protected static function boot()
    {
        parent::boot();
 
        static::creating(function ($model) {
             $model->id_bitacora = $model->generateCustomId();
        });
    }

     // Método para generar el ID personalizado
    protected function generateCustomId()
    {
        // Obtener el último ID generado
        $lastBitacora = self::orderBy('id_bitacora', 'desc')->first();

        if ($lastBitacora) {
            // Extraer el número del ID y sumarle 1
            $lastIdNumber = intval(substr($lastBitacora->id_bitacora, 3)) + 1;
        } else {
            // Si no hay registros, comenzar en 1
            $lastIdNumber = 1;
        }

        // Formatear el ID con el prefijo 'usu' y ceros a la izquierda
        return 'bit' . str_pad($lastIdNumber, 4, '0', STR_PAD_LEFT);
    }

}
