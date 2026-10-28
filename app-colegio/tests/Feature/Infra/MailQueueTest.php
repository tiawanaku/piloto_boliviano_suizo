<?php

declare(strict_types=1);

use App\Notifications\TestMailNotification;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\Notification;

it('envía en cola el correo de prueba al correo ficticio indicado', function () {
    Notification::fake();

    $this->artisan('colegio:correo-prueba', ['correo' => 'prueba@colegio-piloto.test'])
        ->assertSuccessful();

    Notification::assertSentOnDemand(
        TestMailNotification::class,
        fn (TestMailNotification $notification, array $channels, AnonymousNotifiable $notifiable): bool => $notifiable->routes['mail'] === 'prueba@colegio-piloto.test',
    );

    expect(new TestMailNotification)->toBeInstanceOf(ShouldQueue::class);
});

it('usa un asunto y un saludo en español', function () {
    $mail = (new TestMailNotification)->toMail(new AnonymousNotifiable);

    expect($mail->subject)->toBe('Correo de prueba del Colegio Virtual')
        ->and($mail->greeting)->toBe('¡Hola!');
});

it('muestra el pie del piloto en la plantilla de correo', function () {
    $html = (string) (new TestMailNotification)->toMail(new AnonymousNotifiable)->render();

    expect($html)->toContain('Colegio Virtual — piloto')
        ->not->toContain('All rights reserved');
});

it('rechaza el correo :dataset fuera del dominio del piloto', function (string $email) {
    Notification::fake();

    $this->artisan('colegio:correo-prueba', ['correo' => $email])
        ->expectsOutputToContain('Solo se permiten correos ficticios del dominio @colegio-piloto.test.')
        ->assertFailed();

    Notification::assertNothingSent();
})->with([
    'externo' => 'persona@gmail.com',
    'con subdominio parecido' => 'persona@colegio-piloto.test.com',
    'inválido' => 'no-es-un-correo',
]);

it('deja el correo de prueba en la cola database cuando la cola no es síncrona', function () {
    config(['queue.default' => 'database']);

    $this->artisan('colegio:correo-prueba', ['correo' => 'prueba@colegio-piloto.test'])
        ->assertSuccessful();

    $this->assertDatabaseCount('jobs', 1);
});

it('programa auth:clear-resets a diario', function () {
    $events = collect(app(Schedule::class)->events())
        ->filter(fn ($event): bool => str_contains((string) $event->command, 'auth:clear-resets'));

    expect($events)->toHaveCount(1)
        ->and($events->first()->expression)->toBe('0 0 * * *');
});
