<?php

declare(strict_types=1);

use Spatie\Permission\DefaultTeamResolver;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

/*
|--------------------------------------------------------------------------
| spatie/laravel-permission (T-1-08, TEC-10)
|--------------------------------------------------------------------------
|
| Publicada desde el paquete y adaptada al colegio:
| - `model_morph_key` = `model_uuid`: los usuarios usan UUID como clave.
| - Sin equipos (teams): un solo colegio.
| - Nunca se muestran nombres de roles/permisos en las excepciones.
| Los roles y permisos se cargan con RolesAndPermissionsSeeder.
|
*/

return [

    'models' => [
        'permission' => Permission::class,
        'role' => Role::class,
        'team' => null,
        'default_model' => null,
    ],

    'table_names' => [
        'roles' => 'roles',
        'permissions' => 'permissions',
        'model_has_permissions' => 'model_has_permissions',
        'model_has_roles' => 'model_has_roles',
        'role_has_permissions' => 'role_has_permissions',
    ],

    'column_names' => [
        'role_pivot_key' => null, // por defecto 'role_id'
        'permission_pivot_key' => null, // por defecto 'permission_id'
        'model_morph_key' => 'model_uuid',
        'team_foreign_key' => 'team_id',
    ],

    'register_permission_check_method' => true,

    'register_octane_reset_listener' => false,

    // Los cambios de rol se auditan con eventos de dominio propios (HU-010).
    'events_enabled' => false,

    'teams' => false,

    'team_resolver' => DefaultTeamResolver::class,

    'use_passport_client_credentials' => false,

    'display_permission_in_exception' => false,

    'display_role_in_exception' => false,

    'enable_wildcard_permission' => false,

    'cache' => [
        'expiration_time' => DateInterval::createFromDateString('24 hours'),
        'key' => 'spatie.permission.cache',
        'store' => 'default',
    ],

];
