<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\AuditEventType;
use App\Models\AuditEvent;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Único punto de escritura de la bitácora de auditoría (ADR-005 §6, HU-013).
 *
 * Toma IP y navegador de la solicitud actual y elimina del contexto cualquier
 * clave sensible (contraseñas, tokens, secretos, códigos MFA…), a cualquier
 * profundidad. Nunca recibe ni guarda contraseñas.
 */
class AuditLogger
{
    /**
     * Fragmentos que, si aparecen en el nombre de una clave del contexto, la excluyen.
     */
    private const SENSITIVE_FRAGMENTS = [
        'password',
        'passwd',
        'token',
        'secret',
        'otp',
        'recovery',
        'credential',
        'api_key',
        'apikey',
        'authorization',
        'cookie',
    ];

    private const MAX_USER_AGENT = 512;

    private const MAX_EMAIL = 255;

    /**
     * Registra un evento de auditoría.
     *
     * @param  Authenticatable|null  $actor  Quien realiza la acción (null si es anónimo).
     * @param  Model|null  $subject  Registro sobre el que se actúa (p. ej. la cuenta de un login fallido).
     * @param  string|null  $email  Correo intentado o del actor.
     * @param  string|null  $result  AuditEvent::RESULT_*; por defecto, el del tipo de evento.
     * @param  array<array-key, mixed>  $context  Datos adicionales; las claves sensibles se eliminan.
     */
    public function record(
        AuditEventType $type,
        ?Authenticatable $actor = null,
        ?Model $subject = null,
        ?string $email = null,
        ?string $result = null,
        array $context = [],
    ): AuditEvent {
        $actorId = $actor?->getAuthIdentifier();
        $subjectKey = $subject?->getKey();
        $request = request();
        $userAgent = $request->userAgent();

        return AuditEvent::query()->create([
            'occurred_at' => now(),
            'event_type' => $type,
            'actor_id' => is_scalar($actorId) ? (string) $actorId : null,
            'subject_type' => $subject?->getMorphClass(),
            'subject_id' => is_scalar($subjectKey) ? (string) $subjectKey : null,
            'email_attempted' => $email === null ? null : Str::limit(Str::lower(trim($email)), self::MAX_EMAIL, ''),
            'result' => $result ?? $type->defaultResult(),
            'ip_address' => $request->ip(),
            'user_agent' => $userAgent === null ? null : Str::limit($userAgent, self::MAX_USER_AGENT, ''),
            'context' => ($clean = $this->sanitize($context)) === [] ? null : $clean,
        ]);
    }

    /**
     * Elimina recursivamente las claves sensibles del contexto.
     *
     * @param  array<array-key, mixed>  $context
     * @return array<array-key, mixed>
     */
    public function sanitize(array $context): array
    {
        $clean = [];

        foreach ($context as $key => $value) {
            if (is_string($key) && $this->isSensitiveKey($key)) {
                continue;
            }

            $clean[$key] = is_array($value) ? $this->sanitize($value) : $value;
        }

        return $clean;
    }

    public function isSensitiveKey(string $key): bool
    {
        // camelCase → snake_case; guiones y espacios → "_"; todo en minúsculas.
        $normalized = Str::lower(str_replace(['-', ' '], '_', (string) preg_replace('/(?<=[a-z0-9])(?=[A-Z])/', '_', $key)));

        if ($normalized === 'code' || str_ends_with($normalized, '_code') || str_ends_with($normalized, '_codes')) {
            return true;
        }

        return Str::contains($normalized, self::SENSITIVE_FRAGMENTS);
    }
}
