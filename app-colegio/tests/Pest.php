<?php

declare(strict_types=1);

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
