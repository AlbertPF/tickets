<?php

namespace App\Http\Controllers;

use App\Models\Oficina;
use App\Models\OficinaPersonal;
use App\Models\Personal;
use App\Models\Regimen_Laboral;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PersonalController extends Controller
{
    public function index()
    {
        return view('admin.personal.index');
    }

    public function actListar(Request $r)
    {

        if ($r->ajax()) {

            $personals = Personal::all();
            //dd($personals);

            $html = view('admin.personal.tabla', compact('personals'))->render();


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

    public function actListaRlaboral(Request $r)
    {
        if ($r->ajax()) {
            $RLaboral = Regimen_Laboral::orderBy('nombre', 'asc')->get();

            return response()->json([
                'code' => 200,
                'msg' => 'success',
                'message' => 'Regiman Laboral obtenidos exitosamente!',
                'regimenes' => $RLaboral
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

    public function actRegistrar(Request $r)
    {
        if ($r->ajax()) {

            // Definir las reglas de validación
            $rules = [
                'dni' => 'required|digits:8|unique:personals,dni,' . ($r->id_personal_editar ?? 'null') . ',id_personal',
                'telefono' => 'required|digits:9|unique:personals,telefono,' . ($r->id_personal_editar ?? 'null') . ',id_personal',
                'id_rl' => 'required',
                'estado' => 'required',
                'id_oficina' => 'required',
            ];

            // Mensajes personalizados para las validaciones
            $messages = [
                'dni.unique' => 'El DNI ya está registrado.',
                'telefono.unique' => 'El número telefónico ya está en uso.',
                'id_rl.required' => 'Regimen Laboral es obligatorio.',
                'estado.required' => 'El estado es obligatorio.',
                'id_oficina.required' => 'La oficina es obligatorio.',
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
                if ($r->tipo_formulario == 1) { // Agregar nuevo personal

                    // Inserción en la tabla "personals"
                    $personal = Personal::create([
                        'dni' => $r->dni,
                        'nombre' => $r->nombre,
                        'apellidoPaterno' => $r->apellidoPaterno,
                        'apellidoMaterno' => $r->apellidoMaterno,
                        'id_rl' => $r->id_rl,
                        'telefono' => $r->telefono
                    ]);

                    // Inserción en la tabla intermedia "oficina_personal"
                    OficinaPersonal::create([
                        'anio' => $r->anio,
                        'estado' => $r->estado,
                        'id_oficina' => $r->id_oficina,
                        'id_personal' => $personal->id_personal // Relación con el personal recién creado
                    ]);

                    DB::commit(); // Confirmar la transacción

                    return response()->json([
                        'code' => 200,
                        'msg' => 'success',
                        'message' => 'Personal registrado exitosamente!'
                    ], 200);

                } else { // Editar personal existente

                    // Buscar el personal a editar
                    $id_personal = $r->id_personal_editar;
                    $personal = Personal::find($id_personal);

                    if ($personal) {
                        // Actualizar datos en la tabla "personals"
                        $personal->update([
                            'dni' => $r->dni,
                            'nombre' => $r->nombre,
                            'apellidoPaterno' => $r->apellidoPaterno,
                            'apellidoMaterno' => $r->apellidoMaterno,
                            'id_rl' => $r->id_rl,
                            'telefono' => $r->telefono
                        ]);

                        // Actualizar la asignación en la tabla intermedia "oficina_personal"
                        /*OficinaPersonal::where('id_personal', $id_personal)
                            ->update([
                                'anio' => $r->anio,
                                'estado' => $r->estado,
                                'id_oficina' => $r->id_oficina
                            ]);*/

                        // Buscar la última asignación del personal en la tabla "oficina_personal"
                        $ultimaAsignacion = OficinaPersonal::where('id_personal', $id_personal)
                            ->orderBy('created_at', 'desc') // Ordenar por la fecha de creación descendente
                            ->first(); // Tomar el último registro

                        // Si existe una asignación, actualizar solo la última
                        if ($ultimaAsignacion) {
                            $ultimaAsignacion->update([
                                'anio' => $r->anio,
                                'estado' => $r->estado,
                                'id_oficina' => $r->id_oficina
                            ]);
                        }


                        DB::commit(); // Confirmar la transacción

                        return response()->json([
                            'code' => 200,
                            'msg' => 'success',
                            'message' => 'Personal actualizado correctamente!'
                        ], 200);

                    } else {
                        DB::rollBack(); // Revertir la transacción en caso de error

                        return response()->json([
                            'code' => 404,
                            'msg' => 'error',
                            'message' => 'Personal no encontrado'
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

    public function actEditar(Request $r)
    {
        if ($r->ajax()) {

            $personal = Personal::find($r->id_personal);
            $asigPersonal = OficinaPersonal::where('id_personal', $personal->id_personal)
                                            ->orderBy('created_at', 'desc') // Ordenamos por la última actualización
                                            ->first(); // Tomamos solo el último registro
            $regimenesLaborales = Regimen_Laboral::all(); 
            
            $anioActual = Carbon::now()->year;
            // Obtener todas las oficinas del año actual que no tienen padre, ordenadas alfabéticamente
            $oficinas = Oficina::with('subOficinas')
                ->whereNull('id_oficina_padre')
                ->where('anio', $anioActual)  // Filtrar por el año actual
                ->orderBy('nombre', 'asc')
                ->get();

            $oficinasOrdenadas = $this->ordenarOficinas($oficinas);

            // Verifica si se encontró el personal
            if ($personal) {
                return response()->json([
                    'code' => 200,
                    'msg' => 'success',
                    'message' => 'Usuario Encontrado!',
                    'personal' => $personal,
                    'asigPersonal' => $asigPersonal,
                    'regimenesLaborales' => $regimenesLaborales,  // Envío de los regímenes laborales
                    'oficinas' => $oficinasOrdenadas  // Envío de las oficinas
                ], 200);
            } else {
                return response()->json([
                    'code' => 404,
                    'msg' => 'error',
                    'message' => 'Personal no encontrado'
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
            //$personal = Personal::find($r->id_personal);
            $personal = Personal::with('regimenLaboral')->find($r->id_personal);

            if ($personal) {
                
                // Formatear la fecha para mostrar solo la fecha (sin tiempo)
                $personal->created_at = Carbon::parse($personal->created_at)->format('Y-m-d');
                $personal->rlaboral_nombre = $personal->regimenLaboral ? $personal->regimenLaboral->nombre : 'Régimen Laboral no disponible';
                
                return response()->json([
                    'code' => 200,
                    'msg' => 'success',
                    'message' => 'Personal encontrado correctamente!',
                    'personal' => $personal,
                ], 200);
            } else {
                return response()->json([
                    'code' => 404,
                    'msg' => 'error',
                    'message' => 'Personal no encontrado'
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

    public function actEliminar(Request $r)
    {
        if ($r->ajax()) {

            $personal = Personal::find($r->id_personal);

            if ($personal) {

                $personal->delete();

                return response()->json([
                    'code' => 200,
                    'msg' => 'success',
                    'message' => 'Personal eliminado correctamente.!',
                    'personal$personal'  => $personal
                ], 200);
            }
        } else {
            return response()->json([
                'code' => 404,
                'msg' => 'error',
                'message' => 'Ocurrió un problema, por favor comuníquese con el administrador'
            ], 404);
        }
    }

    public function actListarAsignacion(Request $r)
    {

        if ($r->ajax()) {

            //$ofiPersonals = OficinaPersonal::all();
            //$ofiPersonals = OficinaPersonal::with(['personal', 'oficina'])->get();
            $ofiPersonals = OficinaPersonal::with(['personal', 'oficina'])
                ->where('id_personal', $r->id_personal) // Filtrar por ID de personal
                ->get();

            $html = view('admin.personal.tablaAsig', compact('ofiPersonals'))->render();

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

}
