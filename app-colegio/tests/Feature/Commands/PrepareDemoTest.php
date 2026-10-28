<?php

declare(strict_types=1);

use App\Enums\AccountStatus;
use App\Models\User;
use Illuminate\Support\Facades\DB;

/*
 * migrate:fresh no puede correr dentro de la transacción de RefreshDatabase
 * (SQLite no permite VACUUM en una transacción). Cada prueba usa su propia
 * base SQLite en un archivo temporal, como la base real de demostración.
 */
beforeEach(function () {
    $this->demoDatabase = tempnam(sys_get_temp_dir(), 'colegio-demo-');

    config([
        'database.connections.demo_test' => array_merge(
            config()->array('database.connections.sqlite'),
            ['database' => $this->demoDatabase],
        ),
        'database.default' => 'demo_test',
    ]);

    $this->artisan('migrate', ['--force' => true]);
});

afterEach(function () {
    DB::purge('demo_test');
    config(['database.default' => 'sqlite']);
    @unlink($this->demoDatabase);
});

it('deja la base con la cuenta de demostración activa', function () {
    User::factory()->create(['email' => 'previa@colegio-piloto.test']);

    $this->artisan('colegio:demo', ['--force' => true])
        ->expectsOutputToContain('Base de demostración lista')
        ->expectsOutputToContain('/admin')
        ->assertSuccessful();

    expect(User::query()->where('email', 'previa@colegio-piloto.test')->exists())->toBeFalse();

    $demo = User::query()->where('email', 'demo@colegio-piloto.test')->sole();
    expect($demo->status)->toBe(AccountStatus::Active);
});

it('solo crea cuentas ficticias del dominio del piloto', function () {
    $this->artisan('colegio:demo', ['--force' => true])->assertSuccessful();

    expect(User::query()->pluck('email')->all())
        ->each->toEndWith('@colegio-piloto.test');
});

it('termina con error en producción sin tocar los datos', function () {
    $user = User::factory()->create(['email' => 'previa@colegio-piloto.test']);
    app()->detectEnvironment(fn (): string => 'production');

    $this->artisan('colegio:demo', ['--force' => true])
        ->expectsOutputToContain('no se puede ejecutar en producción')
        ->assertFailed();

    app()->detectEnvironment(fn (): string => 'testing');

    expect(User::query()->whereKey($user->getKey())->exists())->toBeTrue();
});

it('no toca los datos si se cancela la confirmación', function () {
    $user = User::factory()->create();

    $this->artisan('colegio:demo')
        ->expectsConfirmation('Se borrará la base de datos actual y se cargarán datos ficticios de demostración. ¿Continuar?', 'no')
        ->assertFailed();

    expect(User::query()->whereKey($user->getKey())->exists())->toBeTrue();
});
