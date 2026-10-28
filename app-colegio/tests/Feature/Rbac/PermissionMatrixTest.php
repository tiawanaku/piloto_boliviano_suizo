<?php

declare(strict_types=1);

use App\Enums\Permission;
use App\Enums\StaffRole;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Spatie\Permission\Models\Permission as PermissionModel;
use Spatie\Permission\Models\Role;

/*
 * Copia independiente de la matriz de "Roles y permisos RBAC" (vault).
 * Columnas: Dirección, Secretaría, Coordinación, Soporte TI, Oficina, Docente, Estudiante.
 * Si la matriz cambia, se actualizan el vault, el seeder y esta tabla.
 */
dataset('celdas de la matriz', function () {
    $roles = [
        StaffRole::Director,
        StaffRole::AcademicSecretary,
        StaffRole::PedagogicalCoordinator,
        StaffRole::ItSupport,
        StaffRole::InformationOffice,
        StaffRole::Teacher,
        StaffRole::Student,
    ];

    $matrix = [
        'staff_portal.access' => [1, 1, 1, 1, 1, 1, 0],
        'staff.invite' => [1, 1, 0, 1, 0, 0, 0],
        'roles.assign_high' => [1, 0, 0, 1, 0, 0, 0],
        'roles.assign_standard' => [1, 1, 0, 1, 0, 0, 0],
        'accounts.deactivate' => [1, 1, 0, 1, 0, 0, 0],
        'accounts.unlock' => [0, 0, 0, 1, 0, 0, 0],
        'mfa.reset' => [0, 0, 0, 1, 0, 0, 0],
        'audit.view' => [1, 0, 0, 1, 0, 0, 0],
        'academic_structure.manage' => [1, 1, 1, 0, 0, 0, 0],
        'subjects.manage' => [1, 0, 1, 0, 0, 0, 0],
        'classrooms.create' => [1, 0, 1, 0, 0, 0, 0],
        'classrooms.assign' => [1, 0, 1, 0, 0, 0, 0],
        'staff.view' => [1, 1, 0, 1, 0, 0, 0],
        'staff.edit' => [1, 1, 0, 1, 0, 0, 0],
        'staff.edit_email' => [0, 0, 0, 1, 0, 0, 0],
        'students.register' => [1, 1, 0, 0, 0, 0, 0],
        'students.enroll' => [1, 1, 0, 0, 0, 0, 0],
        'student_credentials.manage' => [1, 1, 0, 0, 0, 0, 0],
        'directory.view_basic' => [1, 1, 1, 0, 1, 0, 0],
        'classrooms.view_own' => [0, 0, 0, 0, 0, 1, 0],
        'own_account.manage' => [1, 1, 1, 1, 1, 1, 0],
    ];

    expect(array_keys($matrix))->toEqualCanonicalizing(
        array_map(fn (Permission $permission): string => $permission->value, Permission::cases()),
    );

    $cells = [];
    foreach ($matrix as $permission => $row) {
        foreach ($roles as $index => $role) {
            $cells["{$role->value} × {$permission}"] = [$role, Permission::from($permission), (bool) $row[$index]];
        }
    }

    return $cells;
});

beforeEach(function () {
    $this->seed(RolesAndPermissionsSeeder::class);
});

it('replica cada celda de la matriz de roles y permisos', function (StaffRole $role, Permission $permission, bool $allowed) {
    expect(Role::findByName($role->value, 'web')->hasPermissionTo($permission->value))->toBe($allowed);
})->with('celdas de la matriz');

it('crea un rol por cada StaffRole y un permiso por cada Permission', function () {
    expect(Role::query()->pluck('name')->all())->toEqualCanonicalizing(
        array_map(fn (StaffRole $role): string => $role->value, StaffRole::cases()),
    )
        ->and(PermissionModel::query()->pluck('name')->all())->toEqualCanonicalizing(
            array_map(fn (Permission $permission): string => $permission->value, Permission::cases()),
        );
});

it('no duplica roles, permisos ni asignaciones al ejecutar el seeder dos veces', function () {
    $counts = fn (): array => [
        Role::query()->count(),
        PermissionModel::query()->count(),
        DB::table('role_has_permissions')->count(),
    ];
    $before = $counts();

    $this->seed(RolesAndPermissionsSeeder::class);

    expect($counts())->toBe($before);
});

it('permite asignar roles a un usuario con UUID', function () {
    $user = User::factory()->create();

    $user->assignRole(StaffRole::Teacher->value, StaffRole::PedagogicalCoordinator->value);

    expect($user->fresh()?->hasRole(StaffRole::Teacher->value))->toBeTrue()
        ->and($user->fresh()?->can(Permission::ClassroomsCreate->value))->toBeTrue()
        ->and($user->fresh()?->can(Permission::AuditView->value))->toBeFalse()
        ->and(DB::table('model_has_roles')->where('model_uuid', $user->id)->count())->toBe(2);
});
