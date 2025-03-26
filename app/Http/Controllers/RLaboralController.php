<?php

namespace App\Http\Controllers;

use App\Models\Regimen_Laboral;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RLaboralController extends Controller
{
    public function index()
    {
        return view('admin.regimen_laboral.index');
    }

    public function actListar(Request $r) 
    {
        if ($r->ajax()){
            $rlaborals = Regimen_Laboral::all();

            $html = view('admin.regimen_laboral.tabla', compact('rlaborals'))->render();

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
                'nombre' => 'required|unique:regimen_laborals,nombre,' . ($r->id_rlaboral_editar ?? 'null') . ',id_rl',
            ];

            $messages = [
                'nombre.unique' => 'El nombre de Régimen Laboral ya está registrado.',
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

                $rlaboral = Regimen_Laboral::create([
                    'nombre' => $r->nombre,
                    'descripcion' => $r->descripcion,
                ]);

                if ($rlaboral) {
                    return response()->json([
                        'code' => 200,
                        'msg' => 'success',
                        'message' => 'Régimen laboral registrado exitosamente!'
                    ], 200);
                } else {
                    return response()->json([
                        'code' => 404,
                        'msg' => 'error',
                        'message' => 'Error, no se puedo registrar'
                    ], 404);
                }
            } else { //editar

                $id_rl = $r->id_rlaboral_editar;

                // Obtener la categoría original
                $rlaboral = Regimen_Laboral::findOrFail($id_rl);

                // Inicializar datos a actualizar
                $dataToUpdate = [
                    'nombre' => $r->nombre,
                    'descripcion' => $r->descripcion,
                    'updated_at'=> Carbon::now('America/Lima')->format('Y-m-d H:i:s')
                ];

                DB::table('regimen_laborals')
                    ->where('id_rl', '=', $id_rl)
                    ->update($dataToUpdate);

                return response()->json([
                    'code' => 200,
                    'msg' => 'success',
                    'message' => 'Régimen laboral actualizada correctamente!'
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
            $rlaboral = Regimen_Laboral::find($r->id_rl);

            return response()->json([
                'code' => 200,
                'msg' => 'success',
                'message' => '¡Régimen Laboral Encontrada!',
                'rlaboral' => $rlaboral,
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

            $rlaboral = Regimen_Laboral::find($r->id_rl);

            if ($rlaboral) {

                $rlaboral->delete();

                return response()->json([
                    'code' => 200,
                    'msg' => 'success',
                    'message' => 'Régimen Laboral eliminado correctamente.!',
                    'usuario'  => $rlaboral
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
