<?php

declare(strict_types=1);

use App\Enums\StaffRole;
use App\Models\User;
use Filament\Auth\Http\Responses\Contracts\LoginResponse;
use Filament\Facades\Filament;
use Livewire\Features\SupportTesting\Testable;
use Livewire\Livewire;

const HU007_CONTRASENA = 'Clave-Ficticia-Hu007-4x8z';

/**
 * Login real del panel indicado (página registrada en el panel).
 */
function hu007Login(string $panel, User $user): Testable
{
    Filament::setCurrentPanel($panel);

    /** @var class-string $page */
    $page = Filament::getPanel($panel)->getLoginRouteAction();

    return Livewire::test($page)
        ->fillForm(['email' => $user->email, 'password' => HU007_CONTRASENA])
        ->call('authenticate');
}

it('Docente: con solo el rol Docente llega al panel docente', function () {
    $user = User::factory()->active()->withRoles(StaffRole::Teacher)->create(['password' => HU007_CONTRASENA]);

    hu007Login('docente', $user)->assertRedirect(url('/docente'));
});

it('Administrativo: con el rol Secretaría académica llega al panel administrativo', function () {
    $user = User::factory()->active()->withRoles(StaffRole::AcademicSecretary)->create(['password' => HU007_CONTRASENA]);

    hu007Login('admin', $user)->assertRedirect(url('/admin'));
});

/*
 * Que la página de login de un panel acepte a quien solo tiene acceso al otro
 * es de T-1-03 (Dev 1). La respuesta de login ya redirige al panel principal
 * sin importar el panel actual.
 */
it('la respuesta de login lleva al panel principal aunque se use el login del otro panel', function (StaffRole $role, string $loginPanel, string $expected) {
    $this->actingAs(User::factory()->active()->withRoles($role)->create());
    Filament::setCurrentPanel($loginPanel);

    $response = app(LoginResponse::class)->toResponse(request());

    expect($response->getTargetUrl())->toBe(url($expected));
})->with([
    'Docente por /admin' => [StaffRole::Teacher, 'admin', '/docente'],
    'Secretaría por /docente' => [StaffRole::AcademicSecretary, 'docente', '/admin'],
]);

it('Varios roles: con Docente y Coordinación pedagógica entra al panel del rol principal', function () {
    $porPrioridad = User::factory()->active()
        ->withRoles(StaffRole::Teacher, StaffRole::PedagogicalCoordinator)
        ->create(['password' => HU007_CONTRASENA]);
    $conPrincipal = User::factory()->active()
        ->withRoles(StaffRole::Teacher, StaffRole::PedagogicalCoordinator)
        ->withPrimaryRole(StaffRole::Teacher)
        ->create(['password' => HU007_CONTRASENA]);

    hu007Login('admin', $porPrioridad)->assertRedirect(url('/admin'));
    auth()->logout();
    hu007Login('admin', $conPrincipal)->assertRedirect(url('/docente'));
});

it('no reenvía a una URL previa de un panel sin acceso', function () {
    $user = User::factory()->active()->withRoles(StaffRole::Teacher)->create(['password' => HU007_CONTRASENA]);
    session()->put('url.intended', url('/admin'));

    hu007Login('docente', $user)->assertRedirect(url('/docente'));
});
