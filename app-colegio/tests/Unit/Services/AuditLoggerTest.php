<?php

declare(strict_types=1);

use App\Enums\AuditEventType;
use App\Models\AuditEvent;
use App\Models\User;
use App\Services\AuditLogger;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

// AuditLogger escribe en la base: necesita la aplicación (tests/Pest.php solo enlaza Feature y Unit/Models).
uses(TestCase::class, RefreshDatabase::class);

it('registra un evento con actor, sujeto, contexto, IP y navegador', function () {
    $actor = User::factory()->create();
    $subject = User::factory()->create();

    $this->app['request']->server->set('REMOTE_ADDR', '203.0.113.7');
    $this->app['request']->headers->set('User-Agent', 'NavegadorDePrueba/1.0');

    $event = app(AuditLogger::class)->record(
        AuditEventType::AccessDenied,
        actor: $actor,
        subject: $subject,
        email: '  Persona@Colegio-Piloto.test ',
        context: ['url' => '/admin', 'detalle' => ['panel' => 'admin']],
    );

    $stored = AuditEvent::query()->findOrFail($event->id);

    expect($stored->event_type)->toBe(AuditEventType::AccessDenied)
        ->and($stored->result)->toBe(AuditEvent::RESULT_DENIED)
        ->and($stored->actor_id)->toBe($actor->id)
        ->and($stored->subject_type)->toBe($subject->getMorphClass())
        ->and($stored->subject_id)->toBe($subject->id)
        ->and($stored->email_attempted)->toBe('persona@colegio-piloto.test')
        ->and($stored->ip_address)->toBe('203.0.113.7')
        ->and($stored->user_agent)->toBe('NavegadorDePrueba/1.0')
        ->and($stored->context)->toBe(['url' => '/admin', 'detalle' => ['panel' => 'admin']])
        ->and($stored->occurred_at)->not->toBeNull()
        ->and($stored->actor?->is($actor))->toBeTrue();
});

it('usa el resultado por defecto del tipo de evento y permite indicar otro', function () {
    $logger = app(AuditLogger::class);

    expect($logger->record(AuditEventType::LoginSucceeded)->result)->toBe(AuditEvent::RESULT_SUCCESS)
        ->and($logger->record(AuditEventType::LoginFailed)->result)->toBe(AuditEvent::RESULT_FAILURE)
        ->and($logger->record(AuditEventType::AuditExported, result: AuditEvent::RESULT_FAILURE)->result)
        ->toBe(AuditEvent::RESULT_FAILURE);
});

it('nunca guarda claves sensibles del contexto, a ninguna profundidad', function () {
    $event = app(AuditLogger::class)->record(AuditEventType::LoginFailed, context: [
        'password' => 'Secreta-123',
        'password_confirmation' => 'Secreta-123',
        'currentPassword' => 'Secreta-123',
        'remember_token' => 'tok-abc',
        'api_token' => 'tok-def',
        'two_factor_secret' => 'JBSWY3DPEHPK3PXP',
        'code' => '123456',
        'mfa_code' => '654321',
        'recovery_codes' => ['aaaa-bbbb'],
        'X-CSRF-TOKEN' => 'csrf',
        'guard' => 'web',
        'datos' => ['email' => 'a@colegio-piloto.test', 'password' => 'Secreta-123', 'otp' => '111111'],
    ]);

    $raw = (string) AuditEvent::query()->toBase()->where('id', $event->id)->value('context');

    expect($event->fresh()?->context)->toBe([
        'guard' => 'web',
        'datos' => ['email' => 'a@colegio-piloto.test'],
    ])
        ->and($raw)->not->toContain('Secreta-123')
        ->not->toContain('tok-')
        ->not->toContain('JBSWY3DPEHPK3PXP')
        ->not->toContain('123456')
        ->not->toContain('654321')
        ->not->toContain('aaaa-bbbb')
        ->not->toContain('111111');
});

it('guarda contexto nulo cuando no hay datos adicionales', function () {
    expect(app(AuditLogger::class)->record(AuditEventType::Logout)->fresh()?->context)->toBeNull();
});

it('lanza una excepción al intentar update() en un evento', function () {
    $event = app(AuditLogger::class)->record(AuditEventType::LoginSucceeded);

    expect(fn () => $event->update(['result' => AuditEvent::RESULT_FAILURE]))
        ->toThrow(LogicException::class, __('audit.immutable'));

    expect($event->fresh()?->result)->toBe(AuditEvent::RESULT_SUCCESS);
});

it('lanza una excepción al intentar delete() en un evento', function () {
    $event = app(AuditLogger::class)->record(AuditEventType::LoginSucceeded);

    expect(fn () => $event->delete())->toThrow(LogicException::class, __('audit.immutable'));

    expect(AuditEvent::query()->whereKey($event->id)->exists())->toBeTrue();
});
