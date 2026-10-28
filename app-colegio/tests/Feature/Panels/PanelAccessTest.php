<?php

declare(strict_types=1);

use App\Models\User;

it('muestra la página de login del panel :dataset', function (string $panel) {
    $this->get("/{$panel}/login")->assertOk();
})->with(['admin', 'docente']);

it('redirige al login a un invitado que pide el panel :dataset', function (string $panel) {
    $this->get("/{$panel}")->assertRedirect("/{$panel}/login");
})->with(['admin', 'docente']);

it('permite entrar al panel :dataset a una cuenta activa', function (string $panel) {
    $this->actingAs(User::factory()->create())
        ->get("/{$panel}")
        ->assertOk();
})->with(['admin', 'docente']);

it('responde 403 a una cuenta :dataset en el panel admin', function (string $estado) {
    $user = User::factory()->{$estado}()->create();

    $this->actingAs($user)->get('/admin')->assertForbidden();
})->with(['pending', 'locked', 'deactivated']);

it('responde 403 a una cuenta pendiente en el panel docente', function () {
    $this->actingAs(User::factory()->pending()->create())
        ->get('/docente')
        ->assertForbidden();
});
