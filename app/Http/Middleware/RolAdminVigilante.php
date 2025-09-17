<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class RolAdminVigilante
{
    /**
     * Maneja una solicitud entrante.
     *
     * Solo permite el acceso si el usuario autenticado tiene
     * rol 1 (Administrador) o 4 (Vigilante).
     */
    public function handle(Request $request, Closure $next)
    {
        // Recupera el usuario desde la sesión
        $user = User::find(session('user_id'));

        // Verifica que exista y tenga rol válido
        if (!$user || !in_array($user->rol, [1, 4])) {
            return redirect()
                ->route('login')
                ->withErrors(['email' => 'Acceso no autorizado.']);
        }

        return $next($request);
    }
}
