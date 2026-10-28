<?php

declare(strict_types=1);

use App\Enums\StaffRole;
use App\Filament\Pages\Auth\Login;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Auth\Events\Attempting;
use Illuminate\Support\Facades\Event;
use Livewire\Features\SupportTesting\Testable;
use Livewire\Livewire;

/*
 * HU-001 · Validaciones y mensajes del login del personal (T-1-02).
 */

function hu001Login(string $panel = 'admin'): Testable
{
    Filament::setCurrentPanel(Filament::getPanel($panel));

    return Livewire::test(Login::class);
}

it('usa la página de login propia en el panel :dataset', function (string $panel) {
    expect(Filament::getPanel($panel)->getLoginRouteAction())->toBe(Login::class);

    $this->get("/{$panel}/login")
        ->assertOk()
        ->assertSee('Correo institucional')
        ->assertSee('Contraseña')
        ->assertSee('Ingresar');
})->with(['admin', 'docente']);

it('Credenciales incorrectas: contraseña errónea de un correo existente', function () {
    $user = User::factory()->active()->withRoles(StaffRole::Director)
        ->create(['email' => 'ana.perez@colegio-piloto.test', 'password' => 'Clave-Correcta-2026']);

    hu001Login()
        ->fillForm(['email' => $user->email, 'password' => 'Clave-Erronea-2026'])
        ->call('authenticate')
        ->assertHasFormErrors(['email'])
        ->assertSee('Correo o contraseña incorrectos.');

    $this->assertGuest();
});

it('Credenciales incorrectas: el mensaje no revela si el correo existe', function () {
    User::factory()->active()->withRoles(StaffRole::Director)
        ->create(['email' => 'ana.perez@colegio-piloto.test', 'password' => 'Clave-Correcta-2026']);

    $existente = hu001Login()
        ->fillForm(['email' => 'ana.perez@colegio-piloto.test', 'password' => 'Clave-Erronea-2026'])
        ->call('authenticate')
        ->errors()
        ->get('data.email');

    $inexistente = hu001Login()
        ->fillForm(['email' => 'nadie.existe@colegio-piloto.test', 'password' => 'Clave-Erronea-2026'])
        ->call('authenticate')
        ->errors()
        ->get('data.email');

    expect($existente)->toBe(['Correo o contraseña incorrectos.'])
        ->and($inexistente)->toBe($existente);
});

it('Correo no institucional: muestra "Usa tu correo institucional" sin intentar autenticar', function () {
    Event::fake([Attempting::class]);

    hu001Login()
        ->fillForm(['email' => 'ana.perez@gmail.com', 'password' => 'Clave-Correcta-2026'])
        ->call('authenticate')
        ->assertHasFormErrors(['email'])
        ->assertSee('Usa tu correo institucional');

    Event::assertNotDispatched(Attempting::class);
    $this->assertGuest();
});

it('Campos vacíos: indica qué campo falta y no envía la solicitud de autenticación', function () {
    Event::fake([Attempting::class]);

    hu001Login()
        ->fillForm(['email' => '', 'password' => ''])
        ->call('authenticate')
        ->assertHasFormErrors(['email' => 'required', 'password' => 'required'])
        ->assertSee('Ingresa tu correo institucional.')
        ->assertSee('Ingresa tu contraseña.');

    Event::assertNotDispatched(Attempting::class);
});

it('Campos vacíos: solo falta la contraseña', function () {
    hu001Login()
        ->fillForm(['email' => 'ana.perez@colegio-piloto.test', 'password' => ''])
        ->call('authenticate')
        ->assertHasFormErrors(['password' => 'required'])
        ->assertHasNoFormErrors(['email']);
});

it('permite mostrar u ocultar la contraseña', function () {
    hu001Login()
        ->assertFormFieldExists('password', fn ($field): bool => $field->isPasswordRevealable());
});
