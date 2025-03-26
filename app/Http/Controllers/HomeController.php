<?php

namespace App\Http\Controllers;

use App\Models\Oficina;
use App\Models\OficinaPersonal;
use App\Models\Personal;
use App\Models\Soporte;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function __invoke()
    {
       return view('index');
    }

    public function actListaOficinas(Request $r)
    {
        if ($r->ajax()) {
            //$oficinas = Oficina::with('subOficinas')->whereNull('id_oficina_padre')->orderBy('nombre', 'asc')->get();

            $anioActual = Carbon::now()->year;

            // Obtener todas las oficinas del año actual que no tienen padre, ordenadas alfabéticamente
            $oficinas = Oficina::with('subOficinas')
                ->whereNull('id_oficina_padre')
                ->where('anio', $anioActual)  // Filtrar por el año actual
                ->orderBy('nombre', 'asc')
                ->get();

            // Formatear las oficinas jerárquicamente
            $oficinasOrdenadas = $this->ordenarOficinas($oficinas);

            return response()->json([
                'code' => 200,
                'msg' => 'success',
                'message' => 'Oficinas obtenidas exitosamente!',
                'oficinas' => $oficinasOrdenadas
            ], 200);
        } else {
            return response()->json([
                'code' => 404,
                'msg' => 'error',
                'message' => 'Ocurrio un problema, porfavor comunicarse con el administrador'
            ], 404);
        }
    }

    private function ordenarOficinas($oficinas, $nivel = 0)
    {
        $resultado = [];

        foreach ($oficinas as $oficina) {
            // Agregar la oficina con el nivel actual de indentación
            $resultado[] = [
                'id_oficina' => $oficina->id_oficina,
                'nombre' => str_repeat('ㅤ', $nivel) . $oficina->nombre,
                'nivel' => $nivel
            ];

            // Llamada recursiva para obtener las suboficinas
            if ($oficina->subOficinas) {
                $resultado = array_merge($resultado, $this->ordenarOficinas($oficina->subOficinas, $nivel + 1));
            }
        }

        return $resultado;
    }

    public function actListaIncidencias(Request $r)
    {
        if ($r->ajax()) {
            //$incidencia = Soporte::orderBy('nombre', 'desc')->get();
            //$incidencia = Soporte::orderByRaw("CASE WHEN nombre = 'Otros' THEN 1 ELSE 0 END, nombre DESC")->get();
            $incidencia = Soporte::where('estado', '1')
                ->orderByRaw("CASE WHEN nombre = 'Otros' THEN 1 ELSE 0 END, nombre DESC")
                ->get();

            return response()->json([
                'code' => 200,
                'msg' => 'success',
                'message' => 'Incidencias obtenidas exitosamente!',
                'incidencias' => $incidencia
            ], 200);
        } else {
            return response()->json([
                'code' => 404,
                'msg' => 'error',
                'message' => 'Ocurrio un problema, porfavor comunicarse con el administrador'
            ], 404);
        }
    }

    public function actBuscarPersonal(Request $r)
    {
        if ($r->ajax()) {

            $validatedData = $r->validate([
                'dni' => ['required', 'digits:8', 'numeric']
            ], [
                'dni.required' => 'El DNI es obligatorio.',
                'dni.digits' => 'El DNI debe tener 8 dígitos.',
                'dni.numeric' => 'El DNI debe contener solo números.'
            ]);

            $dni = $r->input('dni');
            $personal = Personal::where('dni', $dni)->first();

            if ($personal) {
                
                $anioActual = date('Y');
                
                // Buscar la oficina asignada al personal en el año actual con estado activo
                $oficinaPersonal = OficinaPersonal::where('id_personal', $personal->id_personal)
                    ->where('anio', $anioActual)
                    ->where('estado', 1) 
                    ->with('oficina') 
                    ->first();

                    if(!$oficinaPersonal){
                        return response()->json([
                            'code' => 403,
                            'msg' => 'error',
                            'message' => 'El personal no está habilitado para registrar incidencias en el Gobierno Regional de Apurímac este año.'
                        ], 403);
                    }

                return response()->json([
                    'code' => 200,
                    'msg' => 'success',
                    //'id_personal' => $personal->id_personal,
                    'nombre' => $personal->nombre,
                    'apellidoPaterno' => $personal->apellidoPaterno,
                    'apellidoMaterno' => $personal->apellidoMaterno,
                    'id_OfiPer' => $oficinaPersonal->id_OfiPer,
                    'nombre_oficina' => $oficinaPersonal->oficina->nombre
                ], 200);
            } else {
                return response()->json([
                    'code' => 404,
                    'msg' => 'error',
                    'message' => 'El personal no existe o no está afiliado en el sistema de tickets.'
                ], 404);
            }
        } else {
            return response()->json([
                'code' => 404,
                'msg' => 'error',
                'message' => 'Ocurrio un problema, porfavor comunicarse con el administrador'
            ], 404);
        }
    }
    

    public function actRegistrar(Request $r)
    {
        if ($r->ajax()) {

            // Definir las reglas de validación
            $rules = [
                'id_soporte' => 'required',
                'id_OfiPer' => 'required',
                'descripcion' => 'required',
            ];

            // Mensajes personalizados para las validaciones
            $messages = [
                'id_OfiPer.required' => 'La Asiganción del Personal es obligatorio.',
                'id_soporte.required' => 'La incidencia es obligatorio.',
                'descripcion.required' => 'La descripción de la incidencia es obligatorio, para un mayor entendimiento.',
            ];

            // Validación de los datos
            $validator = Validator::make($r->all(), $rules, $messages);

            if ($validator->fails()) {
                return response()->json([
                    'code' => 422,
                    'msg' => 'error',
                    'message' => $validator->errors()->first()
                ], 422);
            }

            $anioActual = date('Y');

            // Verificar si el personal está activo y asignado a una oficina en el año actual
            /*$personal = Personal::where('id_personal', $r->id_personal)->first();

            if (!$personal || $personal->estado != '1') {
                return response()->json([
                    'code' => 403,
                    'msg' => 'error',
                    'message' => 'El personal no está habilitado para registrar incidencias en el Gobierno Regional de Apurímac este año.'
                ], 403);
            }*/

            // Verificar si está asignado a una oficina en el año actual
            $oficinaPersonal = OficinaPersonal::where('id_OfiPer', $r->id_OfiPer)
                ->where('anio', $anioActual)
                ->where('estado', 1) // Asegúrate de que 'activo' sea el valor correcto para el estado activo
                ->first();

            if (!$oficinaPersonal) {
                return response()->json([
                    'code' => 403,
                    'msg' => 'error',
                    'message' => 'El personal no tiene asignada una oficina activa en este año.'
                ], 403);
            }

             // Validar que no exista un ticket registrado en los últimos 10 minutos
            $ultimoTicket = Ticket::where('id_OfiPer', $r->id_OfiPer)
            ->where('created_at', '>=', now()->subMinutes(5))
            ->first();

            if ($ultimoTicket) {
                return response()->json([
                    'code' => 429,
                    'msg' => 'error',
                    'message' => 'No puede registrar otro ticket hasta que hayan pasado al menos 5 minutos desde el último registro.'
                ], 429);
            }

            DB::beginTransaction(); // Iniciar una transacción

            try {
                
                Ticket::create([
                    'estado' => 1,
                    'fecha_env' => now(),
                    'descripcion' => $r->descripcion,
                    'id_soporte' => $r->id_soporte,
                    'id_OfiPer' => $r->id_OfiPer
                ]);

                DB::commit(); // Confirmar la transacción

                return response()->json([
                    'code' => 200,
                    'msg' => 'success',
                    'message' => 'Tickets registrado exitosamente!'
                ], 200);
            } catch (\Exception $e) {
                DB::rollBack(); // Revertir la transacción en caso de excepción

                return response()->json([
                    'code' => 500,
                    'msg' => 'error',
                    'message' => 'Error en el servidor: ' . $e->getMessage()
                ], 500);
            }
        } else {
            return response()->json([
                'code' => 404,
                'msg' => 'error',
                'message' => 'Ocurrio un problema, por favor comunicarse con el administrador'
            ], 404);
        }
    }

    /*public function actMostrarTabla(Request $r) {

        if ($r->ajax()) {

            //dd($asignacionUsu);
            $html = view('tableIndex')->render();
            return response()->json([
                'code' => 200,
                'html' => $html,
                'msg' => 'success',
            ], 200);
        } else {
            return response()->json([
                'code' => 404,
                'msg' => 'error',
                'message' => 'Error, hubo un problema comunicate con el Administrador.'
            ], 404);
        }

    }*/

    public function consultarTickets(Request $r)
    {
        if ($r->ajax()) {
            $fechaActual = now();

            $personal = DB::table('personals')->where('dni', $r->dni)->first();

            if ($personal) {
                $tickets = Ticket::with(['oficinaPersonal.personal', 'oficinaPersonal.oficina', 'soporte', 'asignaciones.usuario'])
                    ->whereHas('oficinaPersonal.personal', function ($query) use ($r) {
                        $query->where('dni', $r->dni);
                    })
                    ->get();

                if ($tickets->isEmpty()) {
                    $html = '<tr><td colspan="8">No se encontraron tickets registrados para este DNI.</td></tr>';
                } else {
                    $html = view('tableIndex', compact('tickets'))->render();
                }

                return response()->json([
                    'code' => 200,
                    'html' => $html,
                    'msg' => 'success',
                ], 200);
            } else {
                return response()->json([
                    'code' => 404,
                    'html' => '<tr><td colspan="8">No se encontró información del personal solicitado.</td></tr>',
                    'msg' => 'error',
                    'message' => 'No se encontró información del personal solicitado.',
                ], 404);
            }
        } else {
            return response()->json([
                'code' => 404,
                'msg' => 'error',
                'message' => 'Error, hubo un problema comunicate con el Administrador.',
            ], 404);
        }
    }


}
