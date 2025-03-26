<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soporte extends Model
{
    use HasFactory;

    protected $table = 'soportes';
    protected $primaryKey = 'id_soporte';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_soporte',
        'nombre',
        'descripcion',
        'estado',
        'created_at',
        'updated_at'
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'id_soporte', 'id_soporte');
    }

    // Método para obtener el nombre del estado
    public function getEstadoNombre()
    {
        switch ($this->estado) {
            case 0:
                return 'Desactivado';
            case 1:
                return 'Activo';
        }
    }

    // Método para obtener la clase CSS según el estado
    public function getEstadoClase()
    {
        switch ($this->estado) {
            case 0:
                return 'badge-danger-lighten';
            case 1:
                return 'badge-success-lighten';
        }
    }

    public function getEstadoIcono()
    {
        switch ($this->estado) {
            case 0:
                return 'mdi mdi-cancel'; 
            case 1:
                return 'mdi mdi-check-circle-outline'; 
            
            /*default:
                return 'mdi mdi-alert-circle-outline'; // Icono por defecto (Cancelado)*/
        }
    }

    // Boot method para generar el ID personalizado
    protected static function boot()
    {
        parent::boot();
 
        static::creating(function ($model) {
             $model->id_soporte = $model->generateCustomId();
        });
    }

    // Método para generar el ID personalizado
    protected function generateCustomId()
    {
        // Obtener el último ID generado
        $lastSoporte = self::orderBy('id_soporte', 'desc')->first();

        if ($lastSoporte) {
            // Extraer el número del ID y sumarle 1
            $lastIdNumber = intval(substr($lastSoporte->id_soporte, 3)) + 1;
        } else {
            // Si no hay registros, comenzar en 1
            $lastIdNumber = 1;
        }

        // Formatear el ID con el prefijo 'usu' y ceros a la izquierda
        return 'spt' . str_pad($lastIdNumber, 4, '0', STR_PAD_LEFT);
    }

}
