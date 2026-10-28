<?php

declare(strict_types=1);

use App\Enums\StaffRole;
use App\Models\User;

dataset('rol × panel', [
    'Dirección → admin' => [StaffRole::Director, 'admin', true],
    'Dirección → docente' => [StaffRole::Director, 'docente', false],
    'Secretaría académica → admin' => [StaffRole::AcademicSecretary, 'admin', true],
    'Secretaría académica → docente' => [StaffRole::AcademicSecretary, 'docente', false],
    'Coordinación pedagógica → admin' => [StaffRole::PedagogicalCoordinator, 'admin', true],
    'Coordinación pedagógica → docente' => [StaffRole::PedagogicalCoordinator, 'docente', false],
    'Soporte TI → admin' => [StaffRole::ItSupport, 'admin', true],
    'Soporte TI → docente' => [StaffRole::ItSupport, 'docente', false],
    'Oficina de información → admin' => [StaffRole::InformationOffice, 'admin', true],
    'Oficina de información → docente' => [StaffRole::InformationOffice, 'docente', false],
    'Docente → admin' => [StaffRole::Teacher, 'admin', false],
    'Docente → docente' => [StaffRole::Teacher, 'docente', true],
    'Estudiante → admin' => [StaffRole::Student, 'admin', false],
    'Estudiante → docente' => [StaffRole::Student, 'docente', false],
]);

it('autoriza en el servidor cada rol en cada panel: :dataset', function (StaffRole $role, string $panel, bool $allowed) {
    actingAsStaff($role);

    $response = $this->get("/{$panel}");

    $allowed ? $response->assertOk() : $response->assertForbidden();
})->with('rol × panel');

it('responde 403 en ambos paneles a una cuenta :dataset aunque tenga roles', function (string $estado) {
    $user = User::factory()->{$estado}()
        ->withRoles(StaffRole::Director, StaffRole::Teacher)
        ->create();

    $this->actingAs($user)->get('/admin')->assertForbidden();
    $this->actingAs($user)->get('/docente')->assertForbidden();
})->with(['pending', 'locked', 'deactivated']);

it('responde 403 en ambos paneles a una cuenta activa sin roles', function () {
    $user = User::factory()->active()->create();

    $this->actingAs($user)->get('/admin')->assertForbidden();
    $this->actingAs($user)->get('/docente')->assertForbidden();
});

it('da acceso a los dos paneles a quien es Docente y Coordinación pedagógica', function () {
    actingAsStaff(StaffRole::Teacher, StaffRole::PedagogicalCoordinator);

    $this->get('/admin')->assertOk();
    $this->get('/docente')->assertOk();
});

it('elige el rol principal por prioridad cuando no hay uno guardado', function (array $roles, StaffRole $expected, string $panel) {
    $user = User::factory()->active()->withRoles(...$roles)->create();

    expect($user->primaryRole())->toBe($expected)
        ->and($user->primaryPanelId())->toBe($panel);
})->with([
    'solo Docente' => [[StaffRole::Teacher], StaffRole::Teacher, 'docente'],
    'Docente y Coordinación' => [[StaffRole::Teacher, StaffRole::PedagogicalCoordinator], StaffRole::PedagogicalCoordinator, 'admin'],
    'Oficina y Dirección' => [[StaffRole::InformationOffice, StaffRole::Director], StaffRole::Director, 'admin'],
]);

it('respeta el rol principal guardado si el usuario aún lo tiene', function () {
    $user = User::factory()->active()
        ->withRoles(StaffRole::Teacher, StaffRole::PedagogicalCoordinator)
        ->withPrimaryRole(StaffRole::Teacher)
        ->create();

    expect($user->primaryRole())->toBe(StaffRole::Teacher)
        ->and($user->primaryPanelId())->toBe('docente')
        ->and($user->primaryPanelUrl())->toEndWith('/docente');
});

it('ignora un rol principal que el usuario ya no tiene', function () {
    $user = User::factory()->active()
        ->withRoles(StaffRole::Teacher)
        ->withPrimaryRole(StaffRole::Director)
        ->create();

    expect($user->primaryPanelId())->toBe('docente');
});

it('no tiene panel principal sin roles de panel o con la cuenta inactiva', function () {
    $student = User::factory()->active()->withRoles(StaffRole::Student)->create();
    $deactivated = User::factory()->deactivated()->withRoles(StaffRole::Director)->create();

    expect($student->primaryPanelId())->toBeNull()
        ->and($student->primaryPanelUrl())->toBeNull()
        ->and($deactivated->primaryPanelId())->toBeNull();
});
