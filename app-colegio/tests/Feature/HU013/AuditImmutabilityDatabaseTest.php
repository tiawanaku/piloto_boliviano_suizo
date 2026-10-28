<?php

declare(strict_types=1);

use App\Enums\AuditEventType;
use App\Models\AuditEvent;
use App\Services\AuditLogger;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

/*
| HU-013 · Escenario "Inmutabilidad" a nivel de base de datos (T-1-16).
| Las consultas directas saltan el modelo; el trigger debe rechazarlas igual.
*/

beforeEach(function () {
    $this->event = app(AuditLogger::class)->record(
        AuditEventType::LoginFailed,
        email: 'alguien@colegio-piloto.test',
    );
});

it('Inmutabilidad: la base de datos rechaza UPDATE sobre audit_events', function () {
    expect(fn () => DB::table('audit_events')->where('id', $this->event->id)->update(['result' => 'success']))
        ->toThrow(QueryException::class, 'solo insercion');

    expect(DB::table('audit_events')->where('id', $this->event->id)->value('result'))
        ->toBe(AuditEvent::RESULT_FAILURE);
});

it('Inmutabilidad: la base de datos rechaza DELETE sobre audit_events', function () {
    expect(fn () => DB::table('audit_events')->where('id', $this->event->id)->delete())
        ->toThrow(QueryException::class, 'solo insercion');

    expect(DB::table('audit_events')->count())->toBe(1);
});

it('Inmutabilidad: las operaciones masivas de Eloquent también fallan', function () {
    expect(fn () => AuditEvent::query()->update(['email_attempted' => 'otro@colegio-piloto.test']))
        ->toThrow(QueryException::class);

    expect(fn () => AuditEvent::query()->delete())->toThrow(QueryException::class);

    expect(AuditEvent::query()->count())->toBe(1);
});

it('Inmutabilidad: insertar nuevos eventos sigue permitido', function () {
    app(AuditLogger::class)->record(AuditEventType::Logout);

    expect(AuditEvent::query()->count())->toBe(2);
});
