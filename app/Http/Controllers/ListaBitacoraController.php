<?php

namespace App\Http\Controllers;

use App\Models\Bitacora;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ListaBitacoraController extends Controller
{
    public function index()
    {
        return view('admin.bitacora.lista.index');
    }

    public function actListar(Request $r)
    {
        if ($r->ajax()) {

            //$listBitacoras = Bitacora::all();
            $listBitacoras = Bitacora::with(['oficina', 'usuario', 'actividad'])->get();

            $html = view('admin.bitacora.lista.tabla', compact('listBitacoras'))->render();

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
            $id_bitacora = $r->id_bitacora;

            $ListBitacora = Bitacora::with(['oficina', 'usuario'])
                ->where('id_bitacora', $id_bitacora)
                ->first();

            $ListBitacora->estado_nombre = $ListBitacora->getEstadoNombre();
            $ListBitacora->estado_clase = $ListBitacora->getEstadoClase();

            if ($ListBitacora) {
                return response()->json([
                    'code' => 200,
                    'msg' => 'success',
                    'message' => 'Actividad encontrado correctamente!',
                    'ListBitacora' => $ListBitacora,
                ], 200);
            } else {
                return response()->json([
                    'code' => 404,
                    'msg' => 'error',
                    'message' => 'Actividad no encontrado.'
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

    /*public function actFiltrar(Request $r)
    {
        if ($r->ajax()){
            
            $filtradoAct = Bitacora::with(['oficina', 'usuario']);

            // Si se recibe un id_usuario, filtrar por el usuario
            if ($r->has('id_usuario') && $r->id_usuario) {
                $filtradoAct->where('id_usuario', $r->id_usuario);
            }
        
            // Obtener los resultados filtrados
            $listBitacoras = $filtradoAct->get();
        
            // Renderizar la tabla y enviarla a la vista
            $html = view('admin.bitacora.lista.tabla', compact('listBitacoras'))->render();
        
            return response()->json([
                'code' => 200,
                'html' => $html,
                'msg' => 'success',
            ], 200);
        
        } else {
            return response()->json([
                'code' => 404,
                'msg' => 'error',
                'message' => 'Ocurrió un problema, por favor comunicarse con el administrador.'
            ], 404);
        }
    }*/

    public function actFiltrar(Request $r) {
        if ($r->ajax()) {

            $r->validate([
                'fecha_inicio' => 'required|date_format:Y-m-d',
                'fecha_fin' => 'required|date_format:Y-m-d|after_or_equal:fecha_inicio',
                'id_usuario' => 'nullable|string|max:20'
            ]);

            $idUsuario = $r->input('id_usuario');
            $fechaInicio = $r->input('fecha_inicio');
            $fechaFin = $r->input('fecha_fin');
    
            $bitacoraQuery = Bitacora::with(['oficina', 'usuario'])
                ->whereDate('fecha_reg', '>=', $fechaInicio)
                ->whereDate('fecha_reg', '<=', $fechaFin)
                ->orderBy('fecha_reg', 'desc');
    
            // filtro
            if ($idUsuario !== null && $idUsuario !== '') {
                $bitacoraQuery->where('id_usuario', $idUsuario);
            }

            $listBitacoras = $bitacoraQuery->get();

            $html = view('admin.bitacora.lista.tabla', compact('listBitacoras'))->render();
    
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

    public function getActividadesUsuarios(Request $request)
    {
        if ($request->ajax()) {
            $usuariosActividades = Bitacora::with('usuario')
                ->orderBy('fecha_reg', 'desc')
                ->get()
                ->groupBy('id_usuario')
                ->map(function ($actividades, $usuarioId) {
                    $usuario = $actividades->first()->usuario; // Obtener usuario
                    return [
                        'nombre' => $usuario->nombre . ' ' . $usuario->apellidoPaterno . ' ' . $usuario->apellidoMaterno,
                        'actividades' => [
                            'Pendiente' => $actividades->where('estado', '1')->count(),
                            'En Proceso' => $actividades->where('estado', '2')->count(),
                            'Atendido' => $actividades->where('estado', '3')->count(),
                            'Cancelado' => $actividades->where('estado', '4')->count(),
                        ]
                    ];
                })
                ->values(); // Convertir a array de valores

            return response()->json([
                'code' => 200,
                'msg' => 'success',
                'usuariosActividades' => $usuariosActividades,
            ], 200);
        }
    }

}
