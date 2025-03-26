<?php

namespace App\Http\Controllers;

use App\Models\Oficina;
use App\Models\OficinaPersonal;
use App\Models\Personal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OficinaPeronsalController extends Controller
{
    public function index()
    {
        return view('admin.personal.Asignacion.index');
    }

    public function actListar(Request $r)
    {

        if ($r->ajax()) {

            //$ofiPersonals = OficinaPersonal::all();
            $ofiPersonals = OficinaPersonal::with(['personal', 'oficina'])->get();

            $html = view('admin.personal.Asignacion.tabla', compact('ofiPersonals'))->render();

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

    public function actAsignar(Request $r)
    {
        if ($r->ajax()) {

            // Definir las reglas de validación
            $rules = [
                'id_personal' => 'required',
                'estado' => 'required',
                'id_oficina' => 'required',
            ];

            // Mensajes personalizados para las validaciones
            $messages = [
                'id_personal.required' => 'Personal es obligatorio.',
                'estado.required' => 'El estado es obligatorio.',
                'id_oficina.required' => 'La oficina es obligatoria.',
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

            DB::beginTransaction(); // Iniciar una transacción

            try {
                $anioActual = Carbon::now()->year;

                if ($r->tipo_formulario == 1) { // Agregar nuevo personal

                    // Verificar si el personal ya tiene una asignación activa (estado 1) en la misma oficina y en el año actual
                    $asignacionExistente = OficinaPersonal::where('id_personal', $r->id_personal)
                        ->where('anio', $anioActual)
                        ->where('id_oficina', $r->id_oficina)
                        ->first();

                    if ($asignacionExistente) {
                        if ($asignacionExistente->estado == 1) {
                            return response()->json([
                                'code' => 409, // Conflicto
                                'msg' => 'error',
                                'message' => 'El personal ya está asignado a esta oficina en el año actual con estado activo.'
                            ], 409);
                        } else {
                            // Si la asignación existe pero está inactiva, actualizamos el estado a activo
                            //$asignacionExistente->update(['estado' => 1]);
                            /*OficinaPersonal::create([
                                'anio' => $anioActual,  // Asegúrate de que el año sea correcto
                                'estado' => $r->estado,
                                'id_oficina' => $r->id_oficina,
                                'id_personal' => $r->id_personal
                            ]);

                            DB::commit(); // Confirmar la transacción
                            return response()->json([
                                'code' => 200,
                                'msg' => 'success',
                                'message' => 'Asignación reactivada correctamente!'
                            ], 200);*/
                        }
                    }

                    // Desactivar cualquier otra asignación activa para el personal en el año actual
                    OficinaPersonal::where('id_personal', $r->id_personal)
                        ->where('anio', $anioActual)
                        ->where('estado', 1)
                        ->update(['estado' => 0]);

                    // Crear una nueva asignación en la tabla "oficina_personal"
                    OficinaPersonal::create([
                        'anio' => $anioActual,
                        'estado' => $r->estado,
                        'id_oficina' => $r->id_oficina,
                        'id_personal' => $r->id_personal
                    ]);

                    DB::commit(); // Confirmar la transacción
                    return response()->json([
                        'code' => 200,
                        'msg' => 'success',
                        'message' => 'Asignación de personal registrada exitosamente!'
                    ], 200);

                } else { // Editar personal existente
                        }

            } catch (\Exception $e) {
                DB::rollBack(); // Revertir la transacción en caso de excepción

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

    /*public function actEditar(Request $r)
    {
        if ($r->ajax()) {

            //$asigPersonal = OficinaPersonal::where('id_personal', $r->id_personal)->first();

            $asigPersonal = OficinaPersonal::where('id_personal', $r->id_personal)
            ->where('anio', $r->anio)  // Filtro por año
            ->first();

            $personals = Personal::all(); 
            
            $anioActual = Carbon::now()->year;
            // Obtener todas las oficinas del año actual que no tienen padre, ordenadas alfabéticamente
            $oficinas = Oficina::with('subOficinas')
                ->whereNull('id_oficina_padre')
                ->where('anio', $anioActual)
                ->orderBy('nombre', 'asc')
                ->get();

            $oficinasOrdenadas = $this->ordenarOficinas($oficinas);

            // Verifica si se encontró el personal
            if ($asigPersonal) {
                return response()->json([
                    'code' => 200,
                    'msg' => 'success',
                    'message' => 'Usuario Encontrado!',
                    'asigPersonal' => $asigPersonal,
                    'personals' => $personals, 
                    'oficinas' => $oficinasOrdenadas  
                ], 200);
            } else {
                return response()->json([
                    'code' => 404,
                    'msg' => 'error',
                    'message' => 'Asignación de personal no encontrado'
                ], 404);
            }
        } else {
            return response()->json([
                'code' => 404,
                'msg' => 'error',
                'message' => 'Ocurrió un problema, por favor comuníquese con el administrador'
            ], 404);
        }
    }*/
}
