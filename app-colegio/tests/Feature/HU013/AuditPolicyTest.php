<?php

declare(strict_types=1);

use App\Enums\AuditEventType;
use App\Enums\StaffRole;
use App\Models\AuditEvent;
use App\Models\User;
use App\Policies\AuditEventPolicy;
use App\Services\AuditLogger;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

/*
| HU-013 · Escenario "Inmutabilidad" a nivel de aplicación (T-1-18) y
| consulta reservada al permiso audit.view (Dirección y Soporte TI, HU-014).
*/

/**
 * spatie/laravel-permission listo: trait en User y tablas migradas (T-1-08, Dev 2).
 */
function hu013RbacReady(): bool
{
    return in_array(HasRoles::class, class_uses_recursive(User::class), true)
        && Schema::hasTable('permissions');
}

/**
 * Cuenta con un rol que tiene (o no) el permiso audit.view.
 */
function hu013UserWithRole(string $role, bool $canViewAudit, ?User $user = null): User
{
    $user ??= User::factory()->create();
    $roleModel = Role::findOrCreate($role, 'web');

    if ($canViewAudit) {
        $roleModel->givePermissionTo(Permission::findOrCreate(AuditEventPolicy::VIEW_PERMISSION, 'web'));
    }

    $user->assignRole($roleModel);

    return $user;
}

beforeEach(function () {
    $this->event = app(AuditLogger::class)->record(AuditEventType::LoginSucceeded);
});

it('registra AuditEventPolicy como policy del modelo AuditEvent', function () {
    expect(Gate::getPolicyFor(AuditEvent::class))->toBeInstanceOf(AuditEventPolicy::class);
});

it('Inmutabilidad: nadie puede :dataset registros de auditoría desde la aplicación', function (string $ability) {
    $user = User::factory()->create();

    $arguments = in_array($ability, ['create', 'deleteAny', 'restoreAny', 'forceDeleteAny', 'reorder'], true)
        ? AuditEvent::class
        : $this->event;

    expect($user->can($ability, $arguments))->toBeFalse();
})->with(['create', 'update', 'delete', 'deleteAny', 'restore', 'restoreAny', 'forceDelete', 'forceDeleteAny', 'replicate', 'reorder']);

it('Inmutabilidad: ni siquiera quien puede consultar la bitácora puede editarla o borrarla', function () {
    if (! hu013RbacReady()) {
        $this->markTestSkipped('Pendiente de spatie/laravel-permission en User (T-1-08).');
    }

    $user = hu013UserWithRole('auditor-de-prueba', canViewAudit: true);

    expect($user->can('viewAny', AuditEvent::class))->toBeTrue()
        ->and($user->can('create', AuditEvent::class))->toBeFalse()
        ->and($user->can('update', $this->event))->toBeFalse()
        ->and($user->can('delete', $this->event))->toBeFalse()
        ->and($user->can('deleteAny', AuditEvent::class))->toBeFalse();
});

it('niega la consulta de la bitácora a una cuenta sin el permiso audit.view', function () {
    $user = User::factory()->create();

    if (hu013RbacReady()) {
        hu013UserWithRole('rol-sin-auditoria', canViewAudit: false, user: $user);
    }

    expect($user->can('viewAny', AuditEvent::class))->toBeFalse()
        ->and($user->can('view', $this->event))->toBeFalse();
});

it('permite consultar la bitácora a una cuenta activa con el permiso audit.view', function () {
    if (! hu013RbacReady()) {
        $this->markTestSkipped('Pendiente de spatie/laravel-permission en User (T-1-08).');
    }

    $user = hu013UserWithRole('auditor-de-prueba', canViewAudit: true);

    expect($user->can('viewAny', AuditEvent::class))->toBeTrue()
        ->and($user->can('view', $this->event))->toBeTrue();
});

it('niega la consulta a una cuenta :dataset aunque tenga el permiso audit.view', function (string $estado) {
    if (! hu013RbacReady()) {
        $this->markTestSkipped('Pendiente de spatie/laravel-permission en User (T-1-08).');
    }

    $user = hu013UserWithRole('auditor-de-prueba', canViewAudit: true, user: User::factory()->{$estado}()->create());

    expect($user->can('viewAny', AuditEvent::class))->toBeFalse();
})->with(['pending', 'locked', 'deactivated']);

it('con la matriz RBAC sembrada, el rol :dataset puede o no consultar la bitácora', function (StaffRole $role) {
    if (! hu013RbacReady() || ! class_exists(RolesAndPermissionsSeeder::class)) {
        $this->markTestSkipped('Pendiente del seeder de la matriz RBAC (T-1-09).');
    }

    $this->seed(RolesAndPermissionsSeeder::class);

    $user = User::factory()->create();
    $user->assignRole($role->value);

    $expected = in_array($role, [StaffRole::Director, StaffRole::ItSupport], true);

    expect($user->can('viewAny', AuditEvent::class))->toBe($expected)
        ->and($user->can('view', $this->event))->toBe($expected)
        ->and($user->can('update', $this->event))->toBeFalse()
        ->and($user->can('delete', $this->event))->toBeFalse();
})->with(fn (): array => collect(StaffRole::cases())->mapWithKeys(fn (StaffRole $role): array => [$role->value => [$role]])->all());
