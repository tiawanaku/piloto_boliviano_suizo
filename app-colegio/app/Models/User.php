<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\AccountStatus;
use App\Models\Concerns\HasTemporaryPassword;
use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

/**
 * Cuenta del personal del colegio (identificador UUID).
 * Roles y permisos con spatie/laravel-permission (ver App\Enums\StaffRole).
 *
 * @property string $id
 * @property string $name
 * @property string $email
 * @property AccountStatus $status
 */
#[Fillable(['name', 'email', 'password', 'status'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, HasRoles, HasTemporaryPassword, HasUuids, Notifiable;

    /**
     * Valores por defecto: una cuenta nueva queda pendiente hasta activarse.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        'status' => 'pending',
    ];

    /**
     * Acceso provisional a los paneles de Filament: solo cuentas activas.
     * Los roles (spatie/laravel-permission) se incorporan en el Sprint 1.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->status === AccountStatus::Active;
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'status' => AccountStatus::class,
        ];
    }
}
