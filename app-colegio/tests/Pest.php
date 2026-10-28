<?php

declare(strict_types=1);

use App\Enums\StaffRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/*
|--------------------------------------------------------------------------
| Vinculación de pruebas
|--------------------------------------------------------------------------
|
| Las pruebas de Feature (y las unitarias de modelos, que necesitan la
| aplicación y la base de datos) usan el TestCase de Laravel y una base
| SQLite en memoria que se reinicia con RefreshDatabase en cada prueba.
| Las unitarias de enums arrancan la aplicación (traducciones) sin base de
| datos. El resto de tests/Unit corre sin arrancar la aplicación.
|
*/

pest()->extend(TestCase::class)
    ->use(RefreshDatabase::class)
    ->in('Feature', 'Unit/Models');

pest()->extend(TestCase::class)->in('Unit/Enums');

/*
|--------------------------------------------------------------------------
| Helpers globales
|--------------------------------------------------------------------------
*/

/**
 * Crea una cuenta activa del personal con los roles indicados (carga la
 * matriz RBAC si hace falta) y autentica la prueba con ella.
 */
function actingAsStaff(StaffRole ...$roles): User
{
    $user = User::factory()->active()->withRoles(...$roles)->create();

    test()->actingAs($user);

    return $user;
}
