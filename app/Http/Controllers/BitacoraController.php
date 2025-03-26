<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use App\Models\Bitacora;
use App\Models\Oficina;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class BitacoraController extends Controller
{
    public function index()
    {
        return view('admin.bitacora.index');
    }

    public function actListar(Request $r)
    {

        $usuarioActual = Session::has('usuario') == true ? Session::get('usuario')->id_usuario : null;

        if ($usuarioActual) {
            //$miBitacoras = Bitacora::all();
            /*$miBitacoras = Bitacora::with(['personal', 'usuario'])
                ->where('id_usuario', $usuarioActual)
                ->get();*/

            $miBitacoras = Bitacora::with(['usuario', 'oficina'])
                ->where('id_usuario', $usuarioActual)
                ->get();

            // Renderizar la vista con los tickets asignados
            $html = view('admin.bitacora.tabla', compact('miBitacoras'))->render();

            return response()->json([
                'code' => 200,
                'html' => $html,
                'msg' => 'success',
            ], 200);
        } else {
            // Si no hay un usuario autenticado, retornar un error
            return response()->json([
                'code' => 401,
                'msg' => 'error',
                'message' => 'Actividad no autenticado',
            ], 401);
        }
    }

    public function actRegistrar(Request $r)
    {
        if ($r->ajax()) {

            // Definir las reglas de validación
            $rules = [
                'id_actividad' => 'required'
            ];

            // Mensajes personalizados para las validaciones
            $messages = [
                'id_actividad.required' => 'La actividad es obligatorio.'
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
                if ($r->tipo_formulario == 1) { // Agregar nueva actividad
                   
                    $actual = Carbon::now('America/Lima');
                    // Inserción en la tabla "Actividad"
                    $Actividad = Bitacora::create([
                        'id_actividad' => $r->id_actividad,
                        'doc_ref' => $r->doc_ref,
                        'fecha_reg' => $actual,
                        'descripcion' => $r->descripcion,
                        'id_oficina' => $r->id_oficina,
                        'estado' => '1',
                        'id_usuario' => Session::has('usuario') == true ? Session::get('usuario')->id_usuario : null,
                    ]);


                    DB::commit(); // Confirmar la transacción

                    return response()->json([
                        'code' => 200,
                        'msg' => 'success',
                        'message' => 'Actividad registrado exitosamente!'
                    ], 200);

                } else { // Editar personal existente

                    // Buscar el personal a editar
                    $id_bitacora = $r->id_actividad_editar;
                    $actividad = Bitacora::find($id_bitacora);

                    if ($actividad) {
                        // Actualizar datos en la tabla "bitacora"
                        $actividad->update([
                           'id_actividad' => $r->id_actividad,
                            'doc_ref' => $r->doc_ref,
                            'descripcion' => $r->descripcion,
                            'id_oficina' => $r->id_oficina,
                        ]);
                       

                        DB::commit(); // Confirmar la transacción

                        return response()->json([
                            'code' => 200,
                            'msg' => 'success',
                            'message' => 'Actividad actualizado correctamente!'
                        ], 200);

                    } else {
                        DB::rollBack(); // Revertir la transacción en caso de error

                        return response()->json([
                            'code' => 404,
                            'msg' => 'error',
                            'message' => 'Actividad no encontrado'
                        ], 404);
                    }
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
                'message' => 'Ocurrio un problema, por favor comunicarse con el administrador'
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

    public function actEditar(Request $r)
    {
        if ($r->ajax()) {

            $actividad = Bitacora::find($r->id_bitacora);
            $act = Actividad::all();
            
            
            $anioActual = Carbon::now()->year;
            // Obtener todas las oficinas del año actual que no tienen padre, ordenadas alfabéticamente
            $oficinas = Oficina::with('subOficinas')
                ->whereNull('id_oficina_padre')
                ->where('anio', $anioActual)  // Filtrar por el año actual
                ->orderBy('nombre', 'asc')
                ->get();

            $oficinasOrdenadas = $this->ordenarOficinas($oficinas);

            // Obtener la oficina asociada a la actividad
            $oficinaAsignada = null;
            if ($actividad && $actividad->id_oficina) {
                $oficinaAsignada = Oficina::find($actividad->id_oficina);
            }

            // Verifica si se encontró el personal
            if ($actividad) {
                return response()->json([
                    'code' => 200,
                    'msg' => 'success',
                    'message' => 'Usuario Encontrado!',
                    'actividad' => $actividad,
                    'oficinas' => $oficinasOrdenadas,
                    'oficinaAsignada' => $oficinaAsignada, // Envío de las oficinas
                    'acts' => $act,
                ], 200);
            } else {
                return response()->json([
                    'code' => 404,
                    'msg' => 'error',
                    'message' => 'Actividad no encontrado'
                ], 404);
            }
        } else {
            return response()->json([
                'code' => 404,
                'msg' => 'error',
                'message' => 'Ocurrió un problema, por favor comuníquese con el administrador'
            ], 404);
        }
    }

    public function actVer(Request $r)
    {
        if ($r->ajax()) {
            $id_bitacora = $r->id_bitacora;

            $bitacora = Bitacora::with(['oficina', 'usuario','actividad'])
                ->where('id_bitacora', $id_bitacora)
                ->first();

            $bitacora->estado_nombre = $bitacora->getEstadoNombre();
            $bitacora->estado_clase = $bitacora->getEstadoClase();

            if ($bitacora) {
                return response()->json([
                    'code' => 200,
                    'msg' => 'success',
                    'message' => 'Actividad encontrado correctamente!',
                    'bitacora' => $bitacora,
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

    public function actAtender(Request $r)
    {
        if ($r->ajax()) {
             // Buscar el personal a editar
             $actividad = Bitacora::find($r->id_bitacora);
             DB::beginTransaction(); // Iniciar una transacción
             if ($actividad) {
                 // Actualizar datos en la tabla "bitacora"
                 $actividad->update([
                    'estado' => '2', 
                 ]);

                 DB::commit(); 

                 return response()->json([
                     'code' => 200,
                     'msg' => 'success',
                     'message' => 'Actividad actualizado correctamente!'
                 ], 200);

             } else {
                 DB::rollBack(); // Revertir la transacción en caso de error

                 return response()->json([
                     'code' => 404,
                     'msg' => 'error',
                     'message' => 'Actividad no encontrado'
                 ], 404);
             }
        }

        return response()->json([
            'code' => 400,
            'msg' => 'error',
            'message' => 'Solicitud no válida.'
        ], 400);
    }


    public function actEliminar(Request $r)
    {
        if ($r->ajax()) {

            $bitacora = Bitacora::find($r->id_bitacora);

            if ($bitacora) {

                $bitacora->delete();

                return response()->json([
                    'code' => 200,
                    'msg' => 'success',
                    'message' => 'Actividad eliminado correctamente.!',
                    'bitacora'  => $bitacora
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

    public function actFinalizar(Request $r)
    {
        if ($r->ajax()) {
            DB::beginTransaction();

            try {
                // Obtener el ID de la actividad a editar
                $id_bitacora = $r->id_actividad_finalizar;
                $actividad = Bitacora::find($id_bitacora);
                $actual = Carbon::now('America/Lima');

                if ($actividad) {
                    // Actualizar los datos
                    $actividad->update([
                        'doc_aten' => $r->doc_aten,
                        'fecha_aten' => $actual,
                        'estado' => 3,
                    ]);

                    DB::commit();

                    return response()->json([
                        'code' => 200,
                        'msg' => 'success',
                        'message' => 'Actividad finalizada correctamente!'
                    ], 200);
                } else {
                    DB::rollBack();
                    return response()->json([
                        'code' => 404,
                        'msg' => 'error',
                        'message' => 'Actividad no encontrada'
                    ], 404);
                }
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json([
                    'code' => 500,
                    'msg' => 'error',
                    'message' => 'Error en el servidor: ' . $e->getMessage()
                ], 500);
            }
        }

        return response()->json([
            'code' => 404,
            'msg' => 'error',
            'message' => 'Ocurrió un problema, comuníquese con el administrador'
        ], 404);
    }

}
