<?php

declare(strict_types=1);

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Correo de prueba para verificar el envío y la cola (T-0-10).
 * Solo se envía a direcciones ficticias del dominio del piloto.
 */
class TestMailNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @return list<string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject(__('mail.test.subject'))
            ->greeting(__('mail.greeting'))
            ->line(__('mail.test.line'))
            ->salutation(__('mail.salutation')."\n\n".config('app.name'));
    }
}
