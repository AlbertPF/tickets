<?php

namespace App\Http\Controllers;

use App\Models\AsignacionTicket;
use App\Models\OficinaPersonal;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AsignarTicketController extends Controller
{
    public function actListar()
    {
        $usuarioActual = Session::has('usuario') == true ? Session::get('usuario')->id_usuario : null;

        if ($usuarioActual) {
            $ticketsAsig = AsignacionTicket::with(['ticket.soporte', 'ticket.personal', 'usuario'])
                ->where('id_usuario', $usuarioActual)
                ->get();

            // Renderizar la vista con los tickets asignados
            $html = view('admin.tickest.asignacion.tabla', compact('ticketsAsig'))->render();

            return response()->json([
                'code' => 200,
                'html' => $html,
                'msg' => 'success',
            ], 200);
        } else {
            // Si no hay un usuario autenticado, retornar un error
            return response()->json([
                'code' => 401,
                'msg' => 'error',
                'message' => 'Usuario no autenticado',
            ], 401);
        }
    }

    public function actRegistrar(Request $r)
    {
        if ($r->ajax()) {
            $actual = Carbon::now('America/Lima');

            DB::beginTransaction();

            try {

                // Obtener el primer ticket pendiente del día con estados 1 o 4 (registrado o no logrado)
                /*$primerTicketPendiente = Ticket::whereDate('fecha_env', now()->toDateString())
                    ->whereIn('estado', [1, 4])  // Filtrar por estados "registrado" y "no logrado"
                    ->orderBy('fecha_env', 'asc') // Ordenar por fecha de creación
                    ->first();*/

                    $primerTicketPendiente = Ticket::whereIn('estado', [1, 4])
                        ->orderBy('fecha_env', 'asc')
                        ->first();

                // Verificar si el ticket que se intenta asignar es el primer ticket pendiente del día
                if (!$primerTicketPendiente || $primerTicketPendiente->id_ticket != $r->id_ticket) {
                    return response()->json([
                        'code' => 403,
                        'msg' => 'error',
                        'message' => 'Debe asignarse al primer ticket pendiente del día.'
                    ], 403);
                }

                AsignacionTicket::create([
                    'estado' => '2',
                    'fecha_asig' => $actual,
                    'fecha_fin' => null,
                    'descripcion' => null,
                    'id_ticket' => $r->id_ticket,
                    'id_usuario' => Session::has('usuario') == true ? Session::get('usuario')->id_usuario : null,
                ]);

                /*$ticket = Ticket::find($r->id_ticket);
                if ($ticket) {
                    $ticket->estado = 2;
                    $ticket->save();
                }*/
                $primerTicketPendiente->estado = 2;
                $primerTicketPendiente->save();

                DB::commit();  // Confirma la transacción

                return response()->json([
                    'code' => 200,
                    'msg' => 'success',
                    'message' => 'Ticket asignado exitosamente!'
                ], 200);
            } catch (\Exception $e) {
                DB::rollBack();  // Revertir la transacción en caso de error

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
                'message' => 'Ocurrió un problema, por favor comuníquese con el administrador'
            ], 404);
        }
    }

    public function actVerModal(Request $r)
    {
        if ($r->ajax()) {

            $tickets = Ticket::with(['oficinaPersonal.personal', 'oficinaPersonal.oficina', 'soporte'])->find($r->id_ticket);
            
            // Iterar sobre cada ticket para agregar el nombre y clase del estado
            $tickets->estado_nombre = $tickets->getEstadoNombre();
            $tickets->estado_clase = $tickets->getEstadoClase();

            if ($tickets) {

                return response()->json([
                    'code' => 200,
                    'msg' => 'success',
                    'message' => 'Ticket encontrado correctamente!',
                    'tickets' => $tickets,
                ], 200);
            } else {
                return response()->json([
                    'code' => 404,
                    'msg' => 'error',
                    'message' => 'Ticket no encontrado'
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

    public function actAsignar(Request $r)
    {
        if ($r->ajax()) {
            $actual = Carbon::now('America/Lima');

            DB::beginTransaction();

            try {

                AsignacionTicket::create([
                    'estado' => '2',
                    'fecha_asig' => $actual,
                    'fecha_fin' => null,
                    'descripcion' => null,
                    'id_ticket' => $r->id_tickets_asignar,
                    'id_usuario' => $r->id_usuario,
                ]);

                $ticket = Ticket::find($r->id_tickets_asignar);
                if ($ticket) {
                    $ticket->estado = 2;
                    $ticket->save();
                }

                DB::commit();  // Confirma la transacción

                return response()->json([
                    'code' => 200,
                    'msg' => 'success',
                    'message' => 'Ticket asignado exitosamente!'
                ], 200);
            } catch (\Exception $e) {
                DB::rollBack();  // Revertir la transacción en caso de error

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
                'message' => 'Ocurrió un problema, por favor comuníquese con el administrador'
            ], 404);
        }
    }

    public function actVer(Request $r)
    {
        if ($r->ajax()) {
            $id_Asigticket = $r->id_Asigticket;

            $ticketsAsig = AsignacionTicket::with(['ticket.soporte', 'ticket.oficinaPersonal.personal', 'ticket.oficinaPersonal.oficina', 'usuario'])
                ->where('id_Asigticket', $id_Asigticket)
                ->first();

            $ticketsAsig->ticket->estado_nombre = $ticketsAsig->ticket->getEstadoNombre();
            $ticketsAsig->ticket->estado_clase = $ticketsAsig->ticket->getEstadoClase();

            if ($ticketsAsig && $ticketsAsig->ticket->oficinaPersonal->personal) {
                return response()->json([
                    'code' => 200,
                    'msg' => 'success',
                    'message' => 'Ticket encontrado correctamente!',
                    'tickets' => $ticketsAsig,
                ], 200);
            } else {
                return response()->json([
                    'code' => 404,
                    'msg' => 'error',
                    'message' => 'Ticket o personal no encontrado.'
                ], 404);
            }
        } else {
            return response()->json([
                'code' => 404,
                'msg' => 'error',
                'message' => 'Ocurrió un problema, por favor comunicarse con el administrador.'
            ], 404);
        }
    }

    public function actNoResuelto(Request $r)
    {

        if ($r->ajax()) {


            DB::beginTransaction();

            try {

                $ticket = Ticket::find($r->id_ticket);
                if ($ticket) {
                    $ticket->estado = 4;
                    $ticket->save();
                }

                $usuarioActual = Session::has('usuario') ? Session::get('usuario')->id_usuario : null;

                $asignacionTicket = AsignacionTicket::where('id_usuario', $usuarioActual)
                    ->where('id_ticket', $r->id_ticket)
                    ->first();

                if ($asignacionTicket) {
                    $asignacionTicket->estado = 4;
                    $asignacionTicket->save();
                }

                DB::commit();

                return response()->json([
                    'code' => 200,
                    'msg' => 'success',
                    'message' => 'Ticket cambio de estado exitosamente!'
                ], 200);
            } catch (\Exception $e) {
                DB::rollBack();  // Revertir la transacción en caso de error

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
                'message' => 'Ocurrió un problema, por favor comuníquese con el administrador'
            ], 404);
        }
    }

    public function actEditar(Request $r)
    {
        if ($r->ajax()) {
            $asigTicket = Ticket::find($r->id_ticket);

            return response()->json([
                'code' => 200,
                'msg' => 'success',
                'message' => '¡Asiganación Encontrada!',
                'asigTicket' => $asigTicket,
            ], 200);
        } else {
            return response()->json([
                'code' => 404,
                'msg' => 'error',
                'message' => 'Ocurrio un problema, porfavor comunicarse con el administrador'
            ], 404);
        }
    }

    public function actFinalizacion(Request $r)
    {
        if ($r->ajax()) {

            $rules = [
                'id_ticket' => 'required',
                'descripcion' => 'required|string|max:225',
            ];

            $messages = [
                'id_ticket.required' => 'El tickets es obligatorio.',
                'descripcion.required' => 'La descripción de la observación es obligatorio.',
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

            try {

                DB::beginTransaction();

                $usuarioActual = Session::has('usuario') ? Session::get('usuario')->id_usuario : null;

                $ticketAsignacion = AsignacionTicket::where('id_usuario', $usuarioActual)
                    ->where('id_ticket', $r->id_ticket)
                    ->first();

                //$ticketAsignacion = AsignacionTicket::where('id_ticket', $r->id_ticket)->first();
                $fechafinalizacion = Carbon::now('America/Lima');

                if ($ticketAsignacion) {

                    $ticketAsignacion->descripcion = $r->descripcion;
                    $ticketAsignacion->fecha_fin = $fechafinalizacion;
                    $ticketAsignacion->estado = 3;
                    $ticketAsignacion->save();

                    $ticket = Ticket::find($ticketAsignacion->id_ticket);
                    if ($ticket) {
                        $ticket->estado = 3;
                        $ticket->save();
                    }

                    DB::commit();

                    return response()->json([
                        'code' => 200,
                        'message' => 'Descripción agregada y ticket finalizado exitosamente.'
                    ]);
                } else {
                    DB::rollBack();
                    return response()->json([
                        'code' => 404,
                        'message' => 'Ticket no encontrado.'
                    ]);
                }
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json([
                    'code' => 500,
                    'message' => 'Error en el servidor: ' . $e->getMessage()
                ]);
            }
        } else {
            return response()->json([
                'code' => 404,
                'msg' => 'error',
                'message' => 'Ocurrió un problema, por favor comunicarse con el administrador.'
            ], 404);
        }
    }

    public function actCancelar(Request $r)
    {
        if ($r->ajax()) {

            $rules = [
                'id_tickets' => 'required',
                'descripcion' => 'required|string|max:225',
            ];

            $messages = [
                'id_tickets.required' => 'El tickets es obligatorio.',
                'descripcion.required' => 'La descripción de la observación es obligatorio.',
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

            try {

                DB::beginTransaction();

                $usuarioActual = Session::has('usuario') ? Session::get('usuario')->id_usuario : null;
                $actual = Carbon::now('America/Lima');
                $fechafinalizacion = Carbon::now('America/Lima');
                /*$ticketCancel = AsignacionTicket::where('id_usuario', $usuarioActual)
                                                    ->where('id_ticket', $r->id_tickets)
                                                    ->first();*/

                //dd($usuarioActual, $r->id_tickets);

                AsignacionTicket::create([
                    'estado' => '5',
                    'fecha_asig' => $actual,
                    'fecha_fin' => $fechafinalizacion,
                    'descripcion' => $r->descripcion,
                    'id_ticket' => $r->id_tickets,
                    'id_usuario' => $usuarioActual,
                ]);

                $ticket = Ticket::find($r->id_tickets);
                if ($ticket) {
                    $ticket->estado = 5;
                    $ticket->save();
                }

                DB::commit();

                return response()->json([
                    'code' => 200,
                    'message' => 'Descripción agregada y ticket cancelada exitosamente.'
                ]);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json([
                    'code' => 500,
                    'message' => 'Error en el servidor: ' . $e->getMessage()
                ]);
            }
        } else {
            return response()->json([
                'code' => 404,
                'msg' => 'error',
                'message' => 'Ocurrió un problema, por favor comunicarse con el administrador.'
            ], 404);
        }
    }

    public function actEditar2(Request $r)
    {
        if ($r->ajax()) {
            $asigTicket = Ticket::find($r->id_ticket);

            return response()->json([
                'code' => 200,
                'msg' => 'success',
                'message' => '¡Asiganación Encontrada!',
                'asigTicket' => $asigTicket,
            ], 200);
        } else {
            return response()->json([
                'code' => 404,
                'msg' => 'error',
                'message' => 'Ocurrio un problema, porfavor comunicarse con el administrador'
            ], 404);
        }
    }

    public function actFinalizacion2(Request $r)
    {
        if ($r->ajax()) {

            $rules = [
                'id_ticket' => 'required',
                'descripcion' => 'required|string|max:225',
            ];

            $messages = [
                'id_ticket.required' => 'El tickets es obligatorio.',
                'descripcion.required' => 'La descripción de la observación es obligatorio.',
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

            try {

                DB::beginTransaction();

                $usuarioActual = Session::has('usuario') ? Session::get('usuario')->id_usuario : null;

                $ticketAsignacion = AsignacionTicket::where('id_usuario', $usuarioActual)
                    ->where('id_ticket', $r->id_ticket)
                    ->first();

                //$ticketAsignacion = AsignacionTicket::where('id_ticket', $r->id_ticket)->first();
                $fechafinalizacion = Carbon::now('America/Lima');

                if ($ticketAsignacion) {

                    $ticketAsignacion->descripcion = $r->descripcion;
                    $ticketAsignacion->fecha_fin = $fechafinalizacion;
                    $ticketAsignacion->estado = 3;
                    $ticketAsignacion->save();

                    $ticket = Ticket::find($ticketAsignacion->id_ticket);
                    if ($ticket) {
                        $ticket->estado = 3;
                        $ticket->save();
                    }

                    DB::commit();

                    return response()->json([
                        'code' => 200,
                        'message' => 'Descripción agregada y ticket finalizado exitosamente.'
                    ]);
                } else {
                    DB::rollBack();
                    return response()->json([
                        'code' => 404,
                        'message' => 'Ticket no encontrado.'
                    ]);
                }
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json([
                    'code' => 500,
                    'message' => 'Error en el servidor: ' . $e->getMessage()
                ]);
            }
        } else {
            return response()->json([
                'code' => 404,
                'msg' => 'error',
                'message' => 'Ocurrió un problema, por favor comunicarse con el administrador.'
            ], 404);
        }
    }

    public function index()
    {

        return view('admin.asignaciones.index');
    }

    public function actListarGeneral()
    {

        $ticketsAsigGeneral = AsignacionTicket::with(['ticket.soporte', 'ticket.personal', 'usuario'])
            ->get();

        // Renderizar la vista con los tickets asignados
        $html = view('admin.asignaciones.tabla', compact('ticketsAsigGeneral'))->render();

        return response()->json([
            'code' => 200,
            'html' => $html,
            'msg' => 'success',
        ], 200);
    }

    public function actVerGeneral(Request $r)
    {
        if ($r->ajax()) {
            $id_Asigticket = $r->id_Asigticket;

            $ticketsAsig = AsignacionTicket::with(['ticket.soporte', 'ticket.oficinaPersonal.personal', 'ticket.oficinaPersonal.oficina', 'usuario'])
                ->where('id_Asigticket', $id_Asigticket)
                ->first();

            $ticketsAsig->ticket->estado_nombre = $ticketsAsig->ticket->getEstadoNombre();
            $ticketsAsig->ticket->estado_clase = $ticketsAsig->ticket->getEstadoClase();

            if ($ticketsAsig && $ticketsAsig->ticket->oficinaPersonal->personal) {
                return response()->json([
                    'code' => 200,
                    'msg' => 'success',
                    'message' => 'Ticket encontrado correctamente!',
                    'tickets' => $ticketsAsig,
                ], 200);
            } else {
                return response()->json([
                    'code' => 404,
                    'msg' => 'error',
                    'message' => 'Ticket o personal no encontrado.'
                ], 404);
            }
        } else {
            return response()->json([
                'code' => 404,
                'msg' => 'error',
                'message' => 'Ocurrió un problema, por favor comunicarse con el administrador.'
            ], 404);
        }
    }
}
