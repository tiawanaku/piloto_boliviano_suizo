<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\Permission;
use App\Models\AuditEvent;
use App\Models\User;

/**
 * Autorización de la bitácora de auditoría (HU-013, HU-014).
 *
 * - Consulta: solo con el permiso "audit.view" (Dirección y Soporte TI según
 *   la matriz RBAC) y con la cuenta activa.
 * - Nadie crea, edita ni borra registros desde la aplicación: se escriben solo
 *   mediante App\Services\AuditLogger.
 */
class AuditEventPolicy
{
    public const VIEW_PERMISSION = Permission::AuditView->value;

    public function viewAny(User $user): bool
    {
        return $user->status->isActive() && $user->can(self::VIEW_PERMISSION);
    }

    public function view(User $user, AuditEvent $auditEvent): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, AuditEvent $auditEvent): bool
    {
        return false;
    }

    public function delete(User $user, AuditEvent $auditEvent): bool
    {
        return false;
    }

    public function deleteAny(User $user): bool
    {
        return false;
    }

    public function restore(User $user, AuditEvent $auditEvent): bool
    {
        return false;
    }

    public function restoreAny(User $user): bool
    {
        return false;
    }

    public function forceDelete(User $user, AuditEvent $auditEvent): bool
    {
        return false;
    }

    public function forceDeleteAny(User $user): bool
    {
        return false;
    }

    public function replicate(User $user, AuditEvent $auditEvent): bool
    {
        return false;
    }

    public function reorder(User $user): bool
    {
        return false;
    }
}
