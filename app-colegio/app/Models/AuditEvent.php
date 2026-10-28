<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\AuditEventType;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use LogicException;

/**
 * Evento de la bitácora de auditoría: solo se inserta, nunca se edita ni se borra.
 *
 * Inmutabilidad en tres capas (ADR-005 §6): este modelo, AuditEventPolicy y
 * el trigger de base de datos. Se crea siempre a través de App\Services\AuditLogger.
 *
 * @property string $id
 * @property CarbonImmutable $occurred_at
 * @property AuditEventType $event_type
 * @property string|null $actor_id
 * @property string|null $subject_type
 * @property string|null $subject_id
 * @property string|null $email_attempted
 * @property string $result
 * @property string|null $ip_address
 * @property string|null $user_agent
 * @property array<string, mixed>|null $context
 */
#[Fillable([
    'occurred_at',
    'event_type',
    'actor_id',
    'subject_type',
    'subject_id',
    'email_attempted',
    'result',
    'ip_address',
    'user_agent',
    'context',
])]
class AuditEvent extends Model
{
    use HasUuids;

    public const RESULT_SUCCESS = 'success';

    public const RESULT_FAILURE = 'failure';

    public const RESULT_DENIED = 'denied';

    /**
     * La fecha del evento vive en occurred_at; no hay created_at/updated_at.
     */
    public $timestamps = false;

    protected static function booted(): void
    {
        static::updating(function (): never {
            throw new LogicException(__('audit.immutable'));
        });

        static::deleting(function (): never {
            throw new LogicException(__('audit.immutable'));
        });
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function actor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'actor_id');
    }

    /**
     * @return MorphTo<Model, $this>
     */
    public function subject(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'occurred_at' => 'immutable_datetime',
            'event_type' => AuditEventType::class,
            'context' => 'array',
        ];
    }
}
