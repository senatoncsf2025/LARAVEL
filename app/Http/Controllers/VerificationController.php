<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class VerificationController extends Controller
{
    /**
     * Mostrar aviso para verificar el correo
     */
    public function notice()
    {
        return view('auth.verify-email');
    }

    /**
     * Verificar el correo al hacer clic en el link del email
     */
    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill(); // Marca el email como verificado

        return redirect()->route('dashboard')->with('success', 'Correo verificado correctamente.');
    }

    /**
     * Reenviar el correo de verificación
     */
    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('dashboard');
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('success', 'Se envió un nuevo correo de verificación.');
    }
}
