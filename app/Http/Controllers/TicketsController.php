<?php

namespace App\Http\Controllers;

use App\Models\OficinaPersonal;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TicketsController extends Controller
{
    public function  index() {

        return view('admin.tickest.index');

    }

    public function actListar(Request $r)
    {

        if ($r->ajax()) {

            //$tickets = Ticket::all();
            $tickets = Ticket::with(['oficinaPersonal.personal', 'soporte'])->get();

            
            //dd($tickets);

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

}
