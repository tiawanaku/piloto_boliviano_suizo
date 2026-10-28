<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\AccountStatus;
use App\Enums\StaffRole;
use App\Models\Concerns\HasTemporaryPassword;
use Database\Factories\UserFactory;
use Filament\Facades\Filament;
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
 * @property StaffRole|null $primary_role Rol principal elegido (null = prioridad por defecto).
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
     * Acceso a los paneles de Filament (ADR-005 §3, HU-007). Se evalúa en el
     * servidor en cada solicitud: cuenta activa y un rol que corresponda al panel.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        if (! $this->status->isActive()) {
            return false;
        }

        foreach ($this->staffRoles() as $role) {
            if ($role->panelId() === $panel->getId()) {
                return true;
            }
        }

        return false;
    }

    /**
     * Roles del usuario como enum, de mayor a menor prioridad.
     * Ignora nombres de rol que no existen en StaffRole.
     *
     * @return list<StaffRole>
     */
    public function staffRoles(): array
    {
        $roles = $this->getRoleNames()
            ->map(fn (string $name): ?StaffRole => StaffRole::tryFrom($name))
            ->filter()
            ->values()
            ->all();

        usort($roles, fn (StaffRole $a, StaffRole $b): int => $b->priority() <=> $a->priority());

        return $roles;
    }

    /**
     * Rol principal: `primary_role` si el usuario todavía lo tiene y da acceso
     * a un panel; si no, el rol con panel de mayor prioridad (administrativos
     * primero, luego Docente). Null si ningún rol da acceso a un panel.
     */
    public function primaryRole(): ?StaffRole
    {
        $roles = array_values(array_filter(
            $this->staffRoles(),
            fn (StaffRole $role): bool => $role->panelId() !== null,
        ));

        if ($this->primary_role !== null && in_array($this->primary_role, $roles, true)) {
            return $this->primary_role;
        }

        return $roles[0] ?? null;
    }

    /**
     * Id del panel del rol principal (`admin` o `docente`), o null si no tiene
     * ninguno o la cuenta no está activa.
     */
    public function primaryPanelId(): ?string
    {
        if (! $this->status->isActive()) {
            return null;
        }

        return $this->primaryRole()?->panelId();
    }

    /**
     * URL de inicio del panel principal (destino tras el login, HU-007).
     * Null si el usuario no puede entrar a ningún panel.
     */
    public function primaryPanelUrl(): ?string
    {
        $panelId = $this->primaryPanelId();

        return $panelId === null ? null : Filament::getPanel($panelId)->getUrl();
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
            'primary_role' => StaffRole::class,
        ];
    }
}
