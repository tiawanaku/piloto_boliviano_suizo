<?php

declare(strict_types=1);

use App\Enums\AccountStatus;
use App\Enums\AuditEventType;
use App\Enums\StaffRole;
use App\Filament\Pages\Auth\Login;
use App\Models\AuditEvent;
use App\Models\User;
use Filament\Facades\Filament;
use Livewire\Features\SupportTesting\Testable;
use Livewire\Livewire;

/*
 * HU-001 · Estados de cuenta e ingreso exitoso (T-1-03).
 */

const HU001_CONTRASENA = 'Clave-Ficticia-Hu001-7q2w';

function hu001Staff(StaffRole $role, AccountStatus $status = AccountStatus::Active): User
{
    return User::factory()->withRoles($role)->create([
        'email' => 'ana.perez@colegio-piloto.test',
        'password' => HU001_CONTRASENA,
        'status' => $status,
    ]);
}

function hu001Authenticate(string $panel, string $password = HU001_CONTRASENA): Testable
{
    Filament::setCurrentPanel(Filament::getPanel($panel));

    return Livewire::test(Login::class)
        ->fillForm(['email' => 'ana.perez@colegio-piloto.test', 'password' => $password])
        ->call('authenticate');
}

it('Inicio de sesión exitoso: accede y va a su panel según su rol', function (StaffRole $role, string $panel, string $destino) {
    $user = hu001Staff($role);

    hu001Authenticate($panel)
        ->assertHasNoFormErrors()
        ->assertRedirect(url($destino));

    $this->assertAuthenticatedAs($user);
})->with([
    'administrativa por /admin' => [StaffRole::AcademicSecretary, 'admin', '/admin'],
    'docente por /docente' => [StaffRole::Teacher, 'docente', '/docente'],
]);

it('Inicio de sesión exitoso: acepta el login del otro panel y lleva al panel principal', function (StaffRole $role, string $panel, string $destino) {
    $user = hu001Staff($role);

    hu001Authenticate($panel)
        ->assertHasNoFormErrors()
        ->assertRedirect(url($destino));

    $this->assertAuthenticatedAs($user);
})->with([
    'docente por /admin' => [StaffRole::Teacher, 'admin', '/docente'],
    'director por /docente' => [StaffRole::Director, 'docente', '/admin'],
]);

it('Inicio de sesión exitoso: regenera el identificador de sesión', function () {
    hu001Staff(StaffRole::Director);
    $antes = session()->getId();

    hu001Authenticate('admin')->assertHasNoFormErrors();

    expect(session()->getId())->not->toBe($antes);
});

it('Cuenta desactivada: con credenciales correctas ve que su cuenta no está activa', function (AccountStatus $status) {
    hu001Staff(StaffRole::Director, $status);

    hu001Authenticate('admin')
        ->assertHasFormErrors(['email'])
        ->assertSee('Tu cuenta no está activa. Comunícate con secretaría o la oficina de información');

    $this->assertGuest();
    expect(AuditEvent::query()->where('event_type', AuditEventType::LoginFailed)->count())->toBe(1);
})->with([
    'desactivada' => AccountStatus::Deactivated,
    'pendiente' => AccountStatus::Pending,
]);

it('Cuenta desactivada: con contraseña incorrecta no revela el estado', function () {
    hu001Staff(StaffRole::Director, AccountStatus::Deactivated);

    hu001Authenticate('admin', 'Clave-Erronea-123')
        ->assertSee('Correo o contraseña incorrectos.')
        ->assertDontSee('no está activa');

    $this->assertGuest();
});

it('rechaza con el mensaje genérico a una cuenta activa sin roles de personal', function () {
    User::factory()->active()->create(['email' => 'ana.perez@colegio-piloto.test', 'password' => HU001_CONTRASENA]);

    hu001Authenticate('admin')->assertSee('Correo o contraseña incorrectos.');

    $this->assertGuest();
});

it('rechaza con el mensaje genérico a una cuenta bloqueada', function () {
    hu001Staff(StaffRole::Director, AccountStatus::Locked);

    hu001Authenticate('admin')
        ->assertSee('Correo o contraseña incorrectos.')
        ->assertDontSee('no está activa');

    $this->assertGuest();
});
