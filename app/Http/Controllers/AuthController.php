<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Mostrar formulario de login
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Login de usuarios internos (solo admin y vigilantes)
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            // Solo admin (rol=1) o vigilante (rol=2) pueden acceder
            if ($user->rol == 1) {
                return redirect()->route('index2')->with('success', 'Bienvenido Administrador.');
            } elseif ($user->rol == 2) {
                return redirect()->route('index2')->with('success', 'Bienvenido Vigilante.');
            } else {
                // Cualquier otro rol → cerrar sesión inmediatamente
                Auth::logout();
                return redirect()->route('login')
                    ->withErrors(['email' => 'Acceso denegado. Solo administradores o vigilantes pueden iniciar sesión.']);
            }
        }

        // Si las credenciales no son correctas
        return back()->withErrors([
            'email' => 'Correo o contraseña incorrectos',
        ])->withInput();
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
