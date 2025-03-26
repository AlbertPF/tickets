<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OficinaPersonal extends Model
{
    use HasFactory;

    protected $table = 'oficina_personals';
    protected $primaryKey = 'id_OfiPer';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_OfiPer', 
        'estado',
        'anio',
        'id_oficina',
        'id_personal'
    ];

    // Define la relación con el modelo Oficina
    public function oficina()
    {
        return $this->belongsTo(Oficina::class, 'id_oficina', 'id_oficina' );
    }

    public function personal()
    {
        return $this->belongsTo(Personal::class, 'id_personal', 'id_personal');
    }

    // Boot method para generar el ID personalizado
    protected static function boot()
    {
        parent::boot();
 
        static::creating(function ($model) {
             $model->id_OfiPer = $model->generateCustomId();
        });
    }

     // Método para generar el ID personalizado
    protected function generateCustomId()
    {
        // Obtener el último ID generado
        $lastOfiPer = self::orderBy('id_OfiPer', 'desc')->first();

        if ($lastOfiPer) {
            // Extraer el número del ID y sumarle 1
            $lastIdNumber = intval(substr($lastOfiPer->id_OfiPer, 3)) + 1;
        } else {
            // Si no hay registros, comenzar en 1
            $lastIdNumber = 1;
        }

        // Formatear el ID con el prefijo 'usu' y ceros a la izquierda
        return 'aop' . str_pad($lastIdNumber, 4, '0', STR_PAD_LEFT);
    }

}
