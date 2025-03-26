<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ResumenGeneralController extends Controller
{
    public function index()
    {
        return view('admin.Resumen.index');
    }

    public function actListar(Request $r)
    {
        // Consulta con UNION ALL sin filtrar por usuario
        $actGeneral = DB::select("
            SELECT 
                CONCAT(u.nombre, ' ', u.apellidoPaterno, ' ', u.apellidoMaterno) AS Usuario,
                a.nombre AS Incidencia,
                b.descripcion AS Descripción,
                b.fecha_reg AS Fecha_reg,
                b.estado AS Estado,
                b.fecha_aten AS Fecha_aten
            FROM bitacora_trabajo b
            LEFT JOIN actividades a ON b.id_actividad = a.id_actividad
            LEFT JOIN usuarios u ON b.id_usuario = u.id_usuario

            UNION ALL

            SELECT 
                CONCAT(u.nombre, ' ', u.apellidoPaterno, ' ', u.apellidoMaterno) AS Usuario,
                s.nombre AS Incidencia,
                t.descripcion AS Descripción,
                at.fecha_asig AS Fecha_reg,
                at.estado AS Estado,
                at.fecha_fin AS Fecha_aten
            FROM asignacion_ticket at
            LEFT JOIN tickets t ON at.id_ticket = t.id_ticket
            LEFT JOIN soportes s ON t.id_soporte = s.id_soporte
            LEFT JOIN usuarios u ON at.id_usuario = u.id_usuario
        ");

        // Renderizar la vista con los datos obtenidos
        $html = view('admin.Resumen.tabla', compact('actGeneral'))->render();

        return response()->json([
            'code' => 200,
            'html' => $html,
            'msg' => 'success',
        ], 200);
    }

    public function actFiltrar(Request $r)
    {
        if ($r->ajax()) {
            $idUsuario = $r->input('id_usuario');
            $fechaInicio = $r->input('fecha_inicio');
            $fechaFin = $r->input('fecha_fin');

            // Primera consulta
            $query1 = DB::table('bitacora_trabajo AS b')
                ->selectRaw("CONCAT(u.nombre, ' ', u.apellidoPaterno, ' ', u.apellidoMaterno) AS Usuario,
                            a.nombre AS Incidencia, 
                            b.descripcion AS Descripción, 
                            b.fecha_reg AS Fecha_reg, 
                            b.estado AS Estado, 
                            b.fecha_aten AS Fecha_aten")
                ->leftJoin('actividades AS a', 'b.id_actividad', '=', 'a.id_actividad')
                ->leftJoin('usuarios AS u', 'b.id_usuario', '=', 'u.id_usuario');

            if (!empty($idUsuario)) {
                $query1->where('b.id_usuario', $idUsuario);
            }
            if (!empty($fechaInicio) && !empty($fechaFin)) {
                $query1->whereBetween(DB::raw('DATE(b.fecha_reg)'), [
                    date('Y-m-d', strtotime($fechaInicio)),
                    date('Y-m-d', strtotime($fechaFin))
                ]);
            } elseif (!empty($fechaInicio)) {
                $query1->whereDate('b.fecha_reg', '>=', date('Y-m-d', strtotime($fechaInicio)));
            } elseif (!empty($fechaFin)) {
                $query1->whereDate('b.fecha_reg', '<=', date('Y-m-d', strtotime($fechaFin)));
            }

            // Segunda consulta
            $query2 = DB::table('asignacion_ticket AS at')
                ->selectRaw("CONCAT(u.nombre, ' ', u.apellidoPaterno, ' ', u.apellidoMaterno) AS Usuario,
                            s.nombre AS Incidencia, 
                            t.descripcion AS Descripción, 
                            at.fecha_asig AS Fecha_reg, 
                            at.estado AS Estado, 
                            at.fecha_fin AS Fecha_aten")
                ->leftJoin('tickets AS t', 'at.id_ticket', '=', 't.id_ticket')
                ->leftJoin('soportes AS s', 't.id_soporte', '=', 's.id_soporte')
                ->leftJoin('usuarios AS u', 'at.id_usuario', '=', 'u.id_usuario');

            if (!empty($idUsuario)) {
                $query2->where('at.id_usuario', $idUsuario);
            }
            if (!empty($fechaInicio) && !empty($fechaFin)) {
                $query2->whereBetween(DB::raw('DATE(at.fecha_asig)'), [
                    date('Y-m-d', strtotime($fechaInicio)),
                    date('Y-m-d', strtotime($fechaFin))
                ]);
            } elseif (!empty($fechaInicio)) {
                $query2->whereDate('at.fecha_asig', '>=', date('Y-m-d', strtotime($fechaInicio)));
            } elseif (!empty($fechaFin)) {
                $query2->whereDate('at.fecha_asig', '<=', date('Y-m-d', strtotime($fechaFin)));
            }

            // Unir las dos consultas
            $actGeneral = $query1->unionAll($query2)->get();

            // Renderizar la vista con los datos obtenidos
            $html = view('admin.Resumen.tabla', compact('actGeneral'))->render();

            return response()->json([
                'code' => 200,
                'html' => $html,
                'msg' => 'success',
            ], 200);
        } else {
            return response()->json([
                'code' => 404,
                'msg' => 'error',
                'message' => 'Error, hubo un problema, comunícate con el Administrador.'
            ], 404);
        }
    }
}
