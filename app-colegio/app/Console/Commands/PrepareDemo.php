<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

/**
 * Regenera la base de demostración del piloto con datos ficticios (T-0-11).
 *
 * Ejecuta `migrate:fresh --seed` (DatabaseSeeder). Los seeders de cada sprint
 * se registran en DatabaseSeeder y quedan incluidos automáticamente.
 */
class PrepareDemo extends Command
{
    /**
     * Contraseña ficticia de las cuentas de demostración (la de UserFactory).
     */
    public const DEMO_PASSWORD = 'password';

    /**
     * @var string
     */
    protected $signature = 'colegio:demo
        {--force : No pedir confirmación antes de borrar la base de datos}';

    /**
     * @var string
     */
    protected $description = 'Regenera la base de demostración del piloto con datos ficticios';

    public function handle(): int
    {
        if ($this->laravel->environment('production')) {
            $this->error(__('demo.production'));

            return self::FAILURE;
        }

        if (! $this->option('force') && ! $this->confirm(__('demo.confirm'), true)) {
            $this->warn(__('demo.cancelled'));

            return self::FAILURE;
        }

        $this->ensureSqliteDatabaseExists();

        $this->info(__('demo.preparing'));

        $exitCode = $this->call('migrate:fresh', ['--seed' => true, '--force' => true]);

        if ($exitCode !== self::SUCCESS) {
            $this->error(__('demo.failed'));

            return self::FAILURE;
        }

        $this->showSummary();

        return self::SUCCESS;
    }

    /**
     * En SQLite, crea el archivo de la base si aún no existe (primer arranque).
     */
    private function ensureSqliteDatabaseExists(): void
    {
        $connection = config()->string('database.default');

        if (config("database.connections.{$connection}.driver") !== 'sqlite') {
            return;
        }

        $path = config("database.connections.{$connection}.database");

        if (! is_string($path) || $path === '' || $path === ':memory:' || str_contains($path, 'mode=memory')) {
            return;
        }

        if (! File::exists($path)) {
            File::ensureDirectoryExists(dirname($path));
            File::put($path, '');
        }
    }

    private function showSummary(): void
    {
        $url = rtrim(config()->string('app.url'), '/');

        $this->newLine();
        $this->info(__('demo.ready'));
        $this->newLine();

        $this->line(__('demo.urls'));
        $this->line('  '.__('demo.panel_admin').": {$url}/admin");
        $this->line('  '.__('demo.panel_docente').": {$url}/docente");
        $this->newLine();

        $this->line(__('demo.accounts'));
        $this->table(
            [__('demo.columns.name'), __('demo.columns.email'), __('demo.columns.status')],
            User::query()
                ->orderBy('email')
                ->get(['name', 'email', 'status'])
                ->map(fn (User $user): array => [
                    $user->name,
                    $user->email,
                    $user->status->label(),
                ])
                ->all(),
        );

        $this->line(__('demo.password', ['password' => self::DEMO_PASSWORD]));
        $this->line(__('demo.mail'));
    }
}
