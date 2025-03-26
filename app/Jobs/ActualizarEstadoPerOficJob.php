<?php

namespace App\Jobs;

use App\Models\OficinaPersonal;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ActualizarEstadoPerOficJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $anioActual = Carbon::now()->year;

        // Agregar log para verificar la ejecución del Job
        Log::info('Ejecutando ActualizarEstadoJob - Año actual: ' . $anioActual);

        // Actualiza el estado a inactivo (0) si el año registrado no es el año actual
        OficinaPersonal::where('anio', '<>', $anioActual)
            ->update(['estado' => 0]);

        // Log para confirmar la finalización
        Log::info('Estado actualizado a inactivo para registros con año diferente a ' . $anioActual);
    }
}
