<?php

declare(strict_types=1);

use App\Enums\StaffRole;

/*
 * TEC-13 · Cabeceras de seguridad de los paneles (T-1-05).
 */

it('envía las cabeceras de seguridad en el login del panel :dataset', function (string $panel) {
    $response = $this->get("/{$panel}/login")->assertOk();

    $response->assertHeader('X-Frame-Options', 'DENY')
        ->assertHeader('X-Content-Type-Options', 'nosniff')
        ->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin')
        ->assertHeaderMissing('Strict-Transport-Security');

    $csp = (string) $response->headers->get('Content-Security-Policy-Report-Only');

    expect($csp)->toContain("default-src 'self'")
        ->toContain("frame-ancestors 'none'")
        ->toContain("'unsafe-eval'"); // Alpine/Livewire

    $response->assertHeaderMissing('Content-Security-Policy');
})->with(['admin', 'docente']);

it('envía HSTS solo en peticiones HTTPS', function () {
    $this->get('https://localhost/admin/login')
        ->assertHeader('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
});

it('envía las cabeceras también en páginas autenticadas y redirecciones', function () {
    $this->get('/admin')->assertRedirect()->assertHeader('X-Frame-Options', 'DENY');

    actingAsStaff(StaffRole::Director);

    $this->get('/admin')->assertOk()->assertHeader('X-Content-Type-Options', 'nosniff');
});
