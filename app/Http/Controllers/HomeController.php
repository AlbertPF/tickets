<?php

namespace App\Http\Controllers;

use App\Models\Oficina;
use App\Models\OficinaPersonal;
use App\Models\Personal;
use App\Models\Soporte;
use App\Models\Ticket;
use App\Models\ticket_notificacion;
use App\Models\Usuario;
use App\Notifications\CrearTicketNotificacion;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;

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

                if (!$oficinaPersonal) {
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
                'archivo' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:3072'
            ];

            // Mensajes personalizados para las validaciones
            $messages = [
                'id_OfiPer.required' => 'La Asiganción del Personal es obligatorio.',
                'id_soporte.required' => 'La incidencia es obligatorio.',
                'descripcion.required' => 'La descripción de la incidencia es obligatorio, para un mayor entendimiento.',
                'archivo.file'  => 'El archivo adjunto no es válido.',
                'archivo.mimes' => 'El archivo debe ser de tipo: JPG, JPEG, PNG o PDF.',
                'archivo.max'   => 'El archivo no debe superar los 3 MB.',
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

                $rutaArchivo = null;
                if ($r->hasFile('archivo')) {
                    $rutaArchivo = $r->file('archivo')->store('tickets', 'public');
                }

                $ticket = Ticket::create([
                    'estado' => 1,
                    'fecha_env' => now(),
                    'descripcion' => $r->descripcion,
                    'archivo' => $rutaArchivo,
                    'id_soporte' => $r->id_soporte,
                    'id_OfiPer' => $r->id_OfiPer
                ]);

                DB::commit();

                // ----------------------------
                // NOTIFICAR a los encargados
                // ----------------------------
                // Si tus usuarios tienen role 'soporte':
                /*$usuariosAtencion = Usuario::where('role', 'soporte')
                    ->whereNotNull('telegram_user_id')
                    ->get();*/

                $usuariosAtencion = Usuario::whereIn('tipo', ['Administrador', 'Agente Informático'])
                    ->whereNotNull('telegram_user_id')
                    ->get();

                // Enviar notificación a todos los usuarios
                //Notification::send($usuariosAtencion, new CrearTicket($ticket, auth()->user() ?? null));

                foreach ($usuariosAtencion as $usuario) {
                    try {
                        $usuario->notify(new CrearTicketNotificacion($ticket));
                    } catch (\Throwable $e) {
                        Log::warning('No se pudo enviar la notificación de ticket por Telegram.', [
                            'id_ticket' => $ticket->id_ticket,
                            'id_usuario' => $usuario->id_usuario,
                            'telegram_user_id' => $usuario->telegram_user_id,
                            'nombre_usuario' => trim(implode(' ', array_filter([
                                $usuario->nombre,
                                $usuario->apellidoPaterno,
                                $usuario->apellidoMaterno,
                            ]))),
                            'error' => $e->getMessage(),
                        ]);

                        continue;
                    }

                    try {
                        ticket_notificacion::create([
                            'id_ticket' => $ticket->id_ticket,
                            'id_usuario' => $usuario->id_usuario,
                            'enviada_en' => now(),
                            'abierta' => false
                        ]);
                    } catch (\Throwable $e) {
                        Log::error('Telegram confirmó el envío, pero no se pudo registrar la notificación.', [
                            'id_ticket' => $ticket->id_ticket,
                            'id_usuario' => $usuario->id_usuario,
                            'telegram_user_id' => $usuario->telegram_user_id,
                            'error' => $e->getMessage(),
                        ]);
                    }
                }

                return response()->json([
                    'code' => 200,
                    'msg' => 'success',
                    'message' => 'Tickets registrado exitosamente!',
                    'id_ticket' => $ticket->id_ticket
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

            $buscar = trim($r->buscar);

            $tickets = collect();

            if (preg_match('/^\d{8}$/', $buscar)) {

                $personal = DB::table('personals')
                    ->where('dni', $buscar)
                    ->first();

                if (!$personal) {

                    return response()->json([
                        'code' => 404,
                        'html' => '<tr><td colspan="8">No existe un personal con ese DNI.</td></tr>',
                        'message' => 'No existe un personal con ese DNI.'
                    ], 404);
                }

                $tickets = Ticket::with([
                    'oficinaPersonal.personal',
                    'oficinaPersonal.oficina',
                    'soporte',
                    'asignaciones.usuario'
                ])
                    ->whereHas('oficinaPersonal.personal', function ($q) use ($buscar) {

                        $q->where('dni', $buscar);
                    })
                    ->orderByDesc('id_ticket')
                    ->get();

            } elseif (preg_match('/^tik\d{4,}$/i', $buscar)) {

                $tickets = Ticket::with([
                    'oficinaPersonal.personal',
                    'oficinaPersonal.oficina',
                    'soporte',
                    'asignaciones.usuario'
                ])
                    ->whereRaw('LOWER(id_ticket)=?', [
                        strtolower($buscar)
                    ])
                    ->get();
            } else {

                return response()->json([

                    'code' => 422,

                    'html' => '<tr><td colspan="8">Ingrese un DNI o Código de Ticket válido.</td></tr>',

                    'message' => 'Ingrese un DNI de 8 dígitos o un código de ticket válido.'

                ], 422);
            }

            if ($tickets->isEmpty()) {

                return response()->json([

                    'code' => 404,

                    'html' => '<tr><td colspan="8">No se encontraron tickets.</td></tr>',

                    'message' => 'No se encontraron tickets.'

                ], 404);
            }

            $html = view('tableIndex', compact('tickets'))->render();

            return response()->json([
                'code' => 200,
                'html' => $html,
                'msg' => 'success'
            ]);

        } else {
            return response()->json([
                'code' => 404,
                'msg' => 'error',
                'message' => 'Error, hubo un problema comunicate con el Administrador.',
            ], 404);
        }
    }
}
