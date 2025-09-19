<?php

namespace App\Http\Controllers;

use App\Models\AsignacionTicket;
use App\Models\Oficina;
use App\Models\Personal;
use App\Models\Soporte;
use App\Models\Ticket;
use App\Models\Usuario;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class HomeAdminController extends Controller
{
    public function index() {

        return view('admin.dashboard.index');
        
    }

    public function actCatDatos(Request $r){

        if($r->ajax()){

            $anioActual = Carbon::now()->year;

            $tickets = Ticket::count();
            //$oficinas = Oficina::count();
            $oficinas = Oficina::where('anio', $anioActual)->count();
            $personal = Personal::count();
            $usuarios = Usuario::count();

            $ticketsAtendidos = Ticket::where('estado', 3)->count();    
            $ticketsRegistrados = Ticket::where('estado', 1)->count();  
            $ticketsProceso = Ticket::where('estado', 2)->count();      
            $ticketsNoAtendidos = Ticket::where('estado', 4)->count(); 
            $ticketsCancelados = Ticket::where('estado', 5)->count(); 

            return response()->json([
                'code' => 200,
                'smg' => 'success', 
                'tickets' => $tickets,
                'oficinas' => $oficinas,
                'personal' => $personal,
                'usuarios' => $usuarios,
                'ticketsAtendidos' => $ticketsAtendidos,      
                'ticketsRegistrados' => $ticketsRegistrados,  
                'ticketsProceso' => $ticketsProceso,          
                'ticketsNoAtendidos' => $ticketsNoAtendidos,
                'ticketsCancelados' => $ticketsCancelados
            ], 200);

        }else{
            return response()->json([
                'code' => 404,
                'smg' => 'Error',
                'message' => 'Error, hubo un problema comunicate con el Administrador.'
            ], 404);
        }
    }

    /*====================Tickets  por soporte sin filtro de fecha=====================*/
    /*public function getTicketsPorSoporte(Request $r)
    {
        if ($r->ajax()){

            $cantTickSopote = Ticket::select('soportes.nombre', DB::raw('count(tickets.id_ticket) as total'))
                ->join('soportes', 'tickets.id_soporte', '=', 'soportes.id_soporte')
                ->groupBy('soportes.nombre')
                ->get();

            return response()->json([
                'code' => 200,
                'smg' => 'success',
                'cantTickSopote' => $cantTickSopote,
            ], 200);
        }else{
            return response()->json([
                'code' => 404,
                'smg' => 'Error',
                'message' => 'Error, hubo un problema comunicate con el Administrador.',
            ], 404);
        }   

    }*/

    public function getTicketsPorSoporte(Request $r)
    {
        if ($r->ajax()) {
            // Obtiene el año y mes desde la petición, si no se envían, usa el mes y año actual
            $mes = $r->tsmes ?? date('m'); // Si no se envía mes, usa el actual
            $anio = $r->tsanio ?? date('Y');

            $cantTickSopote = Ticket::select(
                    'soportes.nombre',
                    DB::raw('count(tickets.id_ticket) as total')
                )
                ->join('soportes', 'tickets.id_soporte', '=', 'soportes.id_soporte')
                ->whereYear('tickets.fecha_env', $anio)
                ->whereMonth('tickets.fecha_env', $mes)
                ->groupBy('soportes.nombre')
                ->get();

            return response()->json([
                'code' => 200,
                'msg' => 'success',
                'cantTickSopote' => $cantTickSopote,
            ], 200);
        } else {
            return response()->json([
                'code' => 404,
                'msg' => 'Error',
                'message' => 'Error, hubo un problema comunícate con el Administrador.',
            ], 404);
        }
    }


    /*====================Tickets resuelto por usuario sin filtro de fecha=====================*/
    /*public function ticketsResueltosPorUsuario(Request $r)
    {
        if ($r->ajax()){

            $TikectResultadosPorUsuario = DB::table('usuarios as u')
            ->leftJoin(DB::raw('(SELECT a.id_usuario, COUNT(a.id_ticket) as tickets_resueltos 
                                FROM asignacion_ticket as a 
                                JOIN tickets as t ON a.id_ticket = t.id_ticket 
                                WHERE a.estado = 3 
                                AND t.estado = 3 
                                AND YEAR(a.fecha_fin) = YEAR(CURRENT_DATE()) 
                                AND MONTH(a.fecha_fin) = MONTH(CURRENT_DATE()) 
                                GROUP BY a.id_usuario) as res'), 
            'u.id_usuario', '=', 'res.id_usuario')
            ->select('u.id_usuario', 
                    DB::raw("CONCAT(u.nombre, ' ', u.apellidoPaterno) AS nombre_completo"),
                    DB::raw("IFNULL(res.tickets_resueltos, 0) AS tickets_resueltos"))
            ->get();

            /*$TikectResultadosPorUsuario = DB::table('usuarios as u')
                ->leftJoin(DB::raw('(SELECT a.id_usuario, COUNT(a.id_ticket) as tickets_resueltos 
                                    FROM asignacion_ticket as a 
                                    JOIN tickets as t ON a.id_ticket = t.id_ticket 
                                    WHERE a.estado = 3 AND t.estado = 3 
                                    GROUP BY a.id_usuario) as res'), 
                'u.id_usuario', '=', 'res.id_usuario')
                ->select('u.id_usuario', 
                        DB::raw("CONCAT(u.nombre, ' ', u.apellidoPaterno) AS nombre_completo"),
                        DB::raw("IFNULL(res.tickets_resueltos, 0) AS tickets_resueltos"))
                ->get();***

            return response()->json([
                'code' => 200,
                'smg' => 'success',
                'TikectResultadosPorUsuario' => $TikectResultadosPorUsuario,
            ], 200);
        }else{
            return response()->json([
                'code' => 404,
                'smg' => 'Error',
                'message' => 'Error, hubo un problema comunicate con el Administrador.',
            ], 404);
        }  
    }*/

    public function ticketsResueltosPorUsuario(Request $r)
    {
        if ($r->ajax()) {
            $mes = $r->mes ?? date('m'); // Si no se envía mes, usa el actual
            $anio = $r->anio ?? date('Y'); // Si no se envía año, usa el actual

            $TikectResultadosPorUsuario = DB::table('usuarios as u')
                ->join(DB::raw('(SELECT a.id_usuario, COUNT(a.id_ticket) as tickets_resueltos 
                                    FROM asignacion_ticket as a 
                                    JOIN tickets as t ON a.id_ticket = t.id_ticket 
                                    WHERE a.estado = 3 
                                    AND t.estado = 3 
                                    AND YEAR(a.fecha_fin) = ? 
                                    AND MONTH(a.fecha_fin) = ? 
                                    GROUP BY a.id_usuario
                                    HAVING COUNT(a.id_ticket) > 0 )as res'), 
                'u.id_usuario', '=', 'res.id_usuario')
                ->select('u.id_usuario', 
                        DB::raw("CONCAT(u.nombre, ' ', u.apellidoPaterno) AS nombre_completo"),
                        DB::raw("IFNULL(res.tickets_resueltos, 0) AS tickets_resueltos")
                    )
                ->setBindings([$anio, $mes]) // Pasar los valores correctamente para evitar SQL Injection
                ->get();

            return response()->json([
                'code' => 200,
                'smg' => 'success',
                'TikectResultadosPorUsuario' => $TikectResultadosPorUsuario,
            ], 200);
        } else {
            return response()->json([
                'code' => 404,
                'smg' => 'Error',
                'message' => 'Error, hubo un problema comunícate con el Administrador.',
            ], 404);
        }  
    }

    public function ticketsCreadosPorDiaDelMesActual(Request $r)
    {
        if ($r->ajax()) {
            $fechaInicio = now()->startOfMonth(); // Primer día del mes actual
            $fechaFin = now()->endOfMonth(); // Último día del mes actual

            $ticketsPorDia = DB::table('tickets')
                ->select(DB::raw("DATE(created_at) as fecha"), DB::raw("COUNT(*) as total_tickets"))
                ->whereBetween('created_at', [$fechaInicio, $fechaFin]) // Filtrar por mes actual
                ->groupBy(DB::raw("DATE(created_at)")) // Agrupar por fecha
                ->orderBy('fecha', 'asc') // Ordenar por fecha
                ->get();

            // Generar todos los días del mes actual
            $diasDelMes = [];
            for ($i = 1; $i <= $fechaFin->day; $i++) {
                $diasDelMes[] = $fechaInicio->copy()->day($i)->toDateString();
            }

            // Rellenar con ceros si no hay datos para algún día
            $resultados = [];
            foreach ($diasDelMes as $dia) {
                $total = $ticketsPorDia->where('fecha', $dia)->first();
                $resultados[] = [
                    'fecha' => $dia,
                    'total_tickets' => $total ? $total->total_tickets : 0,
                ];
            }

            return response()->json([
                'code' => 200,
                'smg' => 'success',
                'data' => $resultados,
            ], 200);
        } else {
            return response()->json([
                'code' => 404,
                'smg' => 'Error',
                'message' => 'Error, hubo un problema comunicate con el Administrador.',
            ], 404);
        }
    }

    public function top5OficinasConMasSolicitudes(Request $r)
    {
        if ($r->ajax()) {
            /*$top5Oficinas = DB::table('tickets')
                ->join('personals', 'tickets.id_personal', '=', 'personals.id_personal')
                ->join('oficina_personals', 'personals.id_personal', '=', 'oficina_personals.id_personal')
                ->join('oficinas', 'oficina_personals.id_oficina', '=', 'oficinas.id_oficina')
                ->select('oficinas.nombre', DB::raw('COUNT(tickets.id_ticket) as total_solicitudes'))
                ->groupBy('oficinas.nombre')
                ->orderBy('total_solicitudes', 'desc')
                ->limit(5) // Solo 5 oficinas
                ->get();*/

            $anioActual = Carbon::now()->year;
            $top5Oficinas = DB::table('tickets')
                ->join('oficina_personals', 'tickets.id_OfiPer', '=', 'oficina_personals.id_OfiPer')
                ->join('oficinas', 'oficina_personals.id_oficina', '=', 'oficinas.id_oficina') 
                ->where('oficina_personals.anio', $anioActual) // Filtrar por el año actual
                ->where('oficina_personals.estado', 1) // Solo los que están activos
                ->select('oficinas.nombre', DB::raw('COUNT(tickets.id_ticket) as total_solicitudes'))
                ->groupBy('oficinas.nombre')
                ->orderBy('total_solicitudes', 'desc')
                ->limit(5) // Solo 5 oficinas
                ->get();

            return response()->json([
                'code' => 200,
                'smg' => 'success',
                'data' => $top5Oficinas,
            ], 200);
        }
    }

    public function top5ProblemasMasComunes(Request $r)
    {
        if ($r->ajax()) {
            $top5Problemas = DB::table('tickets')
                ->join('soportes', 'tickets.id_soporte', '=', 'soportes.id_soporte')
                ->select('soportes.nombre', DB::raw('COUNT(tickets.id_ticket) as total_problemas'))
                ->groupBy('soportes.nombre')
                ->orderBy('total_problemas', 'desc')
                ->limit(5) // Solo 5 problemas
                ->get();

            return response()->json([
                'code' => 200,
                'smg' => 'success',
                'data' => $top5Problemas,
            ], 200);
        }
    }


    public function actListar(Request $r) {

        if ($r->ajax()) {

            $asignacionUsu = AsignacionTicket::with([
                'ticket.soporte', 
                'ticket.oficinaPersonal.personal', 
                'ticket.oficinaPersonal.oficina', 
                'usuario',
            ])->orderBy('fecha_asig', 'desc')->get();

            // Preparar los datos para mostrar
            /*$data = $asignacionUsu->map(function ($asignacion) {
                $ticket = $asignacion->ticket;
                $personal = $ticket->personal;
                // Obtener la última oficina asignada, si existe
                $oficina = $personal->oficinaPersonals->last()->oficina ?? null;

                return [
                    'nombre' => $personal->nombre,
                    'incidencia' => $ticket->descripcion,
                    'personal' => $personal->nombre,
                    'oficina' => $oficina ? $oficina->nombre : 'Sin oficina'
                ];
            });*/

            //dd($asignacionUsu);
            $html = view('admin.dashboard.tabla', compact('asignacionUsu'))->render();
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

    }



    public function actListaPersonal(Request $r)
    {
        if ($r->ajax()) {
            //$Personal = Personal::orderBy('nombre', 'asc')->get();

            $Personal = Personal::select(
                'id_personal',
               DB::raw("CONCAT(nombre, ' ', apellidoPaterno, ' ', apellidoMaterno) AS nombreCompletoPersonal")
            )
            ->orderBy('nombre', 'asc')
            ->get();

            return response()->json([
                'code' => 200,
                'msg' => 'success',
                'message' => 'Personal obtenidos exitosamente!',
                'personals' => $Personal
            ], 200);
        } else {
            return response()->json([
                'code' => 404,
                'msg' => 'error',
                'message' => 'Ocurrio un problema, porfavor comunicarse con el administrador'
            ], 404);
        }
    }

    public function actListaUsuario(Request $r)
    {
        if ($r->ajax()) {
            //$usuarios = Usuario::orderBy('nombre', 'asc')->get();

            $usuarios = Usuario::select(
                 'id_usuario',
                DB::raw("CONCAT(nombre, ' ', apellidoPaterno, ' ', apellidoMaterno) AS nombreCompleto")
            )
            ->orderBy('nombre', 'asc')
            ->get();

            return response()->json([
                'code' => 200,
                'msg' => 'success',
                'message' => 'Usuarios obtenidos exitosamente!',
                'usuarios' => $usuarios
            ], 200);
        } else {
            return response()->json([
                'code' => 404,
                'msg' => 'error',
                'message' => 'Ocurrio un problema, porfavor comunicarse con el administrador'
            ], 404);
        }
    }

    public function actListaIncidencia(Request $r)
    {
        if ($r->ajax()) {
            $incidencia = Soporte::orderBy('nombre', 'asc')->get();

            return response()->json([
                'code' => 200,
                'msg' => 'success',
                'message' => 'Incidencia obtenidos exitosamente!',
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


    public function actBuscarPClave(Request $request)
    {
        if ($request->ajax()) {
            
            $query = $request->input('buscar'); // Captura la palabra clave ingresada
    
            // Filtrar los resultados con 'like' basado en la palabra clave en múltiples columnas
            $asignacionUsu = AsignacionTicket::with([
                    'ticket.soporte', 
                    'ticket.oficinaPersonal.personal', 
                    'ticket.oficinaPersonal.oficina', 
                    'usuario'
                ])
                ->whereHas('ticket.soporte', function ($q) use ($query) {
                    $q->where('nombre', 'like', '%' . $query . '%'); // Cambia 'nombre_correcto' según el nombre real de la columna en soportes
                })
                ->orWhereHas('ticket.oficinaPersonal.personal', function ($q) use ($query) {
                    $q->where('nombre', 'like', '%' . $query . '%');
                })
                ->orWhereHas('usuario', function ($q) use ($query) {
                    $q->where('nombre', 'like', '%' . $query . '%');
                })
                ->orWhereHas('ticket.oficinaPersonal.oficina', function ($q) use ($query) {
                    $q->where('nombre', 'like', '%' . $query . '%');
                })
                ->orderBy('fecha_asig', 'desc')
                ->get(); // Obtener los resultados filtrados
    
            // Verificar si se encontraron resultados
            if ($asignacionUsu->isEmpty()) {
                $html = view('Admin.dashboard.tabla', ['asignacionUsu' => []])->render(); // Renderizar una tabla vacía si no hay resultados
                return response()->json([
                    'code' => 204, 
                    'html' => $html,
                    'msg' => 'No se encontraron datos con esa búsqueda.'
                ], 200);
            }
    
            // Renderizar los resultados si se encontraron archivos
            $html = view('Admin.dashboard.tabla', ['asignacionUsu' => $asignacionUsu])->render();
    
            return response()->json([
                'code' => 200,
                'html' => $html,
                'msg' => 'success',
            ], 200);
    
        } else {
            return response()->json([
                'code' => 404,
                'msg' => 'Ocurrió un problema, por favor comuníquese con el administrador'
            ], 404);
        }
    }


    public function filtrarAsignaciones(Request $r) {
        if ($r->ajax()) {
            $idPersonal = $r->input('id_personal');
            $idUsuario = $r->input('id_usuario');
            $idSoporte = $r->input('id_soporte');
            $idOficina = $r->input('id_oficina');
            $fechaInicio = $r->input('fecha_inicio');
            $fechaFin = $r->input('fecha_fin');
    
            // Construimos la consulta base
            $asignacionUsuQuery = AsignacionTicket::with([
                'ticket.soporte',
                'ticket.oficinaPersonal.personal',
                'ticket.oficinaPersonal.oficina',
                'usuario',
            ])->orderBy('fecha_asig', 'desc');
    
            // Aplicamos los filtros
            if ($idPersonal) {
                $asignacionUsuQuery->whereHas('ticket.oficinaPersonal.personal', function ($query) use ($idPersonal) {
                    $query->where('id_personal', $idPersonal);
                });
            }
    
            if ($idUsuario) {
                $asignacionUsuQuery->whereHas('usuario', function ($query) use ($idUsuario) {
                    $query->where('id_usuario', $idUsuario);
                });
            }
    
            if ($idSoporte) {
                $asignacionUsuQuery->whereHas('ticket.soporte', function ($query) use ($idSoporte) {
                    $query->where('id_soporte', $idSoporte);
                });
            }
    
            if ($idOficina) {
                $asignacionUsuQuery->whereHas('ticket.oficinaPersonal.oficina', function ($query) use ($idOficina) {
                    $query->where('id_oficina', $idOficina);
                });
            }
    
            // Filtro por fechas
            /*if ($fechaInicio && $fechaFin) {
                $asignacionUsuQuery->whereBetween('fecha_asig', [
                    date('Y-m-d', strtotime($fechaInicio)),
                    date('Y-m-d', strtotime($fechaFin))
                ]);
            } elseif ($fechaInicio) {
                $asignacionUsuQuery->where('fecha_asig', '>=', date('Y-m-d', strtotime($fechaInicio)));
            } elseif ($fechaFin) {
                $asignacionUsuQuery->where('fecha_asig', '<=', date('Y-m-d', strtotime($fechaFin)));
            }*/

            if ($fechaInicio && $fechaFin) {
                $asignacionUsuQuery->whereBetween(DB::raw('DATE(fecha_asig)'), [
                    date('Y-m-d', strtotime($fechaInicio)),
                    date('Y-m-d', strtotime($fechaFin))
                ]);
            } elseif ($fechaInicio) {
                $asignacionUsuQuery->where(DB::raw('DATE(fecha_asig)'), '>=', date('Y-m-d', strtotime($fechaInicio)));
            } elseif ($fechaFin) {
                $asignacionUsuQuery->where(DB::raw('DATE(fecha_asig)'), '<=', date('Y-m-d', strtotime($fechaFin)));
            }
    
            // Obtenemos los resultados de la consulta
            $asignacionUsu = $asignacionUsuQuery->get();
    
            // Renderizamos la vista con los resultados
            $html = view('admin.dashboard.tabla', compact('asignacionUsu'))->render();
    
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
    }

}
