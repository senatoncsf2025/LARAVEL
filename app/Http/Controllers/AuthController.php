<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Models\User;
use App\Models\PendingUser;
use App\Mail\ConfirmarRegistroMail;

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

            if (is_null($user->email_verified_at)) {
                Auth::logout();
                return redirect()->route('verification.notice')
                    ->with('error', 'Debes verificar tu correo antes de acceder al sistema.');
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
            'email'    => 'required|email|unique:pending_users,email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'rol'      => 'required|in:1,2',

            'cedula'   => 'required|string|max:20|unique:pending_users,cedula|unique:users,cedula',
            'telefono' => 'required|string|max:20',
            'direccion' => 'required|string|max:255',
            'genero'   => 'required|in:Masculino,Femenino,Otro',
            'fecha_nacimiento' => 'required|date',

            'codigo_vigilante' => 'nullable|required_if:rol,2|string|max:50',
            'cargo'            => 'nullable|required_if:rol,2|string|max:50',
        ]);

        $token = Str::random(64);

        // Guardar en pending_users
        $pending = PendingUser::create([
            'nombre'   => $request->nombre,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'rol'      => $request->rol,
            'cedula'   => $request->cedula,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'genero'   => $request->genero,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'codigo_vigilante' => $request->codigo_vigilante,
            'cargo'    => $request->cargo,
            'token'    => $token,
        ]);

        // Generar link de verificación
        $link = url("/confirmar-registro/{$token}");

        // Enviar correo con Mailable
        Mail::to($pending->email)->send(new ConfirmarRegistroMail($pending->nombre, $link));

        return back()->with('success', 'Se envió un correo de confirmación a ' . $request->email);
    }

    public function confirmarRegistro($token)
    {
        $pending = PendingUser::where('token', $token)->first();

        if (!$pending) {
            return redirect()->route('login')->with('error', 'Token inválido o expirado.');
        }

        // Crear usuario real en tabla users
        User::create([
            'name'     => $pending->nombre,
            'email'    => $pending->email,
            'password' => $pending->password,
            'rol'      => $pending->rol,
            'cedula'   => $pending->cedula,
            'telefono' => $pending->telefono,
            'direccion' => $pending->direccion,
            'genero'   => $pending->genero,
            'fecha_nacimiento' => $pending->fecha_nacimiento,
            'codigo_vigilante' => $pending->codigo_vigilante,
            'cargo'    => $pending->cargo,
            'activo'   => true,
            'email_verified_at' => now(),
        ]);

        // Eliminar de la tabla temporal
        $pending->delete();

        return redirect()->route('login')->with('success', 'Correo verificado. Ya puedes iniciar sesión.');
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
