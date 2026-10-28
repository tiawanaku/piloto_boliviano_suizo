<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\StaffRole;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Base de demostración del piloto: solo datos ficticios.
     */
    public function run(): void
    {
        $this->call(RolesAndPermissionsSeeder::class);

        $dominio = config()->string('colegio.dominio_institucional');

        // Contraseña ficticia de demostración ("password"), igual a la de la factory.
        // Cuenta con dos roles para mostrar el cambio de panel (HU-007).
        User::factory()->active()
            ->withRoles(StaffRole::PedagogicalCoordinator, StaffRole::Teacher)
            ->create([
                'name' => 'Cuenta de demostración',
                'email' => "demo@{$dominio}",
            ]);

        // Una cuenta por rol del personal para recorrer los paneles.
        foreach (StaffRole::cases() as $role) {
            if ($role->panelId() === null) {
                continue;
            }

            User::factory()->active()->withRoles($role)->create([
                'name' => "{$role->label()} (demostración)",
                'email' => str_replace('_', '.', $role->value)."@{$dominio}",
            ]);
        }
    }
}
