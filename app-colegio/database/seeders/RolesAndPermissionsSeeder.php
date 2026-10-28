<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\Permission;
use App\Enums\StaffRole;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission as PermissionModel;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

/**
 * Carga la matriz de "Roles y permisos RBAC" (vault, 05-Arquitectura) en las
 * tablas de spatie/laravel-permission. Idempotente: se puede ejecutar en cada
 * despliegue; sincroniza los permisos de cada rol con la matriz.
 */
class RolesAndPermissionsSeeder extends Seeder
{
    public const GUARD = 'web';

    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        foreach (Permission::cases() as $permission) {
            PermissionModel::findOrCreate($permission->value, self::GUARD);
        }

        // DatabaseSeeder usa WithoutModelEvents: spatie no limpia su caché al
        // crear permisos, así que se limpia a mano antes de asignarlos.
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        foreach (self::matrix() as $roleName => $permissions) {
            Role::findOrCreate($roleName, self::GUARD)
                ->syncPermissions(array_map(fn (Permission $permission): string => $permission->value, $permissions));
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    /**
     * Matriz vigente (Fase 1–3): rol => permisos. Estudiante aún no tiene
     * permisos del portal del personal (Fase 4).
     *
     * @return array<string, list<Permission>>
     */
    public static function matrix(): array
    {
        return [
            StaffRole::Director->value => [
                Permission::StaffPortalAccess,
                Permission::StaffInvite,
                Permission::RolesAssignHigh,
                Permission::RolesAssignStandard,
                Permission::AccountsDeactivate,
                Permission::AuditView,
                Permission::AcademicStructureManage,
                Permission::SubjectsManage,
                Permission::ClassroomsCreate,
                Permission::ClassroomsAssign,
                Permission::StaffView,
                Permission::StaffEdit,
                Permission::StudentsRegister,
                Permission::StudentsEnroll,
                Permission::StudentCredentialsManage,
                Permission::DirectoryViewBasic,
                Permission::OwnAccountManage,
            ],
            StaffRole::AcademicSecretary->value => [
                Permission::StaffPortalAccess,
                Permission::StaffInvite,
                Permission::RolesAssignStandard,
                Permission::AccountsDeactivate,
                Permission::AcademicStructureManage,
                Permission::StaffView,
                Permission::StaffEdit,
                Permission::StudentsRegister,
                Permission::StudentsEnroll,
                Permission::StudentCredentialsManage,
                Permission::DirectoryViewBasic,
                Permission::OwnAccountManage,
            ],
            StaffRole::PedagogicalCoordinator->value => [
                Permission::StaffPortalAccess,
                Permission::AcademicStructureManage,
                Permission::SubjectsManage,
                Permission::ClassroomsCreate,
                Permission::ClassroomsAssign,
                Permission::DirectoryViewBasic,
                Permission::OwnAccountManage,
            ],
            StaffRole::ItSupport->value => [
                Permission::StaffPortalAccess,
                Permission::StaffInvite,
                Permission::RolesAssignHigh,
                Permission::RolesAssignStandard,
                Permission::AccountsDeactivate,
                Permission::AccountsUnlock,
                Permission::MfaReset,
                Permission::AuditView,
                Permission::StaffView,
                Permission::StaffEdit,
                Permission::StaffEditEmail,
                Permission::OwnAccountManage,
            ],
            StaffRole::InformationOffice->value => [
                Permission::StaffPortalAccess,
                Permission::DirectoryViewBasic,
                Permission::OwnAccountManage,
            ],
            StaffRole::Teacher->value => [
                Permission::StaffPortalAccess,
                Permission::ClassroomsViewOwn,
                Permission::OwnAccountManage,
            ],
            StaffRole::Student->value => [],
        ];
    }
}
