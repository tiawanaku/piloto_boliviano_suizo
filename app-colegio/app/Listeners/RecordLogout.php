<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Enums\AuditEventType;
use App\Services\AuditLogger;
use Illuminate\Auth\Events\Logout;

/**
 * HU-013: registra cada cierre de sesión (descubierto automáticamente).
 */
class RecordLogout
{
    public function __construct(private readonly AuditLogger $audit) {}

    public function handle(Logout $event): void
    {
        $email = $event->user->getAttribute('email');

        $this->audit->record(
            AuditEventType::Logout,
            actor: $event->user,
            email: is_string($email) ? $email : null,
            context: ['guard' => $event->guard],
        );
    }
}
