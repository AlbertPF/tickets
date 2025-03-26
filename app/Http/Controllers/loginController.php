<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class loginController extends Controller
{
    public function actionLogin()
    {
        if (Session::has('usuario'))
            return redirect('homeAdmin');
        else
            return view('auth.login');
    }

    public function sigin(Request $request)
    {
        if ($request->ajax()) {
            $usuario = Usuario::where('usuario', $request->usuario)->first();
            //dd($usuario);
            // validacion de usuario para ver siexiste
            if ($usuario == null) {  //return response()->json(['estado' => false, 'message' => 'El usuario no se encuentra registrado.']);
                return response()->json([
                    'code' => 404,
                    'msg' => 'error',
                    'message' => 'El usuario no se encuentra registrado.'
                ], 404);
            }

            // validacion de usuario para ver si la contraseña es la correcta
            if (!Hash::check($request->password, $usuario->password)) {   //return response()->json(['estado' => false, 'message' => 'La contraseña es incorrecta.']);
                return response()->json([
                    'code' => 404,
                    'msg' => 'error',
                    'message' => 'La contraseña es incorrecta..'
                ], 404);
            }
            // guardado en sesion el usuario logueado
            session(['usuario' => $usuario]);
            //session(['id_usuario' => $usuario->id_suario]);

            // Definir la ruta de redirección según el tipo de usuario
            $redirectUrl = ($usuario->tipo === 'Personal') ? route('index.actividades') : url('homeAdmin');
            
            return response()->json([
                'code' => 200,
                'msg' => 'success',
                'message' => 'Inicio de sesión exitoso!',
                'redirect' => $redirectUrl,
                //'usuario' => $usuario
            ], 200);
        } else {
            return response()->json([
                'code' => 404,
                'msg' => 'error',
                'message' => 'Error, no se puede acceder a la página'
            ], 404);
        }
    }

    public function logout(Request $request)
    {
        /*$this->historial($request);
    	session()->flush();
    	return redirect('login/login');*/

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route('login'));
    }
}
