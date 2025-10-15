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
        if (Auth::check())
            return redirect('homeAdmin');
        else
            return view('auth.login');
    }

    public function sigin(Request $request)
    {
        if ($request->ajax()) {
            $usuario = Usuario::where('usuario', $request->usuario)->first();
            
            if ($usuario == null) { 
                return response()->json([
                    'code' => 404,
                    'msg' => 'error',
                    'message' => 'El usuario no se encuentra registrado.'
                ], 404);
            }

            
            if (!Hash::check($request->password, $usuario->password)) {  
                return response()->json([
                    'code' => 404,
                    'msg' => 'error',
                    'message' => 'La contraseña es incorrecta..'
                ], 404);
            }

            //session(['usuario' => $usuario]);
            Auth::login($usuario);
            //session(['id_usuario' => $usuario->id_suario]);

            $intendedUrl = Session::pull('url.intended');

            // Si no hay url.intended, usar la redirección por tipo de usuario
            if (!$intendedUrl) {
                $intendedUrl = ($usuario->tipo === 'Personal') ? route('index.actividades') : url('homeAdmin');
            }
            
            return response()->json([
                'code' => 200,
                'msg' => 'success',
                'message' => 'Inicio de sesión exitoso!',
                'redirect' => $intendedUrl,
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
