<?php

declare(strict_types=1);

use App\Enums\Permission;
use App\Enums\StaffRole;

it('define los siete roles con sus nombres técnicos', function () {
    expect(array_map(fn (StaffRole $role): string => $role->value, StaffRole::cases()))->toBe([
        'director',
        'academic_secretary',
        'pedagogical_coordinator',
        'it_support',
        'information_office',
        'teacher',
        'student',
    ]);
});

it('muestra la etiqueta en español de cada rol', function (StaffRole $role, string $label) {
    expect($role->label())->toBe($label);
})->with([
    [StaffRole::Director, 'Dirección'],
    [StaffRole::AcademicSecretary, 'Secretaría académica'],
    [StaffRole::PedagogicalCoordinator, 'Coordinación pedagógica'],
    [StaffRole::ItSupport, 'Soporte TI'],
    [StaffRole::InformationOffice, 'Oficina de información'],
    [StaffRole::Teacher, 'Docente'],
    [StaffRole::Student, 'Estudiante'],
]);

it('distingue los roles administrativos', function () {
    expect(StaffRole::administrative())->toBe([
        StaffRole::Director,
        StaffRole::AcademicSecretary,
        StaffRole::PedagogicalCoordinator,
        StaffRole::ItSupport,
        StaffRole::InformationOffice,
    ])
        ->and(StaffRole::Teacher->isAdministrative())->toBeFalse()
        ->and(StaffRole::Student->isAdministrative())->toBeFalse();
});

it('prioriza cualquier rol administrativo sobre Docente', function () {
    foreach (StaffRole::administrative() as $role) {
        expect($role->priority())->toBeGreaterThan(StaffRole::Teacher->priority());
    }

    expect(StaffRole::Director->priority())->toBeGreaterThan(StaffRole::AcademicSecretary->priority())
        ->and(StaffRole::Teacher->priority())->toBeGreaterThan(StaffRole::Student->priority());

    $priorities = array_map(fn (StaffRole $role): int => $role->priority(), StaffRole::cases());
    expect(array_unique($priorities))->toHaveCount(count($priorities));
});

it('tiene etiqueta en español para cada permiso', function (Permission $permission) {
    expect($permission->label())->not->toBe('permissions.'.$permission->value);
})->with(Permission::cases());
