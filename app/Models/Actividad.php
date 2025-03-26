<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    use HasFactory;

    protected $table = 'actividades';
    protected $primaryKey = 'id_actividad';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_actividad',
        'nombre',
        'descripcion',
        'created_at',
        'updated_at'
    ];

    // Boot method para generar el ID personalizado
    protected static function boot()
    {
        parent::boot();
 
        static::creating(function ($model) {
             $model->id_actividad = $model->generateCustomId();
        });
    }

    // Método para generar el ID personalizado
    protected function generateCustomId()
    {
        // Obtener el último ID generado
        $lastActividad = self::orderBy('id_actividad', 'desc')->first();

        if ($lastActividad) {
            // Extraer el número del ID y sumarle 1
            $lastIdNumber = intval(substr($lastActividad->id_actividad, 3)) + 1;
        } else {
            // Si no hay registros, comenzar en 1
            $lastIdNumber = 1;
        }

        // Formatear el ID con el prefijo 'usu' y ceros a la izquierda
        return 'act' . str_pad($lastIdNumber, 4, '0', STR_PAD_LEFT);
    }
}
