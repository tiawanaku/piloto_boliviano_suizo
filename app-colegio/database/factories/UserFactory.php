<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\AccountStatus;
use App\Enums\StaffRole;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Cuentas ficticias del personal (@colegio-piloto.test).
 *
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $dominio = config()->string('colegio.dominio_institucional');

        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->userName().'.'.Str::lower(Str::random(4)).'@'.$dominio,
            'status' => AccountStatus::Active,
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    public function active(): static
    {
        return $this->state(fn (array $attributes) => ['status' => AccountStatus::Active]);
    }

    public function pending(): static
    {
        return $this->state(fn (array $attributes) => ['status' => AccountStatus::Pending]);
    }

    public function locked(): static
    {
        return $this->state(fn (array $attributes) => ['status' => AccountStatus::Locked]);
    }

    public function deactivated(): static
    {
        return $this->state(fn (array $attributes) => ['status' => AccountStatus::Deactivated]);
    }

    /**
     * Contraseña temporal pendiente de cambio que vence según
     * colegio.contrasena_temporal_horas (HU-006).
     */
    public function withTemporaryPassword(): static
    {
        return $this->afterMaking(fn (User $user) => $user->markPasswordAsTemporary());
    }

    /**
     * Asigna roles de la matriz RBAC (la carga si aún no existe).
     */
    public function withRoles(StaffRole ...$roles): static
    {
        return $this->afterCreating(function (User $user) use ($roles): void {
            RolesAndPermissionsSeeder::ensureSeeded();

            $user->assignRole(array_map(fn (StaffRole $role): string => $role->value, $roles));
        });
    }

    /**
     * Rol principal explícito (HU-007).
     */
    public function withPrimaryRole(StaffRole $role): static
    {
        return $this->state(fn (array $attributes) => ['primary_role' => $role]);
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
