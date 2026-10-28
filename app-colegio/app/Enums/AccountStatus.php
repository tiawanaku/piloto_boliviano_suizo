<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Estados de una cuenta del personal (ver "Flujo de autenticacion" en el vault).
 */
enum AccountStatus: string
{
    case Pending = 'pending';
    case Active = 'active';
    case Locked = 'locked';
    case Deactivated = 'deactivated';

    public function label(): string
    {
        return __('account.status.'.$this->value);
    }

    public function isActive(): bool
    {
        return $this === self::Active;
    }
}
