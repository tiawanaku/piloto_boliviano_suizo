<?php

declare(strict_types=1);

use App\Enums\AccountStatus;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

it('usa un UUID como identificador', function () {
    $user = User::factory()->create();

    expect(Str::isUuid($user->id))->toBeTrue()
        ->and($user->getKeyType())->toBe('string')
        ->and($user->getIncrementing())->toBeFalse();
});

it('guarda la contraseña con Argon2id', function () {
    $user = User::factory()->create(['password' => 'una-contrasena-ficticia']);

    expect(Hash::info($user->password)['algoName'])->toBe('argon2id')
        ->and(Hash::check('una-contrasena-ficticia', $user->password))->toBeTrue();
});

it('convierte el estado de la cuenta en el enum AccountStatus', function () {
    $user = User::factory()->locked()->create();

    expect($user->fresh()?->status)->toBe(AccountStatus::Locked);
});

it('crea las cuentas nuevas como pendientes por defecto', function () {
    $user = User::create([
        'name' => 'Persona ficticia',
        'email' => 'persona@colegio-piloto.test',
        'password' => 'una-contrasena-ficticia',
    ]);

    expect($user->fresh()?->status)->toBe(AccountStatus::Pending);
});

it('crea por defecto cuentas activas con correo @colegio-piloto.test en la factory', function () {
    $user = User::factory()->create();

    expect($user->status)->toBe(AccountStatus::Active)
        ->and($user->email)->toEndWith('@colegio-piloto.test');
});

it('traduce las etiquetas de estado al español', function (AccountStatus $status, string $label) {
    expect($status->label())->toBe($label);
})->with([
    [AccountStatus::Pending, 'Pendiente'],
    [AccountStatus::Active, 'Activa'],
    [AccountStatus::Locked, 'Bloqueada'],
    [AccountStatus::Deactivated, 'Desactivada'],
]);

it('acepta un user_id UUID en la tabla sessions', function () {
    $user = User::factory()->create();

    DB::table('sessions')->insert([
        'id' => Str::random(40),
        'user_id' => $user->id,
        'ip_address' => '127.0.0.1',
        'user_agent' => 'Pest',
        'payload' => '',
        'last_activity' => now()->getTimestamp(),
    ]);

    expect(DB::table('sessions')->where('user_id', $user->id)->exists())->toBeTrue();
});
