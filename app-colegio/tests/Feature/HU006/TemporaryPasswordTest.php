<?php

declare(strict_types=1);

use App\Enums\AuditEventType;
use App\Enums\StaffRole;
use App\Filament\Pages\Auth\ChangeTemporaryPassword;
use App\Filament\Pages\Auth\Login;
use App\Models\AuditEvent;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Livewire\Livewire;

/*
 * HU-006 · Contraseña temporal y contraseña temporal vencida (T-1-07).
 */

const HU006_TEMPORAL = 'Temporal-Ficticia-4821';

beforeEach(function () {
    // Have I Been Pwned simulado: ninguna contraseña aparece filtrada.
    Http::fake(['api.pwnedpasswords.com/*' => Http::response('0000000000000000000000000000000000A:1')]);
});

function hu006TemporaryUser(StaffRole $role = StaffRole::Director): User
{
    return User::factory()->active()->withTemporaryPassword()->withRoles($role)
        ->create(['email' => 'ana.perez@colegio-piloto.test', 'password' => HU006_TEMPORAL]);
}

it('Contraseña temporal: cualquier página del panel :dataset redirige a definir la contraseña', function (string $panel, StaffRole $role) {
    $this->actingAs(hu006TemporaryUser($role));

    foreach (["/{$panel}", "/{$panel}?pestana=resumen"] as $uri) {
        $this->get($uri)->assertRedirect("/{$panel}/cambiar-contrasena");
    }

    $this->get("/{$panel}/cambiar-contrasena")
        ->assertOk()
        ->assertSee('Define tu propia contraseña')
        ->assertSee('Nueva contraseña');
})->with([
    ['admin', StaffRole::Director],
    ['docente', StaffRole::Teacher],
]);

it('Contraseña temporal: inicia sesión con la temporal y debe definir una nueva', function () {
    $user = hu006TemporaryUser();
    Filament::setCurrentPanel(Filament::getPanel('admin'));

    Livewire::test(Login::class)
        ->fillForm(['email' => $user->email, 'password' => HU006_TEMPORAL])
        ->call('authenticate')
        ->assertHasNoFormErrors();

    $this->assertAuthenticatedAs($user);
    $this->get('/admin')->assertRedirect('/admin/cambiar-contrasena');
});

it('Contraseña temporal: al definir una contraseña válida accede al panel', function () {
    $user = hu006TemporaryUser();
    $this->actingAs($user);
    Filament::setCurrentPanel(Filament::getPanel('admin'));

    Livewire::test(ChangeTemporaryPassword::class)
        ->fillForm(['password' => 'lluvia-en-el-altiplano-42', 'passwordConfirmation' => 'lluvia-en-el-altiplano-42'])
        ->call('save')
        ->assertHasNoFormErrors()
        ->assertRedirect(Filament::getPanel('admin')->getUrl());

    $user->refresh();

    expect($user->must_change_password)->toBeFalse()
        ->and($user->temporary_password_expires_at)->toBeNull()
        ->and(Hash::check('lluvia-en-el-altiplano-42', $user->password))->toBeTrue();

    $this->get('/admin')->assertOk();
});

it('Política de contraseña: la página muestra qué requisito no se cumple', function (string $password, string $message) {
    $this->actingAs(hu006TemporaryUser());
    Filament::setCurrentPanel(Filament::getPanel('admin'));

    Livewire::test(ChangeTemporaryPassword::class)
        ->fillForm(['password' => $password, 'passwordConfirmation' => $password])
        ->call('save')
        ->assertHasFormErrors(['password'])
        ->assertSee($message);

    expect(User::sole()->must_change_password)->toBeTrue();
})->with([
    'menos de 10 caracteres' => ['Corta-9x', 'debe tener al menos 10 caracteres'],
    'contraseña común' => ['contrasena123', 'Esa contraseña es muy común y fácil de adivinar. Elige otra.'],
    'igual a la temporal' => [HU006_TEMPORAL, 'La nueva contraseña debe ser distinta de la temporal.'],
]);

it('exige repetir la misma contraseña', function () {
    $this->actingAs(hu006TemporaryUser());
    Filament::setCurrentPanel(Filament::getPanel('admin'));

    Livewire::test(ChangeTemporaryPassword::class)
        ->fillForm(['password' => 'lluvia-en-el-altiplano-42', 'passwordConfirmation' => 'otra-cosa-distinta-42'])
        ->call('save')
        ->assertHasFormErrors(['password'])
        ->assertSee('Las contraseñas no coinciden.');
});

it('muestra el indicador de fortaleza', function () {
    $this->actingAs(hu006TemporaryUser());

    $this->get('/admin/cambiar-contrasena')
        ->assertSee('data-password-strength', false)
        ->assertSee('Fortaleza:');
});

it('una cuenta sin contraseña temporal no es redirigida y sale de la página de cambio', function () {
    actingAsStaff(StaffRole::Director);

    $this->get('/admin')->assertOk();
    $this->get('/admin/cambiar-contrasena')->assertRedirect(Filament::getPanel('admin')->getUrl());
});

it('un invitado no puede abrir la página de cambio', function () {
    $this->get('/admin/cambiar-contrasena')->assertRedirect('/admin/login');
});

it('Contraseña temporal vencida: después de 72 horas pide solicitar una nueva a secretaría', function () {
    $user = hu006TemporaryUser();
    $this->travel(73)->hours();
    Filament::setCurrentPanel(Filament::getPanel('admin'));

    Livewire::test(Login::class)
        ->fillForm(['email' => $user->email, 'password' => HU006_TEMPORAL])
        ->call('authenticate')
        ->assertHasFormErrors(['email'])
        ->assertSee('Tu contraseña temporal venció. Solicita una nueva a secretaría.');

    $this->assertGuest();
    expect(AuditEvent::query()->where('event_type', AuditEventType::LoginFailed)->count())->toBe(1);
});

it('Contraseña temporal vencida: con contraseña incorrecta solo muestra el mensaje genérico', function () {
    $user = hu006TemporaryUser();
    $this->travel(73)->hours();
    Filament::setCurrentPanel(Filament::getPanel('admin'));

    Livewire::test(Login::class)
        ->fillForm(['email' => $user->email, 'password' => 'Otra-Clave-Erronea-1'])
        ->call('authenticate')
        ->assertSee('Correo o contraseña incorrectos.')
        ->assertDontSee('venció');
});
