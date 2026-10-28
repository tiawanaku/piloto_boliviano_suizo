<?php

declare(strict_types=1);

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Contraseña temporal de una cuenta del personal (HU-006).
 *
 * Columnas: must_change_password (bool) y temporary_password_expires_at
 * (fecha, nullable). Los casts se agregan con initializeHasTemporaryPassword(),
 * así que el modelo no necesita declararlos en casts().
 *
 * @property bool $must_change_password
 * @property Carbon|null $temporary_password_expires_at
 *
 * @phpstan-require-extends Model
 */
trait HasTemporaryPassword
{
    public function initializeHasTemporaryPassword(): void
    {
        $this->mergeCasts([
            'must_change_password' => 'boolean',
            'temporary_password_expires_at' => 'datetime',
        ]);
    }

    /**
     * Marca la contraseña actual como temporal: se debe cambiar en el primer
     * ingreso y vence según colegio.contrasena_temporal_horas. No guarda.
     */
    public function markPasswordAsTemporary(): static
    {
        $this->must_change_password = true;
        $this->temporary_password_expires_at = now()->addHours(
            config()->integer('colegio.contrasena_temporal_horas', 72),
        );

        return $this;
    }

    /**
     * La persona definió su propia contraseña: deja de ser temporal. No guarda.
     */
    public function clearTemporaryPassword(): static
    {
        $this->must_change_password = false;
        $this->temporary_password_expires_at = null;

        return $this;
    }

    /**
     * Verdadero si la cuenta tiene una contraseña temporal pendiente de cambio
     * cuya vigencia ya terminó (bloquea el login, HU-006).
     */
    public function temporaryPasswordExpired(): bool
    {
        return $this->must_change_password
            && $this->temporary_password_expires_at !== null
            && $this->temporary_password_expires_at->isPast();
    }
}
