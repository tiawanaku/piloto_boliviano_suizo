<?php

declare(strict_types=1);

namespace App\Enums;

use App\Models\AuditEvent;

/**
 * Tipos de evento de la bitácora de auditoría (HU-013, HU-014).
 *
 * Valores con estilo "recurso.accion"; se guardan tal cual en audit_events.event_type.
 */
enum AuditEventType: string
{
    case LoginSucceeded = 'login.succeeded';
    case LoginFailed = 'login.failed';
    case Logout = 'logout';
    case AccessDenied = 'access.denied';
    case AuditExported = 'audit.exported';
    case PasswordChanged = 'password.changed';

    /**
     * Etiqueta en español. El punto del valor se cambia por "_" en la clave de
     * traducción: __() interpreta los puntos como anidación.
     */
    public function label(): string
    {
        return __('audit.event_type.'.$this->translationKey());
    }

    public function translationKey(): string
    {
        return str_replace('.', '_', $this->value);
    }

    /**
     * Resultado por defecto cuando quien registra no indica uno.
     */
    public function defaultResult(): string
    {
        return match ($this) {
            self::LoginFailed => AuditEvent::RESULT_FAILURE,
            self::AccessDenied => AuditEvent::RESULT_DENIED,
            default => AuditEvent::RESULT_SUCCESS,
        };
    }
}
