<?php

namespace App\Http\Controllers;

use App\Models\Oficina;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OficinaController extends Controller
{
    public function index()
    {
        return view('admin.oficinas.index');
    }

    public function actListar(Request $r)
    {

        if ($r->ajax()) {

            $oficinas = Oficina::all();

            $html = view('admin.oficinas.tabla', compact('oficinas'))->render();

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

            $tipo_form = $r->tipo_formulario;

            if ($tipo_form == 1) { //agregar

                $r->validate([
                    'nombre' => 'required|string',
                    // 'descripcion' => 'required|string',
                    'anio' => 'required|digits:4|integer|min:2015|max:' . (date('Y') + 1),
                ], [
                    'nombre.required' => 'El campo nombre es obligatorio.',
                    // 'descripcion.required' => 'El campo descripción es obligatorio.',
                    'anio.required' => 'El campo año es obligatorio.',
                    'anio.digits' => 'El campo año debe tener 4 dígitos.',
                    'anio.integer' => 'El campo año debe ser un número entero.',
                    'anio.min' => 'El campo año debe ser mayor o igual a 2015.',
                    'anio.max' => 'El campo año no puede ser mayor al próximo año.'
                ]);

                $oficina = Oficina::create([
                    'nombre' => $r->nombre,
                    'descripcion' => $r->descripcion,
                    'anio' => $r->anio,
                    'id_oficina_padre' => $r->id_oficina_padre == 0 ? null : $r->id_oficina_padre
                ]);


                if ($oficina) {
                    return response()->json([
                        'code' => 200,
                        'msg' => 'success',
                        'message' => 'La oficina fue registrado exitosamente!'
                    ], 200);
                } else {
                    DB::rollBack();
                    return response()->json([
                        'code' => 404,
                        'msg' => 'error',
                        'message' => 'Error, no se puedo registrar'
                    ], 404);
                }
            } else { //editar

                $r->validate([
                    'nombre' => 'required|string',
                    'descripcion' => 'required|string',
                    'anio' => 'required|digits:4|integer|min:2015|max:' . (date('Y') + 1),
                    'codigo' => 'required',
                ], [
                    'nombre.required' => 'El campo nombre es obligatorio.',
                    'descripcion.required' => 'El campo descripción es obligatorio.',
                    'anio.required' => 'El campo año es obligatorio.',
                    'anio.digits' => 'El campo año debe tener 4 dígitos.',
                    'anio.integer' => 'El campo año debe ser un número entero.',
                    'anio.min' => 'El campo año debe ser mayor o igual a 1900.',
                    'anio.max' => 'El campo año no puede ser mayor al próximo año.',
                    'codigo.required' => 'El código de la oficina es obligatorio',
                ]);

                $id_oficina = $r->id_oficina_editar;


                // Obtener la categoría original
                $oficina = Oficina::findOrFail($id_oficina);

                // Verificar si el id_oficina_padre cambió
                $idOficinaPadreOriginal = $oficina->id_oficina_padre;
                $idOficinaPadreNuevo = $r->id_oficina_padre == 0 ? null : $r->id_oficina_padre;

                // Inicializar datos a actualizar
                $dataToUpdate = [
                    'nombre' => $r->nombre,
                    'descripcion' => $r->descripcion,
                    'id_oficina_padre' => $idOficinaPadreNuevo,
                    'anio' => $r->anio,
                    'updated_at' => Carbon::now('America/Lima')->format('Y-m-d H:i:s')
                ];

                // Si cambió el id_oficina_padre, genera un nuevo código

                if ($idOficinaPadreOriginal != $idOficinaPadreNuevo) {
                    $oficina->id_oficina_padre = $idOficinaPadreNuevo;
                    $dataToUpdate['codigo'] = $oficina->generateOfficeCode();

                    // Guardar la oficina con el nuevo código
                    DB::table('oficinas')->where('id_oficina', '=', $id_oficina)->update($dataToUpdate);

                    // Actualizar los códigos de las suboficinas recursivamente
                    $oficina->updateSubOfficeCodes($dataToUpdate['codigo']);
                } else {
                    // Solo actualizar los datos básicos si no cambió la oficina padre
                    DB::table('oficinas')->where('id_oficina', '=', $id_oficina)->update($dataToUpdate);
                }

                // Actualizar la categoría
                DB::table('oficinas')
                    ->where('id_oficina', '=', $id_oficina)
                    ->update($dataToUpdate);

                return response()->json([
                    'code' => 200,
                    'msg' => 'success',
                    'message' => 'Oficina actualizada correctamente!'
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
            $oficina = Oficina::find($r->id_oficina);
            $anioActual = Carbon::now()->year;

            $oficinas = Oficina::with(['subOficinas.subsubOficinas'])
                ->whereNull('id_oficina_padre')
                ->where('anio', $anioActual)
                ->orderBy('nombre', 'asc')
                ->get();

            // Llamar a la función de ordenamiento
            $oficinasOrdenadas = $this->ordenarOficinas($oficinas);

            return response()->json([
                'oficina' => $oficina,
                'oficinasOrd' => $oficinasOrdenadas,
            ], 200);
        } else {
            return response()->json([
                'message' => 'Ocurrio un problema, porfavor comunicarse con el administrador'
            ], 404);
        }
    }

    public function actEliminar(Request $r)
    {
        if ($r->ajax()) {

            $oficina = Oficina::find($r->id_oficina);

            if ($oficina) {

                $oficina->delete();

                return response()->json([
                    'code' => 200,
                    'msg' => 'success',
                    'message' => 'Oficina eliminado correctamente.!',
                    'oficina'  => $oficina
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

    public function duplicarOficinas(Request $request)
    {
        
        $nuevoAno = Carbon::now()->year;
        $añoAnterior = Carbon::now()->year - 1;

        if (Oficina::where('anio', $nuevoAno)->exists()) {
            return response()->json([
                'message' => 'Ya se ha realizado la duplicación de oficinas para el año ' . $nuevoAno,
                'duplicated' => true
            ], 400); // Código de error 400 para indicar que ya se duplicó
        }

        //$oficinas = Oficina::all();
        $oficinas = Oficina::where('anio', $añoAnterior)->get();

        // Creamos un arreglo para guardar los nuevos IDs
        $nuevosIds = [];

        foreach ($oficinas as $oficina) {
            // Crear la nueva instancia del modelo
            $nuevaOficina = new Oficina([
                'codigo' => $oficina->codigo,  // Mantén el mismo código
                'nombre' => $oficina->nombre,
                'descripcion' => $oficina->descripcion,
                'id_oficina_padre' => null,  // Inicialmente sin padre
                'anio' => $nuevoAno,
            ]);

            // Marcar la nueva oficina como duplicada (esto evita que se genere un nuevo código)
            $nuevaOficina->isDuplicated = true;

            // Guardar la nueva oficina
            $nuevaOficina->save();

            // Guardamos el nuevo ID en el arreglo
            $nuevosIds[$oficina->id_oficina] = $nuevaOficina->id_oficina;
        }

        // Actualizamos las oficinas duplicadas para asignar el id_padre correcto
        foreach ($oficinas as $oficina) {
            if ($oficina->id_oficina_padre) {
                $nuevaOficina = Oficina::find($nuevosIds[$oficina->id_oficina]);
                $nuevaOficina->id_oficina_padre = $nuevosIds[$oficina->id_oficina_padre];
                $nuevaOficina->save();
            }
        }

        return response()->json(['message' => 'Las oficinas han sido duplicadas con éxito para el año ' . $nuevoAno]);
    }

}
