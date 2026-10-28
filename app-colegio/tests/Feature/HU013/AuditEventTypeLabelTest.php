<?php

declare(strict_types=1);

use App\Enums\AuditEventType;
use App\Models\AuditEvent;

it('traduce al español la etiqueta del tipo de evento :dataset', function (AuditEventType $type) {
    $label = $type->label();

    expect($label)->not->toBe('audit.event_type.'.$type->translationKey())
        ->and($label)->not->toBe('audit.event_type.'.$type->value)
        ->and($label)->not->toStartWith('audit.')
        ->and($label)->not->toBeEmpty();
})->with(fn (): array => collect(AuditEventType::cases())
    ->mapWithKeys(fn (AuditEventType $type): array => [$type->value => [$type]])
    ->all());

it('todas las etiquetas de tipo de evento son distintas entre sí', function () {
    $labels = array_map(fn (AuditEventType $type): string => $type->label(), AuditEventType::cases());

    expect(array_unique($labels))->toHaveCount(count(AuditEventType::cases()));
});

it('traduce al español los resultados :dataset', function (string $result) {
    expect(__('audit.result.'.$result))->not->toStartWith('audit.');
})->with([AuditEvent::RESULT_SUCCESS, AuditEvent::RESULT_FAILURE, AuditEvent::RESULT_DENIED]);
