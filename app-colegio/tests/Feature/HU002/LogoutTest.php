<?php

declare(strict_types=1);

use App\Enums\StaffRole;
use App\Models\User;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

/*
 * HU-002 · Cerrar sesión, inactividad y "atrás" (T-1-04).
 * Usa sesiones reales en la tabla sessions (driver database, como en la
 * demostración) en lugar de actingAs(), para probar la invalidación y la
 * expiración en el servidor.
 */

beforeEach(function () {
    config(['session.driver' => 'database']);
    app('session')->forgetDrivers();
    app()->forgetInstance('session.store');
});

/**
 * Crea una sesión autenticada en la tabla sessions y devuelve su id.
 */
function hu002SessionFor(User $user): string
{
    $store = new Store(
        config()->string('session.cookie'),
        app('session')->driver()->getHandler(),
        serialization: 'json',
    );
    $store->start();
    $store->put(Auth::guard('web')->getName(), $user->getAuthIdentifier());
    $store->save();

    return $store->getId();
}

/**
 * Simula una petición nueva del navegador: sin usuario ni sesión en memoria
 * de la petición anterior (en producción cada petición es un proceso nuevo).
 */
function hu002FreshRequest(string $sessionId): TestCase
{
    Auth::forgetGuards();
    app('session.store')->flush();

    return test()->withCookie(config()->string('session.cookie'), $sessionId);
}

function hu002Get(string $sessionId, string $uri): TestResponse
{
    return hu002FreshRequest($sessionId)->get($uri);
}

function hu002AssertNoStore(TestResponse $response): void
{
    $cacheControl = (string) $response->headers->get('Cache-Control');

    expect($cacheControl)->toContain('no-store')->toContain('private');
}

it('toma la inactividad de colegio.sesion_inactividad_minutos (30 min) con cookies seguras', function () {
    expect(config('session.lifetime'))->toBe(30)
        ->and(config('session.lifetime'))->toBe(config('colegio.sesion_inactividad_minutos'))
        ->and(config('session.http_only'))->toBeTrue()
        ->and(config('session.same_site'))->toBe('lax')
        ->and(config('session.expire_on_close'))->toBeFalse();
});

it('Cerrar sesión manualmente: invalida la sesión en el servidor y vuelve al login', function () {
    $user = User::factory()->active()->withRoles(StaffRole::Director)->create();
    $sessionId = hu002SessionFor($user);

    hu002AssertNoStore(hu002Get($sessionId, '/admin')->assertOk());

    hu002FreshRequest($sessionId)
        ->post('/admin/logout')
        ->assertRedirect('/admin/login');

    expect(DB::table('sessions')->where('id', $sessionId)->exists())->toBeFalse();
    $this->assertGuest();
});

it('Cerrar sesión manualmente: "atrás" no muestra información protegida', function () {
    $user = User::factory()->active()->withRoles(StaffRole::Director)->create(['name' => 'Ana Pérez Ficticia']);
    $sessionId = hu002SessionFor($user);

    hu002Get($sessionId, '/admin')->assertOk()->assertSee('Ana Pérez Ficticia');

    hu002FreshRequest($sessionId)->post('/admin/logout');

    // El navegador no guardó la página (no-store) y al volver a pedirla con la
    // cookie antigua el servidor ya no la reconoce.
    hu002Get($sessionId, '/admin')
        ->assertRedirect('/admin/login')
        ->assertDontSee('Ana Pérez Ficticia');
});

it('Expiración por inactividad: a los 30 minutos sin actividad pide iniciar sesión', function () {
    $user = User::factory()->active()->withRoles(StaffRole::Director)->create();
    $sessionId = hu002SessionFor($user);

    $this->travel(29)->minutes();
    hu002Get($sessionId, '/admin')->assertOk();

    $this->travel(31)->minutes();
    hu002Get($sessionId, '/admin')->assertRedirect('/admin/login');
});

it('la cabecera no-store también se envía en el panel docente', function () {
    $user = User::factory()->active()->withRoles(StaffRole::Teacher)->create();

    hu002AssertNoStore(hu002Get(hu002SessionFor($user), '/docente')->assertOk());
});
