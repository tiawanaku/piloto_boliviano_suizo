<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\AccountStatus;
use App\Models\User;
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
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
