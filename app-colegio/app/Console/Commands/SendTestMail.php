<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Notifications\TestMailNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

/**
 * Pone en cola un correo de prueba (T-0-10). Con MAIL_MAILER=log queda en
 * storage/logs/laravel.log; con Mailpit se ve en su bandeja web.
 */
class SendTestMail extends Command
{
    /**
     * @var string
     */
    protected $signature = 'colegio:correo-prueba {correo : Correo ficticio del dominio institucional del piloto}';

    /**
     * @var string
     */
    protected $description = 'Envía (en cola) un correo de prueba a una dirección ficticia del piloto';

    public function handle(): int
    {
        $email = Str::lower(trim((string) $this->argument('correo')));
        $domain = config()->string('colegio.dominio_institucional');

        if (! filter_var($email, FILTER_VALIDATE_EMAIL) || ! Str::endsWith($email, '@'.$domain)) {
            $this->error(__('mail.test.command.invalid_email', ['domain' => $domain]));

            return self::FAILURE;
        }

        Notification::route('mail', $email)->notify(new TestMailNotification);

        $this->info(__('mail.test.command.queued', ['email' => $email]));

        return self::SUCCESS;
    }
}
