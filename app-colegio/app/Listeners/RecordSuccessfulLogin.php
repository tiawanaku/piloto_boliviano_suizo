<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Enums\AuditEventType;
use App\Services\AuditLogger;
use Illuminate\Auth\Events\Login;

/**
 * HU-013: registra cada inicio de sesión correcto (descubierto automáticamente).
 */
class RecordSuccessfulLogin
{
    public function __construct(private readonly AuditLogger $audit) {}

    public function handle(Login $event): void
    {
        $email = $event->user->getAttribute('email');

        $this->audit->record(
            AuditEventType::LoginSucceeded,
            actor: $event->user,
            email: is_string($email) ? $email : null,
            context: ['guard' => $event->guard, 'remember' => $event->remember],
        );
    }
}
