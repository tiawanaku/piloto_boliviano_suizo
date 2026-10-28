<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/*
| Pruebas de humo (T-0-08): fallan si la aplicación no arranca.
*/

it('muestra la página de inicio', function () {
    $this->get('/')->assertOk();
});

it('responde en la ruta de salud /up', function () {
    $this->get('/up')->assertOk();
});

it('aplica todas las migraciones sin dejar ninguna pendiente', function () {
    $migrator = app('migrator');
    $files = array_keys($migrator->getMigrationFiles($migrator->paths() + [database_path('migrations')]));
    $ran = DB::table('migrations')->pluck('migration')->all();

    expect($files)->not->toBeEmpty()
        ->and(array_diff($files, $ran))->toBeEmpty()
        ->and(Schema::hasTable('users'))->toBeTrue()
        ->and(Schema::hasTable('sessions'))->toBeTrue()
        ->and(Schema::hasTable('jobs'))->toBeTrue()
        ->and(Schema::hasTable('cache'))->toBeTrue();
});

it('guarda la configuración en caché sin errores', function () {
    $cachedConfig = app()->getCachedConfigPath();

    try {
        expect(Artisan::call('config:cache'))->toBe(0)
            ->and($cachedConfig)->toBeFile()
            ->and(require $cachedConfig)->toBeArray()->toHaveKeys(['app', 'database', 'colegio']);
    } finally {
        Artisan::call('config:clear');
    }

    expect($cachedConfig)->not->toBeFile();
});
