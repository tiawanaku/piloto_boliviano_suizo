<?php

declare(strict_types=1);

use App\Enums\AccountStatus;
use App\Enums\StaffRole;
use App\Models\User;

it('ofrece estados de cuenta en la factory', function (string $state, AccountStatus $status) {
    expect(User::factory()->{$state}()->create()->status)->toBe($status);
})->with([
    ['active', AccountStatus::Active],
    ['pending', AccountStatus::Pending],
    ['locked', AccountStatus::Locked],
    ['deactivated', AccountStatus::Deactivated],
]);

it('crea cuentas con contraseña temporal pendiente de cambio', function () {
    $user = User::factory()->withTemporaryPassword()->create();

    expect($user->must_change_password)->toBeTrue()
        ->and($user->temporary_password_expires_at?->isFuture())->toBeTrue();
});

it('asigna roles con withRoles y autentica con actingAsStaff', function () {
    $user = actingAsStaff(StaffRole::Director, StaffRole::Teacher);

    expect(auth()->id())->toBe($user->id)
        ->and($user->status)->toBe(AccountStatus::Active)
        ->and($user->staffRoles())->toBe([StaffRole::Director, StaffRole::Teacher]);
});
