<?php

namespace App\Http\Controllers;

use App\Models\AsignacionTicket;
use App\Models\OficinaPersonal;
use App\Models\Ticket;
use App\Models\ticket_notificacion;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class TicketsController extends Controller
{
    public function  index() {

        return view('admin.tickest.index');

    }

    public function actListar(Request $r)
    {

        if ($r->ajax()) {

            $mes = $r->input('mes');
            $anio = $r->input('anio');

            //$tickets = Ticket::all();
            //$tickets = Ticket::with(['oficinaPersonal.personal', 'soporte'])->get();

            $query = Ticket::with(['oficinaPersonal.personal', 'soporte']);
            
            if ($mes && $anio) {
                $query->whereMonth('fecha_env', $mes)
                    ->whereYear('fecha_env', $anio);
            } elseif ($anio) {
                $query->whereYear('fecha_env', $anio);
            } elseif ($mes) {
                $query->whereMonth('fecha_env', $mes)
                    ->whereYear('fecha_env', now()->year);
            } else {
                // Por defecto: mes y año actual
                $query->whereMonth('fecha_env', now()->month)
                    ->whereYear('fecha_env', now()->year);
            }

            $tickets = $query->get();

            $html = view('admin.tickest.tabla', compact('tickets'))->render();

            return response()->json([
                'code' => 200,
                'html' => $html,
                'msg' => 'success',
            ], 200);
        } else {
            return response()->json([
                'code' => 404,
                'msg' => 'error',
                'message' => 'Ocurrio un problema, porfavor comunicarse con el administrador'
            ], 404);
        }
    }

    public function actVer(Request $r)
    {
        if ($r->ajax()) {

            $tickets = Ticket::with(['oficinaPersonal.personal', 'oficinaPersonal.oficina', 'soporte'])->find($r->id_ticket);
            
            // Iterar sobre cada ticket para agregar el nombre y clase del estado
            $tickets->estado_nombre = $tickets->getEstadoNombre();
            $tickets->estado_clase = $tickets->getEstadoClase();
            $tickets->archivo = $tickets->archivo ? $tickets->archivo : null;

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

    public function actMostrar($id_tickets)
    {
        $ticket = Ticket::findOrFail($id_tickets);

        $usuarioActual = Auth::user()->id_usuario ?? null;

        if ($usuarioActual) {
            $notificacion = ticket_notificacion::where('id_ticket', $id_tickets)
                                ->where('id_usuario', $usuarioActual)
                                ->first();

            if ($notificacion && !$notificacion->abierta) {
                $notificacion->abierta = true;
                $notificacion->abierta_en = now();
                $notificacion->save();
            }
        }

        return view('admin.tickest.mostrarTicket', compact('ticket'));
    }

    public function actAsignar(Request $r)
    {
        if ($r->ajax()) {
            $actual = Carbon::now('America/Lima');

            DB::beginTransaction();
            try {
                $ticket = Ticket::find($r->id_tickets);

                if (!$ticket) {
                    return response()->json(['code'=>404,'msg'=>'error','message'=>'Ticket no encontrado'],404);
                }

                $asignacionEnProceso = AsignacionTicket::where('id_ticket', $r->id_tickets)
                    ->where('estado', 2)
                    ->exists();

                if (in_array($ticket->estado, [2, 3, 5]) || $asignacionEnProceso) {
                    $estadoTexto = match($ticket->estado) {
                        2 => 'en proceso',
                        3 => 'atendido',
                        5 => 'cancelado',
                        default => 'no disponible'
                    };

                    return response()->json([
                        'code' => 409,
                        'msg' => 'warning',
                        'message' => "El ticket no puede asignarse porque está {$estadoTexto}."
                    ], 409);
                }

                // Primera asignación pendiente
                $primerTicketPendiente = Ticket::whereIn('estado', [1, 4])
                    ->orderBy('fecha_env', 'asc')
                    ->first();

                if (!$primerTicketPendiente || $primerTicketPendiente->id_ticket != $r->id_tickets) {
                    return response()->json([
                        'code' => 409,
                        'msg' => 'warning',
                        'message' => 'Debe asignarse al primer ticket pendiente del día.'
                    ], 403);
                }

                AsignacionTicket::create([
                    'estado' => 2,
                    'fecha_asig' => $actual,
                    'fecha_fin' => null,
                    'descripcion' => null,
                    'id_ticket' => $r->id_tickets,
                    'id_usuario' => Auth::check() ? Auth::user()->id_usuario : null,
                ]);

                $ticket->estado = 2;
                $ticket->save();

                DB::commit();
                return response()->json([
                    'code' => 200,
                    'msg' => 'success',
                    'message' => 'Ticket asignado exitosamente!'
                ]);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json([
                    'code' => 500,
                    'msg' => 'error',
                    'message' => 'Error en el servidor: '.$e->getMessage()
                ],500);
            }
        }
        return response()->json(['code'=>404,'msg'=>'error','message'=>'Petición inválida'],404);
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
                $usuarioActual = Auth::check() ? Auth::user()->id_usuario : null;
                $actual = Carbon::now('America/Lima');

                AsignacionTicket::create([
                    'estado' => 5,
                    'fecha_asig' => $actual,
                    'fecha_fin' => $actual,
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
                    'msg' => 'success',
                    'message' => 'Ticket cancelado exitosamente.'
                ]);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json([
                    'code' => 500,
                    'msg' => 'error',
                    'message' => 'Error en el servidor: ' . $e->getMessage()
                ]);
            }
        }
        return response()->json(['code'=>404,'msg'=>'error','message'=>'Petición inválida'],404);
    }

}
