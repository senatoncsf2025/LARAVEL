<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as BaseVerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;

class CustomVerifyEmail extends BaseVerifyEmail
{
    /**
     * Genera la URL de verificación personalizada usando NGROK_URL
     */
    protected function verificationUrl($notifiable)
    {
        // Generar URL temporal firmada (por defecto será con APP_URL = localhost)
        $temporarySignedUrl = URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(60),
            [
                'id'   => $notifiable->getKey(),
                'hash' => sha1($notifiable->email),
            ]
        );

        // 👇 Forzar NGROK solo en correos
        return str_replace(config('app.url'), env('NGROK_URL', config('app.url')), $temporarySignedUrl);
    }

    /**
     * Personalizar el correo con un botón bonito
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Verifica tu correo electrónico')
            ->greeting('¡Hola ' . $notifiable->name . '!')
            ->line('Gracias por registrarte en la Plataforma Siorti.')
            ->line('Por favor haz clic en el siguiente botón para verificar tu correo:')
            ->action('Confirmar correo', $this->verificationUrl($notifiable))
            ->line('Si no creaste esta cuenta, ignora este mensaje.');
    }
}
