<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class AuthController extends Controller
{
    // Mostrar formulario de login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Login
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Session::put('user_id', $user->id);

            switch ($user->rol) {
                case 1: // Administrador
                case 4: // Vigilante
                    return redirect()->route('index2')
                        ->with('success', 'Bienvenido al panel principal.');

                case 2: // Invitado
                    return redirect()->route('registro_pertenecias_invitado')
                        ->with('info', 'Por favor regístrate para continuar.');

                default:
                    return redirect()->route('login')
                        ->withErrors(['email' => 'Rol no reconocido, contacta al administrador.']);
            }
        }

        return back()->withErrors(['email' => 'Correo o contraseña incorrectos'])
                     ->withInput();
    }

    // Logout
    public function logout()
    {
        Session::forget('user_id');
        return redirect()->route('login');
    }

    // Mostrar formulario de registro
    public function showRegisterForm()
    {
        return view('auth.registro');
    }

    // Registro
    public function register(Request $request)
    {
        $request->validate([
            'name'             => 'required|regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/',
            'email'            => 'required|email|unique:users,email',
            'telefono'         => 'nullable|digits:10',
            'cedula'           => 'nullable|numeric',
            'direccion'        => 'nullable|string',
            'codigo_vigilante' => 'nullable|numeric',
            'rol'              => 'required|integer|between:1,4',
            'password'         => 'required|min:6|confirmed',
        ]);

        User::create([
            'name'             => $request->name,
            'email'            => $request->email,
            'telefono'         => $request->telefono,
            'cedula'           => $request->cedula,
            'direccion'        => $request->direccion,
            'codigo_vigilante' => $request->codigo_vigilante,
            'rol'              => $request->rol,
            'password'         => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Usuario registrado correctamente. Inicia sesión.');
    }
}
