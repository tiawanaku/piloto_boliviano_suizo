<?php

declare(strict_types=1);

use App\Enums\AccountStatus;
use App\Enums\StaffRole;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

it('crea una cuenta activa con los roles y una contraseña temporal de 72 horas', function () {
    $this->freezeSecond();

    $this->artisan('colegio:crear-cuenta', [
        'correo' => 'Nueva.Docente@colegio-piloto.test',
        '--rol' => ['teacher', 'pedagogical_coordinator'],
        '--nombre' => 'Nueva Docente',
    ])
        ->expectsOutputToContain('Cuenta creada y activa: nueva.docente@colegio-piloto.test')
        ->expectsOutputToContain('se muestra solo esta vez')
        ->assertSuccessful();

    $user = User::query()->where('email', 'nueva.docente@colegio-piloto.test')->sole();

    expect($user->name)->toBe('Nueva Docente')
        ->and($user->status)->toBe(AccountStatus::Active)
        ->and($user->must_change_password)->toBeTrue()
        ->and($user->temporary_password_expires_at?->equalTo(now()->addHours(72)))->toBeTrue()
        ->and($user->staffRoles())->toBe([StaffRole::PedagogicalCoordinator, StaffRole::Teacher]);
});

it('muestra la contraseña temporal una sola vez y no la escribe en el log', function () {
    Log::spy();

    $this->artisan('colegio:crear-cuenta', ['correo' => 'ti@colegio-piloto.test', '--rol' => ['it_support']])
        ->expectsOutputToContain('Contraseña temporal')
        ->assertSuccessful();

    $user = User::query()->where('email', 'ti@colegio-piloto.test')->sole();
    expect(Hash::info($user->password)['algoName'])->toBe('argon2id');
    Log::shouldNotHaveReceived('info');
    Log::shouldNotHaveReceived('debug');
});

it('rechaza correos fuera del dominio institucional', function (string $correo) {
    $this->artisan('colegio:crear-cuenta', ['correo' => $correo, '--rol' => ['teacher']])
        ->assertFailed();

    expect(User::query()->count())->toBe(0);
})->with([
    'otro dominio' => 'persona@gmail.com',
    'dominio parecido' => 'persona@otro-colegio-piloto.test',
    'no es correo' => 'persona',
]);

it('rechaza la cuenta sin rol, con un rol inexistente o con el rol Estudiante', function (array $roles) {
    $this->artisan('colegio:crear-cuenta', ['correo' => 'persona@colegio-piloto.test', '--rol' => $roles])
        ->assertFailed();

    expect(User::query()->count())->toBe(0);
})->with([
    'sin rol' => [[]],
    'rol inexistente' => [['rector']],
    'estudiante' => [['student']],
]);

it('no duplica un correo ya registrado', function () {
    User::factory()->create(['email' => 'repetido@colegio-piloto.test']);

    $this->artisan('colegio:crear-cuenta', ['correo' => 'repetido@colegio-piloto.test', '--rol' => ['teacher']])
        ->assertFailed();

    expect(User::query()->count())->toBe(1);
});
