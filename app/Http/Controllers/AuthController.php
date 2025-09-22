<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\User;

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
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            if (isset($user->activo) && !$user->activo) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Tu cuenta está inactiva. Contacta al administrador.',
                ]);
            }

            if ($user->rol == 1) {
                return redirect()->route('index2')->with('success', 'Bienvenido Administrador.');
            }
            if ($user->rol == 2) {
                return redirect()->route('index2')->with('success', 'Bienvenido Vigilante.');
            }

            Auth::logout();
            return redirect()->route('login')->withErrors([
                'email' => 'Acceso denegado. Solo administradores o vigilantes pueden iniciar sesión.',
            ]);
        }

        return back()->withErrors([
            'email' => 'Correo o contraseña incorrectos.',
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

        return redirect()->route('login')->with('success', 'Sesión cerrada correctamente.');
    }

    // ========================================================
    // REGISTRO DE ADMIN / VIGILANTES
    // ========================================================

    public function showRegistroAdminForm()
    {
        return view('auth.registro_admin');
    }

    public function registroAdmin(Request $request)
    {
        $request->validate([
            'nombre'   => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'rol'      => 'required|in:1,2', // 1=Admin, 2=Vigilante
        ]);

        User::create([
            'name'     => $request->nombre,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'rol'      => $request->rol,
            'activo'   => true,
        ]);

        return redirect()->route('login')->with('success', 'Usuario registrado correctamente.');
    }

    // ========================================================
    // RECUPERACIÓN DE CONTRASEÑA VÍA SMS (OTP)
    // ========================================================

    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetCode(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $usuario = User::where('email', $request->email)->first();
        if (!$usuario) {
            return back()->withErrors(['email' => 'No encontramos una cuenta con ese correo.']);
        }

        if (empty($usuario->telefono)) {
            return back()->withErrors(['email' => 'El usuario no tiene un número de teléfono registrado.']);
        }

        $code = rand(100000, 999999);

        DB::table('password_resets')->updateOrInsert(
            ['email' => $usuario->email],
            ['token' => $code, 'created_at' => Carbon::now()]
        );

        session(['email' => $usuario->email]);

        return redirect()->route('password.verify')
            ->with('success', 'Se envió un código de verificación a tu teléfono.');
    }

    public function showVerifyCodeForm()
    {
        return view('auth.verify-code');
    }

    public function verifyCode(Request $request)
    {
        $request->validate(['code' => 'required|numeric']);

        $record = DB::table('password_resets')
            ->where('email', session('email'))
            ->where('token', $request->code)
            ->first();

        if (!$record) {
            return back()->withErrors(['code' => 'Código inválido o expirado.']);
        }

        if (Carbon::parse($record->created_at)->addMinutes(10)->isPast()) {
            return back()->withErrors(['code' => 'El código ha expirado.']);
        }

        return view('auth.reset-password', ['email' => session('email')]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $usuario = User::where('email', $request->email)->first();
        if (!$usuario) {
            return back()->withErrors(['email' => 'Usuario no encontrado.']);
        }

        $usuario->password = Hash::make($request->password);
        $usuario->save();

        DB::table('password_resets')->where('email', $usuario->email)->delete();

        return redirect()->route('login')->with('success', 'Tu contraseña ha sido restablecida.');
    }
}
