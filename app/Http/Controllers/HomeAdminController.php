<?php

namespace App\Http\Controllers;

use App\Models\AsignacionTicket;
use App\Models\Oficina;
use App\Models\Personal;
use App\Models\Soporte;
use App\Models\Ticket;
use App\Models\ticket_notificacion;
use App\Models\Usuario;
use App\Support\DashboardDateRange;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use App\Models\ChatbotInteraction;

class HomeAdminController extends Controller
{
    public function index() {

        return view('admin.dashboard.index');
        
    }

    public function actCatDatos(Request $r)
    {

        if ($r->ajax()) {

            $range = DashboardDateRange::fromRequest($r);
            $ticketQuery = $range->apply(Ticket::query(), 'fecha_env');

            $tickets = (clone $ticketQuery)->count();
            $oficinas = Oficina::count();
            $personal = Personal::count();
            $usuarios = $range->apply(Usuario::query(), 'created_at')->count();

            $ticketsAtendidos = (clone $ticketQuery)->where('estado', 3)->count();
            $ticketsRegistrados = (clone $ticketQuery)->where('estado', 1)->count();
            $ticketsProceso = (clone $ticketQuery)->where('estado', 2)->count();
            $ticketsNoAtendidos = (clone $ticketQuery)->where('estado', 4)->count();
            $ticketsCancelados = (clone $ticketQuery)->where('estado', 5)->count();

            $tiempoResolucion = DB::table('tickets as t')
                ->join('asignacion_ticket as a', 't.id_ticket', '=', 'a.id_ticket')
                ->where('a.estado', 3)
                ->where('t.estado', 3)
                ->whereBetween('a.fecha_fin', [$range->start, $range->end])
                ->whereNotNull('t.fecha_env')
                ->whereNotNull('a.fecha_fin')
                ->whereColumn('a.fecha_fin', '>=', 't.fecha_env')
                ->selectRaw('AVG(TIMESTAMPDIFF(SECOND, t.fecha_env, a.fecha_fin)) AS promedio_segundos')
                ->selectRaw('COUNT(*) AS total_tickets')
                ->first();

            $primerasAsignaciones = DB::table('asignacion_ticket')
                ->select('id_ticket')
                ->selectRaw('MIN(fecha_asig) AS fecha_asig')
                ->whereNotNull('fecha_asig')
                ->groupBy('id_ticket');

            $tiempoAsignacion = DB::table('tickets as t')
                ->joinSub($primerasAsignaciones, 'a', function ($join) {
                    $join->on('t.id_ticket', '=', 'a.id_ticket');
                })
                ->whereBetween('a.fecha_asig', [$range->start, $range->end])
                ->whereNotNull('t.fecha_env')
                ->whereColumn('a.fecha_asig', '>=', 't.fecha_env')
                ->selectRaw('AVG(TIMESTAMPDIFF(SECOND, t.fecha_env, a.fecha_asig)) AS promedio_segundos')
                ->selectRaw('COUNT(*) AS total_tickets')
                ->first();

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
                'ticketsCancelados' => $ticketsCancelados,
                'tiempoPromedioResolucionSegundos' => $tiempoResolucion->promedio_segundos !== null
                    ? (int) round($tiempoResolucion->promedio_segundos)
                    : null,
                'ticketsPromedioResolucion' => (int) $tiempoResolucion->total_tickets,
                'tiempoPromedioAsignacionSegundos' => $tiempoAsignacion->promedio_segundos !== null
                    ? (int) round($tiempoAsignacion->promedio_segundos)
                    : null,
                'ticketsPromedioAsignacion' => (int) $tiempoAsignacion->total_tickets,
            ], 200);

        } else {
            return response()->json([
                'code' => 404,
                'smg' => 'Error',
                'message' => 'Error, hubo un problema comunicate con el Administrador.',
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
            $range = DashboardDateRange::fromRequest($r);

            $cantTickSopote = Ticket::select(
                'soportes.nombre',
                DB::raw('count(tickets.id_ticket) as total')
            )
                ->join('soportes', 'tickets.id_soporte', '=', 'soportes.id_soporte')
                ->whereBetween('tickets.fecha_env', [$range->start, $range->end])
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
                'message' => 'Error, hubo un problema comunÃ­cate con el Administrador.',
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
            $range = DashboardDateRange::fromRequest($r);

            $TikectResultadosPorUsuario = DB::table('usuarios as u')
                ->join('asignacion_ticket as a', 'u.id_usuario', '=', 'a.id_usuario')
                ->join('tickets as t', 'a.id_ticket', '=', 't.id_ticket')
                ->where('a.estado', 3)
                ->where('t.estado', 3)
                ->whereBetween('a.fecha_fin', [$range->start, $range->end])
                ->select(
                    'u.id_usuario',
                    DB::raw("CONCAT(u.nombre, ' ', u.apellidoPaterno) AS nombre_completo"),
                    DB::raw('COUNT(a.id_ticket) AS tickets_resueltos')
                )
                ->groupBy('u.id_usuario', 'u.nombre', 'u.apellidoPaterno')
                ->orderByDesc('tickets_resueltos')
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
                'message' => 'Error, hubo un problema comunÃ­cate con el Administrador.',
            ], 404);
        }
    }

    public function ticketsCreadosPorDiaDelMesActual(Request $r)
    {
        if ($r->ajax()) {
            $range = DashboardDateRange::fromRequest($r);

            $ticketsPorDia = DB::table('tickets')
                ->selectRaw('DATE(fecha_env) as fecha, COUNT(*) as total_tickets')
                ->whereBetween('fecha_env', [$range->start, $range->end])
                ->groupByRaw('DATE(fecha_env)')
                ->orderBy('fecha')
                ->get()
                ->keyBy('fecha');

            // Rellenar con ceros si no hay datos para algÃºn dÃ­a
            $resultados = [];
            foreach ($range->days() as $dia) {
                $resultados[] = [
                    'fecha' => $dia,
                    'total_tickets' => (int) optional($ticketsPorDia->get($dia))->total_tickets,
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

            $range = DashboardDateRange::fromRequest($r);
            $top5Oficinas = DB::table('tickets')
                ->join('oficina_personals', 'tickets.id_OfiPer', '=', 'oficina_personals.id_OfiPer')
                ->join('oficinas', 'oficina_personals.id_oficina', '=', 'oficinas.id_oficina')
                ->whereBetween('tickets.fecha_env', [$range->start, $range->end])
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
            $range = DashboardDateRange::fromRequest($r);
            $top5Problemas = DB::table('tickets')
                ->join('soportes', 'tickets.id_soporte', '=', 'soportes.id_soporte')
                ->whereBetween('tickets.fecha_env', [$range->start, $range->end])
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


    public function actListar(Request $r)
    {

        if ($r->ajax()) {

            $range = DashboardDateRange::fromRequest($r);
            $asignacionUsu = $range->apply(AsignacionTicket::with([
                'ticket.soporte',
                'ticket.oficinaPersonal.personal',
                'ticket.oficinaPersonal.oficina',
                'usuario',
            ]), 'fecha_asig')->orderBy('fecha_asig', 'desc')->get();

            // Preparar los datos para mostrar
            /*$data = $asignacionUsu->map(function ($asignacion) {
                $ticket = $asignacion->ticket;
                $personal = $ticket->personal;
                // Obtener la Ãºltima oficina asignada, si existe
                $oficina = $personal->oficinaPersonals->last()->oficina ?? null;

                return [
                    'nombre' => $personal->nombre,
                    'incidencia' => $ticket->descripcion,
                    'personal' => $personal->nombre,
                    'oficina' => $oficina ? $oficina->nombre : 'Sin oficina'
                ];
            });*/

            // dd($asignacionUsu);
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
                'message' => 'Error, hubo un problema comunicate con el Administrador.',
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

            // Obtener todas las oficinas del a?o actual que no tienen padre, ordenadas alfab?ticamente
            $oficinas = Oficina::with('subOficinas')
                ->whereNull('id_oficina_padre')
                ->where('anio', $anioActual)  // Filtrar por el a?o actual
                ->orderBy('nombre', 'asc')
                ->get();

            // Formatear las oficinas jer?rquicamente
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
            // Agregar la oficina con el nivel actual de indentaci?n
            $resultado[] = [
                'id_oficina' => $oficina->id_oficina,
                'nombre' => str_repeat('?', $nivel) . $oficina->nombre,
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
            $search = trim((string) $request->input('buscar'));
            $range = DashboardDateRange::fromRequest($request);

            $asignacionQuery = AsignacionTicket::with([
                'ticket.soporte',
                'ticket.oficinaPersonal.personal',
                'ticket.oficinaPersonal.oficina',
                'usuario',
            ]);

            $range->apply($asignacionQuery, 'fecha_asig');

            if ($search !== '') {
                $asignacionQuery->where(function ($query) use ($search) {
                    $query->whereHas('ticket.soporte', function ($supportQuery) use ($search) {
                        $supportQuery->where('nombre', 'like', "%{$search}%");
                    })->orWhereHas('ticket.oficinaPersonal.personal', function ($personalQuery) use ($search) {
                        $personalQuery->where('nombre', 'like', "%{$search}%")
                            ->orWhere('apellidoPaterno', 'like', "%{$search}%")
                            ->orWhere('apellidoMaterno', 'like', "%{$search}%");
                    })->orWhereHas('usuario', function ($userQuery) use ($search) {
                        $userQuery->where('nombre', 'like', "%{$search}%")
                            ->orWhere('apellidoPaterno', 'like', "%{$search}%");
                    })->orWhereHas('ticket.oficinaPersonal.oficina', function ($officeQuery) use ($search) {
                        $officeQuery->where('nombre', 'like', "%{$search}%");
                    });
                });
            }

            $asignacionUsu = $asignacionQuery
                ->orderBy('fecha_asig', 'desc')
                ->get();

            // Verificar si se encontraron resultados
            if ($asignacionUsu->isEmpty()) {
                $html = view('Admin.dashboard.tabla', ['asignacionUsu' => []])->render(); // Renderizar una tabla vacÃ­a si no hay resultados

                return response()->json([
                    'code' => 204,
                    'html' => $html,
                    'msg' => 'No se encontraron datos con esa bÃºsqueda.',
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
                'msg' => 'OcurriÃ³ un problema, por favor comunÃ­quese con el administrador',
            ], 404);
        }
    }


    public function filtrarAsignaciones(Request $r)
    {
        if ($r->ajax()) {
            $idPersonal = $r->input('id_personal');
            $idUsuario = $r->input('id_usuario');
            $idSoporte = $r->input('id_soporte');
            $idOficina = $r->input('id_oficina');
            $range = DashboardDateRange::fromRequest($r);

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

            $range->apply($asignacionUsuQuery, 'fecha_asig');

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
                'message' => 'Error, hubo un problema comunicate con el Administrador.',
            ], 404);
        }
    } 

    public function getTicketNotificacionGlobal()
    {
        $totalNotificaciones = ticket_notificacion::count();
        $totalAbiertas = ticket_notificacion::where('abierta', true)->count();
        $tasaGlobal = $totalNotificaciones > 0 ? ($totalAbiertas / $totalNotificaciones) * 100 : 0;

        return response()->json([
            'code' => 200,
            'data' => [
                'tasaGlobal' => round($tasaGlobal,2),
                'totalNotificaciones' => $totalNotificaciones
            ]
        ]);
    }

    public function getTicketNotificacionPorTicket()
    {
        $estadisticasPorTicket = ticket_notificacion::select(
                'id_ticket',
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(abierta) as abiertas')
            )
            ->groupBy('id_ticket')
            ->get();

        return response()->json([
            'code' => 200,
            'data' => $estadisticasPorTicket
        ]);
    }

    public function getTicketNotificacionPorUsuario()
    {
        $estadisticasPorUsuario = ticket_notificacion::select(
                'id_usuario',
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(abierta) as abiertas')
            )
            ->groupBy('id_usuario')
            ->get();

        return response()->json([
            'code' => 200,
            'data' => $estadisticasPorUsuario
        ]);
    }

}
