<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class AuthController extends Controller
{
    // -------------------------------
    // LOGIN
    // -------------------------------
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validaciones
        $request->validate([
            'correo' => 'required|email',
            'contrasena' => 'required',
        ]);

        // Buscar usuario por correo
        $user = User::where('correo', $request->correo)->first();

        // Verificar contraseña
        if ($user && Hash::check($request->contrasena, $user->contrasena_hash)) {
            // Guardar ID de usuario en sesión
            Session::put('usuario_id', $user->ID_USUARIO);

            return redirect()->route('home')->with('success', 'Inicio de sesión exitoso.');
        }

        // Si falla login
        return back()->withErrors(['correo' => 'Correo o contraseña incorrectos'])->withInput();
    }

    // -------------------------------
    // LOGOUT
    // -------------------------------
    public function logout()
    {
        Session::forget('usuario_id');
        return redirect()->route('login');
    }

    // -------------------------------
    // REGISTRO
    // -------------------------------
    public function showRegisterForm()
    {
        return view('auth.registro');
    }

    public function register(Request $request)
    {
        // Validaciones
        $request->validate([
            'nombre' => 'required|regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/',
            'correo' => 'required|email|unique:usuario,correo',
            'telefono' => 'nullable|digits:10', // 10 dígitos numéricos
            'cedula' => 'required|numeric',
            'direccion' => 'nullable|string',
            'codigo_vigilante' => 'nullable|numeric',
            'contrasena' => 'required|min:6|confirmed', // Verifica campo contrasena_confirmation
            'rol' => 'required|integer|between:1,4',
        ]);

        // Crear usuario
        User::create([
            'nombre_usuario' => $request->nombre,
            'correo' => $request->correo,
            'telefono' => $request->telefono,
            'cedula' => $request->cedula,
            'direccion' => $request->direccion,
            'codigo_vigilante' => $request->codigo_vigilante,
            'contrasena_hash' => Hash::make($request->contrasena),
            'fk_id_rol' => $request->rol,
        ]);

        return redirect()->route('login')->with('success', 'Usuario registrado correctamente. Inicia sesión.');
    }
}
