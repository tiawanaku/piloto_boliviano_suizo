<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Enums\AccountStatus;
use App\Enums\StaffRole;
use App\Models\User;
use App\Rules\InstitutionalEmail;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

/**
 * Crea una cuenta activa del personal con contraseña temporal (T-1-10).
 * Provisional hasta HU-009 (invitación por correo). La contraseña se muestra
 * una sola vez en la consola y no se guarda en logs.
 */
class CreateStaffAccount extends Command
{
    /**
     * @var string
     */
    protected $signature = 'colegio:crear-cuenta
        {correo : Correo institucional ficticio (dominio configurado)}
        {--rol=* : Rol técnico (director, academic_secretary, pedagogical_coordinator, it_support, information_office, teacher)}
        {--nombre= : Nombre para mostrar (por defecto, la parte local del correo)}';

    /**
     * @var string
     */
    protected $description = 'Crea una cuenta del personal con contraseña temporal (provisional hasta la invitación por correo)';

    public function handle(): int
    {
        $email = Str::lower(trim((string) $this->argument('correo')));
        /** @var list<string> $roles */
        $roles = array_values(array_unique((array) $this->option('rol')));

        $validator = Validator::make(
            ['correo' => $email, 'rol' => $roles],
            [
                'correo' => ['required', 'email', new InstitutionalEmail, Rule::unique('users', 'email')],
                'rol' => ['required', 'array', 'min:1'],
                'rol.*' => [Rule::enum(StaffRole::class)->except([StaffRole::Student])],
            ],
            [
                'rol.required' => __('staff_account.role_required'),
                'rol.*' => __('staff_account.role_invalid'),
            ],
            ['correo' => __('staff_account.email_attribute')],
        );

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return self::FAILURE;
        }

        $password = Str::password(16, symbols: false);
        $nombre = $this->option('nombre');

        $user = DB::transaction(function () use ($email, $roles, $password, $nombre): User {
            RolesAndPermissionsSeeder::ensureSeeded();

            $user = new User([
                'name' => is_string($nombre) && $nombre !== '' ? $nombre : Str::before($email, '@'),
                'email' => $email,
                'password' => $password,
                'status' => AccountStatus::Active,
            ]);
            $user->markPasswordAsTemporary()->save();
            $user->assignRole($roles);

            return $user;
        });

        $this->info(__('staff_account.created', ['email' => $user->email]));
        $this->line(__('staff_account.roles', [
            'roles' => implode(', ', array_map(fn (StaffRole $role): string => $role->label(), $user->staffRoles())),
        ]));
        $this->warn(__('staff_account.password_once', ['password' => $password]));
        $this->line(__('staff_account.expires', [
            'date' => $user->temporary_password_expires_at?->format('d/m/Y H:i'),
        ]));

        return self::SUCCESS;
    }
}
