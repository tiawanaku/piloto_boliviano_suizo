<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Enums\AuditEventType;
use App\Services\AuditLogger;
use Illuminate\Auth\Events\Failed;
use Illuminate\Database\Eloquent\Model;

/**
 * HU-013: registra cada intento de inicio de sesión fallido (descubierto automáticamente).
 *
 * De las credenciales solo se toma el correo: la contraseña nunca se registra.
 */
class RecordFailedLogin
{
    public function __construct(private readonly AuditLogger $audit) {}

    public function handle(Failed $event): void
    {
        $email = $event->credentials['email'] ?? null;

        $this->audit->record(
            AuditEventType::LoginFailed,
            subject: $event->user instanceof Model ? $event->user : null,
            email: is_string($email) ? $email : null,
            context: ['guard' => $event->guard],
        );
    }
}
