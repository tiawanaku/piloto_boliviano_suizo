<?php

declare(strict_types=1);

use App\Rules\InstitutionalEmail;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

uses(TestCase::class);

function institutionalEmailErrors(mixed $email): array
{
    return Validator::make(['email' => $email], ['email' => [new InstitutionalEmail]])
        ->errors()
        ->get('email');
}

it('acepta correos del dominio institucional', function (string $email) {
    expect(institutionalEmailErrors($email))->toBe([]);
})->with([
    'ana.perez@colegio-piloto.test',
    'ANA.PEREZ@Colegio-Piloto.TEST',
    '  ana.perez@colegio-piloto.test ',
]);

it('rechaza correos de otros dominios con "Usa tu correo institucional"', function (string $email) {
    expect(institutionalEmailErrors($email))
        ->toBe(['Usa tu correo institucional (termina en @colegio-piloto.test).']);
})->with([
    'ana.perez@gmail.com',
    'ana.perez@otro-colegio-piloto.test',
    'ana.perez@sub.colegio-piloto.test',
    'ana.perez@colegio-piloto.test.com',
    'ana@perez@colegio-piloto.test',
    '@colegio-piloto.test',
]);

it('rechaza valores que no son texto', function () {
    expect(institutionalEmailErrors(['ana.perez@colegio-piloto.test']))->not->toBe([]);
});

it('usa el dominio configurado en colegio.dominio_institucional', function () {
    config(['colegio.dominio_institucional' => 'otro-piloto.test']);

    expect(InstitutionalEmail::passes('ana@otro-piloto.test'))->toBeTrue()
        ->and(InstitutionalEmail::passes('ana@colegio-piloto.test'))->toBeFalse();
});
