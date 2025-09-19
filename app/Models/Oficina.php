<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Oficina extends Model
{
    use HasFactory;

    protected $table = 'oficinas';
    protected $primaryKey = 'id_oficina';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_oficina',
        'codigo',
        'nombre',
        'descripcion',
        'anio',
        'id_oficina_padre',
        'created_at',
        'updated_at',
    ];

    public $isDuplicated = false;

    public function oficinaPersonal()
    {
        return $this->belongsTo(OficinaPersonal::class, 'id_OfiPer', 'id_OfiPer');
    }   

    public function oficinaPersonals() 
    {
        return $this->hasMany(OficinaPersonal::class, 'id_personal', 'id_personal');
    }

    public function oficinasPadre()
    {
        return $this->belongsTo(Oficina::class, 'id_oficina_padre', 'id_oficina');
    }

    // Relación para obtener las subcategorías
    public function subOficinas()
    {
        return $this->hasMany(Oficina::class, 'id_oficina_padre', 'id_oficina');
    }

    public function subsubOficinas()
    {
        return $this->hasMany(Oficina::class, 'id_oficina_padre', 'id_oficina');
    }

    // Boot method para generar el ID personalizado
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {

            $model->id_oficina = $model->generateCustomId();

             if (!$model->isDuplicated) {
                $model->codigo = $model->generateOfficeCode();
            }
    
        });
    }

    // Método para duplicar
    public function duplicate()
    {
        // Crear una réplica del modelo sin duplicar automáticamente ciertos campos
        $newOffice = $this->replicate();

        // Marcar la réplica como duplicada (esto es temporal y no se guarda en la base de datos)
        $newOffice->isDuplicated = true;

        // Eliminar el atributo antes de guardar
        unset($newOffice->isDuplicated);

        // Guardar la réplica
        $newOffice->save();

        return $newOffice;
    }

    // Método para generar el ID personalizado
    protected function generateCustomId()
    {
        // Obtener el último ID generado
        $lastOficina = self::orderBy('id_oficina', 'desc')->first();

        if ($lastOficina) {
            // Extraer el número del ID y sumarle 1
            $lastIdNumber = intval(substr($lastOficina->id_oficina, 3)) + 1;
        } else {
            // Si no hay registros, comenzar en 1
            $lastIdNumber = 1;
        }

        // Formatear el ID con el prefijo 'usu' y ceros a la izquierda
        return 'ofi' . str_pad($lastIdNumber, 4, '0', STR_PAD_LEFT);
    } 

    public function generateOfficeCode()
    {
        if ($this->isDuplicated) {
            // Obtener el máximo código como número
            $maxCode = self::whereNull('id_oficina_padre')
                ->whereRaw('codigo REGEXP "^[0-9]+$"') // Filtrar solo códigos numéricos
                ->max(DB::raw('CAST(codigo AS UNSIGNED)'));

            return $maxCode ? $maxCode + 1 : 1;
        }

        // Si no tiene una oficina padre, es de nivel 1
        if (is_null($this->id_oficina_padre)) {
            // Obtener el máximo código como número
            $maxCode = self::whereNull('id_oficina_padre')
                ->whereRaw('codigo REGEXP "^[0-9]+$"') // Filtrar solo códigos numéricos
                ->max(DB::raw('CAST(codigo AS UNSIGNED)'));

            return $maxCode ? $maxCode + 1 : 1;
        } else {
            // Si tiene una oficina padre, obtener el código de la oficina padre
            $parentOffice = self::find($this->id_oficina_padre);
            $parentCode = $parentOffice->codigo;

            // Buscar suboficinas con el mismo código de la oficina padre
            $maxSubCode = self::where('id_oficina_padre', $this->id_oficina_padre)
                ->where('codigo', 'like', "$parentCode.%")
                ->max('codigo');

            if ($maxSubCode) {
                // Extraer la última parte del código y sumarle 1
                $lastSegment = intval(substr($maxSubCode, strrpos($maxSubCode, '.') + 1)) + 1;
                return $parentCode . '.' . $lastSegment;
            } else {
                // Si no existen suboficinas, comenzar con .1
                return $parentCode . '.1';
            }
        }
    }

    /*public function generateOfficeCode()
    {
        if ($this->isDuplicated) {
            // Encontrar el máximo código de nivel 1
            $maxCode = self::whereNull('id_oficina_padre')->max('codigo');
            return $maxCode ? intval($maxCode) + 1 : 1; // Generar un nuevo código empezando desde 1
        }

        // Si no tiene una oficina padre, es de nivel 1
        if (is_null($this->id_oficina_padre)) {
            // Encontrar el máximo código de nivel 1
            $maxCode = self::whereNull('id_oficina_padre')->max('codigo');
            return $maxCode ? intval($maxCode) + 1 : 1;
        } else {
            // Si tiene una oficina padre, obtener el código de la oficina padre
            $parentOffice = self::find($this->id_oficina_padre);
            $parentCode = $parentOffice->codigo;

            // Buscar suboficinas con el mismo código de la oficina padre
            $maxSubCode = self::where('id_oficina_padre', $this->id_oficina_padre)
                ->where('codigo', 'like', "$parentCode.%")
                ->max('codigo');

            if ($maxSubCode) {
                // Extraer la última parte del código y sumarle 1
                $lastSegment = intval(substr($maxSubCode, strrpos($maxSubCode, '.') + 1)) + 1;
                return $parentCode . '.' . $lastSegment;
            } else {
                // Si no existen suboficinas, comenzar con .1
                return $parentCode . '.1';
            }
        }
    }*/



    public function updateSubOfficeCodes($newParentCode, $parentId = null)
    {
        // Si se pasa un código padre, se actualizan las suboficinas de esa oficina
        $subOffices = self::where('id_oficina_padre', $parentId ?? $this->id_oficina)->get();

        // Mantener un contador para las suboficinas bajo el nuevo código
        $counter = 1;
        
        foreach ($subOffices as $subOffice) {
            // Generar el nuevo código basado en el código del nuevo padre y el contador
            $newCode = $newParentCode . '.' . $counter;

            // Actualizar el código de la suboficina
            $subOffice->codigo = $newCode;
            $subOffice->save();

            // Incrementar el contador para la siguiente suboficina en el mismo nivel
            $counter++;

            // Recursivamente actualizar las suboficinas de la suboficina actual
            $subOffice->updateSubOfficeCodes($newCode, $subOffice->id_oficina);
        }
    }


}
