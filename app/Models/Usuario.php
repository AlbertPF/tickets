<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_usuario',
        'dni',
        'nombre',
        'apellidoPaterno',
        'apellidoMaterno',
        'usuario',
        'password',
        'tipo',
        'telefono',
        'remember_token',
        'created_at',
        'updated_at'
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'id_usuario', 'id_usuario');
    }

    // Boot method para generar el ID personalizado
    protected static function boot()
    {
        parent::boot();
 
        static::creating(function ($model) {
             $model->id_usuario = $model->generateCustomId();
        });
    }

     // Método para generar el ID personalizado
    protected function generateCustomId()
    {
        // Obtener el último ID generado
        $lastUser = self::orderBy('id_usuario', 'desc')->first();

        if ($lastUser) {
            // Extraer el número del ID y sumarle 1
            $lastIdNumber = intval(substr($lastUser->id_usuario, 3)) + 1;
        } else {
            // Si no hay registros, comenzar en 1
            $lastIdNumber = 1;
        }

        // Formatear el ID con el prefijo 'usu' y ceros a la izquierda
        return 'usu' . str_pad($lastIdNumber, 4, '0', STR_PAD_LEFT);
    }
    
}
