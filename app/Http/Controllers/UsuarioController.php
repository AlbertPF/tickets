<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UsuarioController extends Controller
{
    
    public function index()
    {
        return view('admin.usuarios_Informatica.index');
    }

    public function verPerfil()
    {
        return view('admin.usuarios_Informatica.perfil');
    }

    public function actListar(Request $r)
    {

        if ($r->ajax()) {

            $usuarios = Usuario::all();
            //dd($usuarios);

            $html = view('admin.usuarios_Informatica.table', compact('usuarios'))->render();


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

    public function actRegistrar(Request $r)
    {
        if ($r->ajax()) {

            //dd($r->all());
            $tipo_form = $r->tipo_formulario;

            $rules = [
                'dni' => 'required|digits:8|unique:usuarios,dni,' . ($r->id_usuario_editar ?? 'null') . ',id_usuario',
                'usuario' => 'required|min:5|unique:usuarios,usuario,' . ($r->id_usuario_editar ?? 'null') . ',id_usuario',
                'telefono' => 'required|digits:9|unique:usuarios,telefono,' . ($r->id_usuario_editar ?? 'null') . ',id_usuario',
            ];

            $messages = [
                'dni.unique' => 'El DNI ya está registrado.',
                'usuario.unique' => 'El nombre de usuario ya está en uso.',
                'telefono.unique' => 'El número telefónico ya está en uso.',
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

                $usuario = Usuario::create([
                    'dni' => $r->dni,
                    'nombre' => $r->nombre,
                    'apellidoPaterno' => $r->apellidoPaterno,
                    'apellidoMaterno' => $r->apellidoMaterno,
                    'usuario' => $r->usuario,
                    'password' => Hash::make($r->password),
                    'tipo' => $r->tipo,
                    'telefono' => $r->telefono
                ]);

                if ($usuario) {
                    return response()->json([
                        'code' => 200,
                        'msg' => 'success',
                        'message' => 'Usuario registrado exitosamente!'
                    ], 200);
                } else {
                    return response()->json([
                        'code' => 404,
                        'msg' => 'error',
                        'message' => 'Error, no se puedo registrar'
                    ], 404);
                }
            } else { //editar

                $id_usuario = $r->id_usuario_editar;

                $usuario = DB::table('usuarios')->where('id_usuario', $id_usuario)->first();

                if ($usuario) {
                    $updateData = [
                        'dni' => $r->dni,
                        'nombre' => $r->nombre,
                        'apellidoPaterno' => $r->apellidoPaterno,
                        'apellidoMaterno' => $r->apellidoMaterno,
                        'usuario' => $r->usuario,
                        'tipo' => $r->tipo,
                        'telefono' => $r->telefono
                    ];

                    // Actualizar la contraseña solo si se proporciona una nueva
                    if (!empty($r->password)) {
                        $updateData['password'] = Hash::make($r->password);
                    }

                    DB::table('usuarios')
                        ->where('id_usuario', '=', $id_usuario)
                        ->update($updateData);

                    return response()->json([
                        'code' => 200,
                        'msg' => 'success',
                        'message' => 'Usuario actualizado correctamente!'
                    ], 200);
                } else {
                    return response()->json([
                        'code' => 404,
                        'msg' => 'error',
                        'message' => 'Usuario no encontrado'
                    ], 404);
                }
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
            //dd($r->all());

            $usuario = Usuario::find($r->id_usuario);

            //dd($usuario);

            return response()->json([
                'code' => 200,
                'msg' => 'success',
                'message' => 'Usuario Encontrado!',
                'usuario'  => $usuario
            ], 200);
        } else {
            return response()->json([
                'code' => 404,
                'msg' => 'error',
                'message' => 'Error, no se puede acceder a la página'
            ], 404);
        }
    }


    public function actEliminar(Request $r)
    {
        if ($r->ajax()) {

            $usuario = Usuario::find($r->id_usuario);

            if ($usuario) {

                $usuario->delete();

                return response()->json([
                    'code' => 200,
                    'msg' => 'success',
                    'message' => 'Usuario eliminado correctamente.!',
                    'usuario'  => $usuario
                ], 200);
            }
        } else {
            return response()->json([
                'code' => 404,
                'msg' => 'error',
                'message' => 'Error, no se puede acceder a la página'
            ], 404);
        }
    }

    public function actVer(string $id)
    {
        $usuario = Usuario::find($id);

        if (!$usuario) {
            return abort(404);
        }


        $ticketsAsignados = DB::table('asignacion_ticket')
            ->where('id_usuario', $usuario->id_usuario)
            ->count();

        $totalTickets = DB::table('tickets')->count();

        $porcentajeAsignados = ($totalTickets > 0) ? ($ticketsAsignados / $totalTickets) * 100 : 0;

        $ticketsAtendidos = DB::table('asignacion_ticket')
            ->where('id_usuario', $usuario->id_usuario)
            ->where('estado', 3)
            ->count();

        $ticketsNoResueltos = DB::table('asignacion_ticket')
            ->where('id_usuario', $usuario->id_usuario)
            ->where('estado', 4)
            ->count();

        // Pasar los datos a la vista
        return view('admin.usuarios_Informatica.ver', compact(
            'usuario', 
            'ticketsAsignados', 
            'porcentajeAsignados', 
            'ticketsAtendidos', 
            'ticketsNoResueltos'
        ));
    }

    public function actPerfil(Request $r)
    {
        if ($r->ajax()) {

            $usuario = Usuario::find($r->id_usuario);

            if ($usuario) {

                return response()->json([
                    'code' => 200,
                    'msg' => 'success',
                    'message' => 'Usuario Encontrado!',
                    'usuario'  => $usuario
                ], 200);
            }
        } else {
            return response()->json([
                'code' => 404,
                'msg' => 'error',
                'message' => 'Error, no se puede acceder a la página'
            ], 404);
        }
    }

    public function actGuardarContraseña(Request $r)
    {
        if ($r->ajax()) {

            // Validar las contraseñas

            $rules = [
               'password' => 'required|string|min:8|confirmed',
            ];

            $messages = [
                'password.required' => 'La contraseña es obligatoria.',
                'usuario.minlength' => 'La contraseña debe tener al menos 8 caracteres.',
            ];

            $validator = Validator::make($r->all(), $rules, $messages);

            if ($validator->fails()) {
                return response()->json([
                    'code' => 400,
                    'msg' => 'error',
                    'message' => $validator->errors()->first(),
                ], 400);
            }

            // Obtener el usuario de la sesión
            $usuario = Session::get('usuario');
            $usuario = Usuario::find($usuario->id_usuario);

            // Actualizar la contraseña
            $usuario->password = Hash::make($r->password);

            if ($usuario->save()) {
                return response()->json([
                    'code' => 200,
                    'msg' => 'success',
                    'message' => 'Contraseña actualizada correctamente!',
                ], 200);
            }

            return response()->json([
                'code' => 500,
                'msg' => 'error',
                'message' => 'Error al actualizar la contraseña.',
            ], 500);
        } else {
            return response()->json([
                'code' => 404,
                'msg' => 'error',
                'message' => 'Error, no se puede actualizar la contraseña.',
            ], 404);
        }
    }

}
