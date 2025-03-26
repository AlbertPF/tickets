<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ActividadController extends Controller
{
    public function index()
    {
        return view('admin.bitacora.actividad.index');
    }

    public function actListar(Request $r) 
    {
        if ($r->ajax()){
            
            $actividads = Actividad::all();

            $html = view('admin.bitacora.actividad.tabla', compact('actividads'))->render();

            return response()->json([
                'code' => 200,
                'html' => $html,
                'msg' => 'success'
            ], 200);
        } else {
            return response()->json([
                'code' => 404,
                'smg'  => 'error',
                'message' => 'Ocurrio un problema, porfavor comunicarse con el administrador'
            ]);
        }
    }

    public function actRegistrar(Request $r)
    {
        if ($r->ajax()) {

            $tipo_form = $r->tipo_formulario;

            $rules = [
                'nombre' => 'required|unique:actividades,nombre,' . ($r->id_act_editar ?? 'null') . ',id_actividad',
            ];

            $messages = [
                'nombre.unique' => 'El nombre de la Actividad ya está registrado.',
            ];

            $validator = Validator::make($r->all(), $rules, $messages);

            if ($validator->fails()) {
                return response()->json([
                    'code' => 422,
                    'msg' => 'error',
                    'message' => $validator->errors()->first()
                ], 422);
            }

            if ($tipo_form == 1) { //agregar

                $act = Actividad::create([
                    'nombre' => $r->nombre,
                    'descripcion' => $r->descripcion,
                ]);

                if ($act) {
                    return response()->json([
                        'code' => 200,
                        'msg' => 'success',
                        'message' => 'Actividad registrado exitosamente!'
                    ], 200);
                } else {
                    return response()->json([
                        'code' => 404,
                        'msg' => 'error',
                        'message' => 'Error, no se puedo registrar'
                    ], 404);
                }
            } else { //editar

                $id_actividad = $r->id_act_editar;

                // Obtener la categoría original
                $act = Actividad::findOrFail($id_actividad);

                // Inicializar datos a actualizar
                $dataToUpdate = [
                    'nombre' => $r->nombre,
                    'descripcion' => $r->descripcion,
                    'updated_at'=> Carbon::now('America/Lima')->format('Y-m-d H:i:s')
                ];

                DB::table('actividades')
                    ->where('id_actividad', '=', $id_actividad)
                    ->update($dataToUpdate);

                return response()->json([
                    'code' => 200,
                    'msg' => 'success',
                    'message' => 'Actividad actualizada correctamente!'
                ], 200);
            }

        } else {
            return response()->json([
                'code' => 404,
                'msg' => 'error',
                'message' => 'Ocurrio un problema, porfavor comunicarse con el administrador'
            ], 404);
        }
    }

    public function actEditar(Request $r)
    {
        if ($r->ajax()) {
            $act = Actividad::find($r->id_actividad);

            return response()->json([
                'code' => 200,
                'msg' => 'success',
                'message' => '¡actividad Encontrada!',
                'act' => $act,
            ], 200);
        } else {
            return response()->json([
                'code' => 404,
                'msg' => 'error',
                'message' => 'Ocurrio un problema, porfavor comunicarse con el administrador'
            ], 404);
        }
    }

    public function actEliminar(Request $r)
    {
        if ($r->ajax()) {

            $act = Actividad::find($r->id_actividad);

            if ($act) {

                $act->delete();

                return response()->json([
                    'code' => 200,
                    'msg' => 'success',
                    'message' => 'Actividad eliminado correctamente.!',
                ], 200);
            }
        } else {
            return response()->json([
                'code' => 404,
                'msg' => 'error',
                'message' => 'Ocurrio un problema, porfavor comunicarse con el administrador'
            ], 404);
        }
    }

    public function actListaActividad(Request $r)
    {
        if ($r->ajax()) {
            $acts = Actividad::orderBy('nombre', 'asc')->get();

            return response()->json([
                'code' => 200,
                'msg' => 'success',
                'message' => 'Actividades obtenidos exitosamente!',
                'acts' => $acts,
            ], 200);
        } else {
            return response()->json([
                'code' => 404,
                'msg' => 'error',
                'message' => 'Ocurrio un problema, porfavor comunicarse con el administrador'
            ], 404);
        }
    }
}
