<?php

declare(strict_types=1);

use App\Enums\AuditEventType;
use App\Models\AuditEvent;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\DB;
use Livewire\Features\SupportTesting\Testable;
use Livewire\Livewire;

/*
| HU-013 · Escenario "Registro de intento" (T-1-17).
| Se usa la página de login real de cada panel de Filament.
*/

const HU013_CONTRASENA = 'Clave-Unica-De-Prueba-9f3k';

/**
 * Prueba Livewire de la página de login del panel indicado.
 */
function hu013LoginPage(string $panel): Testable
{
    Filament::setCurrentPanel($panel);

    /** @var class-string $page */
    $page = Filament::getPanel($panel)->getLoginRouteAction();

    return Livewire::withHeaders(['User-Agent' => 'NavegadorDePrueba/2.0'])->test($page);
}

function hu013AssertPasswordNotStored(string $password): void
{
    foreach (DB::table('audit_events')->get() as $row) {
        foreach ((array) $row as $column => $value) {
            expect((string) $value)->not->toContain($password, "La contraseña aparece en la columna {$column}");
        }
    }
}

it('Registro de intento: un login correcto queda registrado sin la contraseña en el panel :dataset', function (string $panel) {
    $user = User::factory()->create(['password' => HU013_CONTRASENA]);

    hu013LoginPage($panel)
        ->fillForm(['email' => $user->email, 'password' => HU013_CONTRASENA])
        ->call('authenticate')
        ->assertHasNoFormErrors();

    $event = AuditEvent::query()->where('event_type', AuditEventType::LoginSucceeded)->sole();

    expect($event->actor_id)->toBe($user->id)
        ->and($event->email_attempted)->toBe($user->email)
        ->and($event->result)->toBe(AuditEvent::RESULT_SUCCESS)
        ->and($event->occurred_at)->not->toBeNull()
        ->and($event->ip_address)->not->toBeNull()
        ->and($event->user_agent)->not->toBeNull();

    hu013AssertPasswordNotStored(HU013_CONTRASENA);
})->with(['admin', 'docente']);

it('Registro de intento: un login con contraseña incorrecta queda registrado sin la contraseña', function () {
    $user = User::factory()->create(['password' => 'Otra-Clave-Valida-1234']);

    hu013LoginPage('admin')
        ->fillForm(['email' => $user->email, 'password' => HU013_CONTRASENA])
        ->call('authenticate')
        ->assertHasFormErrors(['email']);

    $event = AuditEvent::query()->sole();

    expect($event->event_type)->toBe(AuditEventType::LoginFailed)
        ->and($event->result)->toBe(AuditEvent::RESULT_FAILURE)
        ->and($event->actor_id)->toBeNull()
        ->and($event->subject_id)->toBe($user->id)
        ->and($event->email_attempted)->toBe($user->email)
        ->and($event->occurred_at)->not->toBeNull()
        ->and($event->ip_address)->not->toBeNull()
        ->and($event->user_agent)->not->toBeNull();

    hu013AssertPasswordNotStored(HU013_CONTRASENA);
});

it('Registro de intento: un login con un correo inexistente queda registrado con el correo intentado', function () {
    hu013LoginPage('admin')
        ->fillForm(['email' => 'nadie@colegio-piloto.test', 'password' => HU013_CONTRASENA])
        ->call('authenticate')
        ->assertHasFormErrors(['email']);

    $event = AuditEvent::query()->sole();

    expect($event->event_type)->toBe(AuditEventType::LoginFailed)
        ->and($event->email_attempted)->toBe('nadie@colegio-piloto.test')
        ->and($event->subject_id)->toBeNull()
        ->and($event->actor_id)->toBeNull();

    hu013AssertPasswordNotStored(HU013_CONTRASENA);
});

it('Registro de intento: una cuenta sin acceso al panel queda registrada como fallida', function () {
    $user = User::factory()->deactivated()->create(['password' => HU013_CONTRASENA]);

    hu013LoginPage('admin')
        ->fillForm(['email' => $user->email, 'password' => HU013_CONTRASENA])
        ->call('authenticate')
        ->assertHasFormErrors(['email']);

    expect(AuditEvent::query()->sole())
        ->event_type->toBe(AuditEventType::LoginFailed)
        ->subject_id->toBe($user->id);

    expect(AuditEvent::query()->where('event_type', AuditEventType::LoginSucceeded)->exists())->toBeFalse();
    hu013AssertPasswordNotStored(HU013_CONTRASENA);
});

it('Registro de intento: guarda la IP y el navegador de la solicitud', function () {
    $user = User::factory()->create();

    $this->withHeader('User-Agent', 'NavegadorDePrueba/3.0')
        ->withServerVariables(['REMOTE_ADDR' => '192.0.2.44'])
        ->actingAs($user)
        ->post(route('filament.admin.auth.logout'));

    expect(AuditEvent::query()->sole())
        ->ip_address->toBe('192.0.2.44')
        ->user_agent->toBe('NavegadorDePrueba/3.0');
});

it('registra el cierre de sesión con el usuario que sale', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->post(route('filament.admin.auth.logout'))->assertRedirect();

    expect(AuditEvent::query()->sole())
        ->event_type->toBe(AuditEventType::Logout)
        ->actor_id->toBe($user->id)
        ->email_attempted->toBe($user->email)
        ->result->toBe(AuditEvent::RESULT_SUCCESS);
});
