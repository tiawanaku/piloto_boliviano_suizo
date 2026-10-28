<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\AccountStatus;
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
        // Contraseña ficticia de demostración ("password"), igual a la de la factory.
        User::factory()->create([
            'name' => 'Cuenta de demostración',
            'email' => 'demo@'.config()->string('colegio.dominio_institucional'),
            'status' => AccountStatus::Active,
        ]);
    }
}
