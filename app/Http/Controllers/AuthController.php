<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Vehiculo;
use App\Models\Pc;
use App\Models\Visita;

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
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            switch ($user->rol) {
                case 1: // Administrador
                    return redirect()->route('index_admin')->with('success', 'Bienvenido Administrador.');
                case 2: // Vigilante
                    return redirect()->route('index_vigilante')->with('success', 'Bienvenido Vigilante.');
                case 3.1: // Estudiantes
                case 3.2: // Docentes
                    return redirect()->route('index_personal')->with('success', 'Bienvenido Personal.');
                case 4.1: // Oficinas
                case 4.2: // Vigilantes de oficinas
                case 4.3: // Enfermería
                    return redirect()->route('index_oficinas')->with('success', 'Bienvenido al módulo de Oficinas.');
                case 5.1: // Parqueadero
                case 5.2: // Visitantes
                case 5.3: // Acudientes
                    return redirect()->route('index_servicios')->with('success', 'Bienvenido al módulo de Servicios.');
                default:
                    Auth::logout();
                    return redirect()->route('login')
                        ->withErrors(['email' => 'Rol no reconocido, contacta al administrador.']);
            }
        }

        return back()->withErrors([
            'email' => 'Correo o contraseña incorrectos',
        ])->withInput();
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    // Mostrar formulario de registro
    public function showRegisterForm()
    {
        return view('auth.registro');
    }

    // Registro (parqueadero / servicios)
    public function register(Request $request)
    {
        $request->validate([
            'name'          => 'required|regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/',
            'email'         => 'required|email|unique:users,email',
            'telefono'      => 'nullable|digits:10',
            'cedula'        => 'nullable|numeric',
            'direccion'     => 'nullable|string',
            'rol'           => 'required|in:5.1,5.2,5.3', // subroles de Servicios
            'trae_vehiculo' => 'nullable|boolean',
            'placa'         => 'required_if:trae_vehiculo,1|string|max:10',
            'marca'         => 'required_if:trae_vehiculo,1|string|max:50',
            'modelo'        => 'required_if:trae_vehiculo,1|string|max:50',
            'color'         => 'required_if:trae_vehiculo,1|string|max:30',
            'trae_pc'       => 'nullable|boolean',
            'serial_pc'     => 'required_if:trae_pc,1|string|size:4',
            'dias'          => 'required|array',
            'horario'       => 'required|string',
        ]);

        // Crear usuario sin contraseña
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'telefono' => $request->telefono,
            'cedula'   => $request->cedula,
            'rol'      => $request->rol,
            'password' => null,
        ]);

        // Guardar vehículo si aplica
        if ($request->trae_vehiculo) {
            Vehiculo::create([
                'user_id' => $user->id,
                'placa'   => $request->placa,
                'marca'   => $request->marca,
                'modelo'  => $request->modelo,
                'color'   => $request->color,
            ]);
        }

        // Guardar PC si aplica
        if ($request->trae_pc) {
            Pc::create([
                'user_id' => $user->id,
                'serial'  => $request->serial_pc,
            ]);
        }

        // Guardar días y horario de visita
        foreach ($request->dias as $dia) {
            Visita::create([
                'user_id' => $user->id,
                'fecha'   => $dia,
                'horario' => $request->horario,
            ]);
        }

        // Redirigir con mensaje de éxito
        return redirect()->back()->with('success', 'Registro de visita completado correctamente.');
    }
}
