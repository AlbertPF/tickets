<?php

namespace App\Http\Controllers;

use App\Models\Soporte;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SoporteController extends Controller
{
    public function index(){

        return view('admin.soporte.index');

    }

    public function actListar(Request $r) 
    {
        if ($r->ajax()){
            $incidencias = Soporte::all();

            $html = view('admin.soporte.tabla', compact('incidencias'))->render();

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
                'nombre' => 'required|unique:soportes,nombre,' . ($r->id_incidencia_editar ?? 'null') . ',id_soporte',
                'estado' => 'required',
            ];

            $messages = [
                'nombre.unique' => 'El nombre de incicencia ya está registrado.',
                'estado.required' => 'El estado es obligatorio.',
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

                $rlaboral = Soporte::create([
                    'nombre' => $r->nombre,
                    'estado' => $r->estado,
                    'descripcion' => $r->descripcion,
                ]);

                //dd($r->all());

                if ($rlaboral) {
                    return response()->json([
                        'code' => 200,
                        'msg' => 'success',
                        'message' => 'Incidencia registrado exitosamente!'
                    ], 200);
                } else {
                    return response()->json([
                        'code' => 404,
                        'msg' => 'error',
                        'message' => 'Error, no se puedo registrar'
                    ], 404);
                }
            } else { //editar

                $id_soporte = $r->id_incidencia_editar;

                // Obtener la categoría original
                $rlaboral = Soporte::findOrFail($id_soporte);

                // Inicializar datos a actualizar
                $dataToUpdate = [
                    'nombre' => $r->nombre,
                    'estado' => $r->estado,
                    'descripcion' => $r->descripcion,
                    'updated_at'=> Carbon::now('America/Lima')->format('Y-m-d H:i:s')
                ];

                DB::table('soportes')
                    ->where('id_soporte', '=', $id_soporte)
                    ->update($dataToUpdate);

                return response()->json([
                    'code' => 200,
                    'msg' => 'success',
                    'message' => 'Incidencia actualizada correctamente!'
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
            $incidecias = Soporte::find($r->id_soporte);

            return response()->json([
                'code' => 200,
                'msg' => 'success',
                'message' => '¡Incidencia Encontrada!',
                'incidecias' => $incidecias,
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

            $incidencia = Soporte::find($r->id_soporte);

            if ($incidencia) {

                $incidencia->delete();

                return response()->json([
                    'code' => 200,
                    'msg' => 'success',
                    'message' => 'Incidencia eliminado correctamente.!',
                    'incidencia'  => $incidencia
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

}
