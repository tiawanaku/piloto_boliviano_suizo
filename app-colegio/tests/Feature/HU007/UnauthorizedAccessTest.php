<?php

declare(strict_types=1);

use App\Enums\AuditEventType;
use App\Enums\StaffRole;
use App\Models\AuditEvent;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;

it('Acceso no autorizado por URL: un Docente que abre el panel administrativo ve el 403 en español y queda registrado', function () {
    $user = actingAsStaff(StaffRole::Teacher);

    $this->withServerVariables(['REMOTE_ADDR' => '192.0.2.10'])
        ->get('/admin?token=valor-que-no-debe-guardarse')
        ->assertForbidden()
        ->assertSee('No tienes permiso para ver esta página')
        ->assertSee('Ir a mi panel')
        ->assertSee(url('/docente'), escape: false);

    $event = AuditEvent::query()->sole();

    expect($event->event_type)->toBe(AuditEventType::AccessDenied)
        ->and($event->result)->toBe(AuditEvent::RESULT_DENIED)
        ->and($event->actor_id)->toBe($user->id)
        ->and($event->email_attempted)->toBe($user->email)
        ->and($event->ip_address)->toBe('192.0.2.10')
        ->and($event->context)->toMatchArray(['method' => 'GET', 'path' => '/admin', 'panel' => 'admin'])
        ->and(json_encode($event->context))->not->toContain('valor-que-no-debe-guardarse');
});

it('registra también el 403 de un administrativo que abre el panel docente', function () {
    actingAsStaff(StaffRole::AcademicSecretary);

    $this->get('/docente')
        ->assertForbidden()
        ->assertSee('No tienes permiso para ver esta página')
        ->assertSee(url('/admin'), escape: false);

    expect(AuditEvent::query()->sole()->context)->toMatchArray(['path' => '/docente', 'panel' => 'docente']);
});

it('registra el 403 de una autorización denegada por Gate o Policy', function () {
    Gate::define('hu007-prueba', fn (): bool => false);
    Route::middleware('web')->get('/hu007-prueba', fn () => Gate::authorize('hu007-prueba'));
    actingAsStaff(StaffRole::InformationOffice);

    $this->get('/hu007-prueba')
        ->assertForbidden()
        ->assertSee('No tienes permiso para ver esta página');

    expect(AuditEvent::query()->sole()->context)->toMatchArray(['path' => '/hu007-prueba']);
});

it('no registra nada cuando el rol sí tiene acceso', function () {
    actingAsStaff(StaffRole::Teacher);

    $this->get('/docente')->assertOk();

    expect(AuditEvent::query()->where('event_type', AuditEventType::AccessDenied)->exists())->toBeFalse();
});

it('no registra acceso denegado por otros errores (404)', function () {
    actingAsStaff(StaffRole::Teacher);

    $this->get('/no-existe')->assertNotFound();

    expect(AuditEvent::query()->exists())->toBeFalse();
});
