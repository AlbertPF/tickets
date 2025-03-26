<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    use HasFactory;

    protected $table = 'personals';
    protected $primaryKey = 'id_personal';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_personal',
        'dni',
        'nombre',
        'apellidoPaterno',
        'apellidoMaterno',
        'estado',
        'telefono',
        'id_rl',
    ];

    public function oficinaPersonals() 
    {
        return $this->hasMany(OficinaPersonal::class, 'id_personal', 'id_personal');
    }

    public function oficinaPersonal()
    {
        return $this->hasOne(OficinaPersonal::class, 'id_personal', 'id_personal');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'id_personal', 'id_personal');
    }

    public function regimenLaboral()
    {
        return $this->belongsTo(Regimen_Laboral::class, 'id_rl', 'id_rl');
    }

    // Boot method para generar el ID personalizado
    protected static function boot()
    {
        parent::boot();
 
        static::creating(function ($model) {
             $model->id_personal = $model->generateCustomId();
        });
    }

     // Método para generar el ID personalizado
    protected function generateCustomId()
    {
        // Obtener el último ID generado
        $lastPersonal = self::orderBy('id_personal', 'desc')->first();

        if ($lastPersonal) {
            // Extraer el número del ID y sumarle 1
            $lastIdNumber = intval(substr($lastPersonal->id_personal, 3)) + 1;
        } else {
            // Si no hay registros, comenzar en 1
            $lastIdNumber = 1;
        }

        // Formatear el ID con el prefijo 'usu' y ceros a la izquierda
        return 'per' . str_pad($lastIdNumber, 4, '0', STR_PAD_LEFT);
    }

}
