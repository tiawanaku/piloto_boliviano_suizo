<?php

declare(strict_types=1);

use App\Rules\NotCommonPassword;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Tests\TestCase;

/*
 * HU-006 · Escenario: Política de contraseña.
 * La política (mín. 10, uncompromised() y NotCommonPassword) es la que
 * AppServiceProvider registrará como Password::defaults() (T-1-06).
 */

uses(TestCase::class);

/**
 * @return array<string, string>
 */
function passwordErrors(string $password): array
{
    $validator = Validator::make(
        ['password' => $password],
        ['password' => ['required', Password::min(10)->uncompromised()->rules([new NotCommonPassword])]],
    );

    return $validator->errors()->get('password');
}

/**
 * Simula la API de Have I Been Pwned (k-anonimato) sin salir a la red.
 */
function fakePwnedApi(?string $compromisedPassword = null): void
{
    $body = '0000000000000000000000000000000000A:1';

    if ($compromisedPassword !== null) {
        $hash = strtoupper(sha1($compromisedPassword));
        $body .= "\r\n".substr($hash, 5).':12345';
    }

    Http::fake(['api.pwnedpasswords.com/*' => Http::response($body)]);
}

beforeEach(function () {
    app()->setLocale('es');
});

it('Política de contraseña: rechaza menos de 10 caracteres con su mensaje', function () {
    fakePwnedApi();

    expect(passwordErrors('Cort0-9x'))
        ->toBe(['El campo contraseña debe tener al menos 10 caracteres.']);
});

it('Política de contraseña: rechaza una contraseña común con su mensaje', function (string $common) {
    fakePwnedApi();

    expect(passwordErrors($common))
        ->toBe(['Esa contraseña es muy común y fácil de adivinar. Elige otra.']);
})->with(['1234567890', 'Contrasena123', '  qwertyuiop  ']);

it('Política de contraseña: rechaza una contraseña filtrada (uncompromised simulado)', function () {
    fakePwnedApi('Filtrada-Ficticia-2026');

    expect(passwordErrors('Filtrada-Ficticia-2026'))
        ->toBe([__('validation.password.uncompromised', ['attribute' => 'contraseña'])]);

    Http::assertSent(fn ($request) => str_starts_with(
        $request->url(),
        'https://api.pwnedpasswords.com/range/'.substr(strtoupper(sha1('Filtrada-Ficticia-2026')), 0, 5),
    ));
});

it('Política de contraseña: acepta una contraseña larga, no común y no filtrada', function () {
    fakePwnedApi();

    expect(passwordErrors('lluvia-en-el-altiplano-42'))->toBe([]);
});

it('NotCommonPassword no consulta la red', function () {
    Http::preventStrayRequests();

    $validator = Validator::make(['password' => 'password123'], ['password' => [new NotCommonPassword]]);

    expect($validator->fails())->toBeTrue();
});
