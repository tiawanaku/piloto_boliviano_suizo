<?php

declare(strict_types=1);

use App\Enums\StaffRole;
use App\Models\User;

it('Varios roles: con Docente y Coordinación pedagógica ve "Cambiar a panel docente" y abre el panel docente sin nuevo login', function () {
    actingAsStaff(StaffRole::Teacher, StaffRole::PedagogicalCoordinator);

    $this->get('/admin')
        ->assertOk()
        ->assertSee('Cambiar a panel docente')
        ->assertSee(url('/docente'), escape: false);

    $this->get('/docente')
        ->assertOk()
        ->assertSee('Cambiar a panel administrativo')
        ->assertSee(url('/admin'), escape: false);

    $this->assertAuthenticated();
});

it('no muestra el cambio de panel a quien tiene un solo rol: :dataset', function (StaffRole $role, string $panel, string $hidden) {
    actingAsStaff($role);

    $this->get("/{$panel}")
        ->assertOk()
        ->assertDontSee($hidden);
})->with([
    'Docente' => [StaffRole::Teacher, 'docente', 'Cambiar a panel administrativo'],
    'Secretaría académica' => [StaffRole::AcademicSecretary, 'admin', 'Cambiar a panel docente'],
]);

it('Docente: el panel docente está vacío y lo explica', function () {
    actingAsStaff(StaffRole::Teacher);

    $this->get('/docente')
        ->assertOk()
        ->assertSee('Mis aulas')
        ->assertSee('Tus aulas aparecerán aquí cuando coordinación te asigne materias.');
});

it('Administrativo: el panel administrativo no muestra el mensaje del panel docente', function () {
    actingAsStaff(StaffRole::AcademicSecretary);

    $this->get('/admin')
        ->assertOk()
        ->assertDontSee('Tus aulas aparecerán aquí');
});

it('ocultar el ítem no reemplaza la verificación: el panel destino sigue respondiendo 403', function () {
    $user = User::factory()->active()->withRoles(StaffRole::Teacher)->create();

    $this->actingAs($user)->get('/admin')->assertForbidden();
});
