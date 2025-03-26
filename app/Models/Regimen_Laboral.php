<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regimen_Laboral extends Model
{
    use HasFactory;

    protected $table = 'regimen_laborals';
    protected $primaryKey = 'id_rl';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_rl',
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
             $model->id_rl = $model->generateCustomId();
        });
    }

    // Método para generar el ID personalizado
    protected function generateCustomId()
    {
        // Obtener el último ID generado
        $lastRLabotral = self::orderBy('id_rl', 'desc')->first();

        if ($lastRLabotral) {
            // Extraer el número del ID y sumarle 1
            $lastIdNumber = intval(substr($lastRLabotral->id_rl, 3)) + 1;
        } else {
            // Si no hay registros, comenzar en 1
            $lastIdNumber = 1;
        }

        // Formatear el ID con el prefijo 'usu' y ceros a la izquierda
        return 'rlb' . str_pad($lastIdNumber, 4, '0', STR_PAD_LEFT);
    }

}
