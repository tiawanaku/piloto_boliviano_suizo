---
tipo: sprint
numero: 0
inicio: 2026-11-02
fin: 2026-11-13
estado: planificado
tags: [sprint, fase1]
---
# Sprint 0 · Preparación

Volver a [[Sprints MOC]]

> El "Sprint 0" no es un concepto de la Guía de Scrum; aquí se usa como **sprint de arranque** que también debe dejar algo funcionando.
>
> 🧪 **Alcance piloto** ([[2026-10-28 Decisiones de la direccion]]): no hay staging ni producción. El "ambiente de pruebas" es el **entorno de demostración** (la aplicación ejecutada en un equipo con datos ficticios).

## Objetivo del sprint
**"El equipo puede construir, probar automáticamente y demostrar una versión mínima de la plataforma en el entorno de demostración."**

## Trabajo
- [ ] Confirmar [[Equipo Scrum del proyecto]] (PO, SM, Developers) y acuerdos de trabajo.
- [ ] Taller de visión con dirección → validar [[Vision del producto]].
- [ ] Taller de roles y permisos con dirección y secretaría → validar [[Roles y permisos RBAC]].
- [x] Decidir stack tecnológico → [[ADR-005 Stack PHP Laravel y Filament]] (ver [[Stack tecnologico]]).
- [ ] Repositorio, ramas, revisión de código, CI.
- [ ] Entorno de demostración con datos ficticios (`php artisan colegio:demo`).
- [ ] Correo capturado (driver `log` o Mailpit), sin envíos a personas reales (necesario para [[HU-003 Recuperar contrasena]]).
- [ ] Cuentas ficticias de demostración `@colegio-piloto.test` (≥ 1 por rol).
- [ ] Refinar historias de Sprint 1 y 2 hasta cumplir [[Definicion de Listo]].
- [ ] Acordar la [[Definicion de Terminado]].

## Resultado esperado
Proyecto en `app-colegio/` con CI en verde; `php artisan colegio:demo` levanta el panel `/admin` con una cuenta ficticia de demostración.

## Capacidad
| Developer | Días disponibles | Notas |
|---|---|---|
| Dev 1 | 9 | 02/11 feriado (Día de los Difuntos) |
| Dev 2 | 9 | ídem |
| Dev 3 | 9 | ídem |
| **Total** | **27** | Incluye talleres con dirección (03/11) y refinamiento. Sin staging, queda más tiempo para refinar S1–S2 y preparar los talleres |

## Tareas técnicas
> Definidas por el [[Scrum Master]] el 2026-10-28 y simplificadas por alcance piloto el mismo día ([[2026-10-28 Sprint Planning tecnico - Scrum Master]]). Stack: [[ADR-005 Stack PHP Laravel y Filament]] · Convenciones: [[Stack tecnologico]] · Habilitadores: [[Backlog tecnico]] · Paquetes: [[Sprint 0 - Dev 1]], [[Sprint 0 - Dev 2]], [[Sprint 0 - Dev 3]].
>
> **Terminado técnico común a todas las tareas** (además de lo indicado en cada una): `vendor/bin/pint --test`, `vendor/bin/phpstan analyse` y `vendor/bin/pest` en verde desde `app-colegio/`; PR revisado por otro developer; sin secretos en el repositorio; solo datos ficticios.
>
> **Meta del sprint:** proyecto Laravel 13 + Filament 5 creado en `app-colegio/`, con pruebas en verde, CI en GitHub Actions y el panel `/admin` accesible en el entorno de demostración.

| ID | Tarea | Relacionada | Dev | Depende de |
|---|---|---|---|---|
| T-0-01 | Crear proyecto Laravel 13 e instalar dependencias ⚠️ **primero** | TEC-01 | Dev 1 | — |
| T-0-02 | Identidad base: `User` UUID, `AccountStatus`, Argon2id, sesiones en BD | TEC-06 | Dev 1 | T-0-01 |
| T-0-03 | Paneles Filament `admin` y `docente` | TEC-05 | Dev 1 | T-0-02 |
| T-0-04 | Localización `lang/es` | TEC-07 | Dev 3 | T-0-01 |
| T-0-05 | Configurar Pest 4, Larastan, Pint y `composer quality` | TEC-03 | Dev 2 | T-0-01 |
| T-0-06 | Workflow de CI en GitHub Actions | TEC-04 | Dev 2 | T-0-05 |
| T-0-07 | Plantilla de PR y protección de `main` | TEC-04 | Dev 2 | T-0-06 |
| T-0-08 | Pruebas de humo de la aplicación | TEC-03 | Dev 2 | T-0-03, T-0-05 |
| T-0-09 | Entorno local con SQLite y `composer dev` | TEC-02 | Dev 3 | T-0-01 |
| T-0-10 | Correo y colas (driver `log`, Mailpit opcional) | TEC-08 | Dev 3 | T-0-09 |
| T-0-11 | Entorno de demostración: comando `colegio:demo` y guía | TEC-09 | Dev 3 | T-0-03, T-0-09 |

#### T-0-01 · Crear proyecto Laravel 13 e instalar dependencias — Dev 1 ⚠️ debe completarse primero
- **Qué:** `composer create-project laravel/laravel:^13 app-colegio`; `composer require filament/filament:^5.11`; `composer require --dev pestphp/pest:^4.7 pestphp/pest-plugin-laravel:^4.1 pestphp/pest-plugin-livewire:^4.1 larastan/larastan:^3.13` (Pint ya viene); script `quality` en `composer.json` (se conserva el script `dev` del esqueleto). Configurar `APP_NAME="Colegio Virtual (piloto)"`, `APP_LOCALE=es`, `APP_FALLBACK_LOCALE=en`, zona `America/La_Paz`, `HASH_DRIVER=argon2id`, `DB_CONNECTION=sqlite`, `MAIL_MAILER=log` en `.env.example`. Crear `config/colegio.php` con las claves de la Fase 1: `dominio_institucional` (por defecto `colegio-piloto.test`), `sesion_inactividad_minutos` (30), `bloqueo.intentos` (5), `bloqueo.ventana_minutos` (15), `bloqueo.minutos` (15), `contrasena_temporal_horas` (72), `invitacion_horas` (72), `restablecimiento_minutos` (30).
- **Archivos:** `app-colegio/` completo (esqueleto), `composer.json`, `composer.lock`, `config/app.php`, `config/colegio.php`, `.env.example`.
- **Terminado:** `php artisan about` muestra Laravel 13, locale `es` y SQLite; `composer quality` existe. Avisar a Dev 2 y Dev 3 al integrarla.

#### T-0-02 · Identidad base — Dev 1
- **Qué:** editar la migración inicial `0001_01_01_000000_create_users_table.php` (aún no integrada): `uuid('id')->primary()`, `status` (string, por defecto `pending`), tabla `sessions` con `foreignUuid('user_id')`; `password_reset_tokens` igual. `User` con `HasUuids`, *cast* `status` → enum `App\Enums\AccountStatus` (`Pending`, `Active`, `Locked`, `Deactivated`, con `label()` traducido). `UserFactory` con estado por defecto `Active` y correos `@colegio-piloto.test`. `SESSION_DRIVER=database`.
- **Archivos:** `database/migrations/0001_01_01_000000_create_users_table.php`, `app/Models/User.php`, `app/Enums/AccountStatus.php`, `database/factories/UserFactory.php`, `lang/es/account.php`, `tests/Unit/Models/UserTest.php`.
- **Pruebas:** el id es UUID; la contraseña se guarda con Argon2id (`Hash::info()`); el estado se convierte a enum; la tabla `sessions` acepta un `user_id` UUID.

#### T-0-03 · Paneles Filament `admin` y `docente` — Dev 1
- **Qué:** `php artisan filament:install --panels` → `AdminPanelProvider` (id `admin`, ruta `/admin`, por defecto, `->login()`) y `DocentePanelProvider` (id `docente`, ruta `/docente`, `->login()`), mismo guard `web`, color y nombre "Colegio Virtual". Descubrimiento en `app/Filament/Admin` y `app/Filament/Docente`. `User` implementa `FilamentUser::canAccessPanel()` provisional: solo cuentas `Active` (los roles llegan en el Sprint 1). `DatabaseSeeder` crea una cuenta ficticia `demo@colegio-piloto.test`.
- **Archivos:** `app/Providers/Filament/AdminPanelProvider.php`, `app/Providers/Filament/DocentePanelProvider.php`, `bootstrap/providers.php`, `app/Models/User.php`, `database/seeders/DatabaseSeeder.php`, `tests/Feature/Panels/PanelAccessTest.php`.
- **Pruebas:** `/admin/login` y `/docente/login` responden 200; un invitado que pide `/admin` es redirigido al login; una cuenta `Active` entra a `/admin`; una cuenta `Pending` recibe 403.

#### T-0-04 · Localización `lang/es` — Dev 3
- **Qué:** `php artisan lang:publish`; crear `lang/es/auth.php`, `passwords.php`, `validation.php` (con `attributes` en español), `pagination.php`. Verificar que Filament usa su traducción `es`.
- **Archivos:** `lang/es/auth.php`, `passwords.php`, `validation.php`, `pagination.php`, `tests/Feature/Localization/SpanishMessagesTest.php`.
- **Pruebas:** un error de validación de campo requerido y el mensaje de credenciales incorrectas se muestran en español.

#### T-0-05 · Pest 4, Larastan, Pint — Dev 2
- **Qué:** `vendor/bin/pest --init`; convertir pruebas de ejemplo; `phpunit.xml` con `DB_CONNECTION=sqlite`, `DB_DATABASE=:memory:`, `QUEUE_CONNECTION=sync`, `MAIL_MAILER=array`; `tests/Pest.php` con `RefreshDatabase` para `Feature`; `phpstan.neon` (Larastan, nivel 6, rutas `app`, `config`, `database`, `routes`); `pint.json` (`preset: laravel`, regla `declare_strict_types`).
- **Archivos:** `phpunit.xml`, `tests/Pest.php`, `tests/TestCase.php`, `phpstan.neon`, `pint.json`, `tests/Feature/ExampleTest.php` (eliminar o convertir).
- **Terminado:** `composer quality` pasa en limpio sobre el esqueleto.

#### T-0-06 · Workflow de CI — Dev 2
- **Qué:** `.github/workflows/app-colegio.yml` (en la raíz del repositorio), disparado en PR y *push* a `main` cuando cambia `app-colegio/**` o el propio workflow; `defaults.run.working-directory: app-colegio`; `shivammathur/setup-php` con PHP 8.3 y `pcov`; trabajos: `pint` (`--test`), `phpstan`, `pest` (SQLite, `--coverage --min=80`), `audit` (`composer audit`). Caché de Composer. Sin trabajos de despliegue.
- **Archivos:** `.github/workflows/app-colegio.yml`.
- **Terminado:** una PR de prueba muestra los 4 trabajos en verde; una PR con un error de Pint falla.

#### T-0-07 · Plantilla de PR y protección de `main` — Dev 2
- **Qué:** plantilla con la [[Definicion de Terminado]] como lista de verificación (historia, escenarios cubiertos, prueba con rol sin acceso, auditoría, solo datos ficticios, capturas). Pedir al administrador del repositorio la regla de protección de `main`: PR obligatorio, 1 revisión, los 4 trabajos de CI requeridos.
- **Archivos:** `.github/pull_request_template.md`.
- **Terminado:** la protección está activa (o registrada como impedimento si falta el permiso).

#### T-0-08 · Pruebas de humo — Dev 2
- **Qué:** pruebas que fallan si la aplicación no arranca: página de inicio, salud (`/up`), migraciones completas, `php artisan config:cache` sin errores.
- **Archivos:** `tests/Feature/Smoke/ApplicationBootTest.php`.
- **Terminado:** corre en el trabajo `pest` del CI.

#### T-0-09 · Entorno local con SQLite y `composer dev` — Dev 3
- **Qué:** `.env.example` completo para el piloto (`DB_CONNECTION=sqlite`, `QUEUE_CONNECTION=database`, `CACHE_STORE=database`, `MAIL_MAILER=log`, variables opcionales de Mailpit comentadas); README de arranque: `composer install`, `cp .env.example .env`, `php artisan key:generate`, `touch database/database.sqlite`, `php artisan migrate --seed`, `composer dev`.
- **Archivos:** `.env.example` (después de T-0-01), `README.md` de `app-colegio/`.
- **Terminado:** otra persona del equipo arranca el proyecto desde cero solo con el README, sin Docker ni servidor de base de datos.

#### T-0-10 · Correo y colas — Dev 3
- **Qué:** cola y caché `database`; publicar y traducir la plantilla de correo (`vendor:publish --tag=laravel-mail`) con pie "Colegio Virtual — piloto"; comando `colegio:correo-prueba {correo}` que envía una notificación en cola (queda en el log o en Mailpit); *scheduler* mínimo en `routes/console.php`: `auth:clear-resets` diario.
- **Archivos:** `resources/views/vendor/mail/**`, `app/Console/Commands/SendTestMail.php`, `app/Notifications/TestMailNotification.php`, `lang/es/mail.php`, `routes/console.php`, `tests/Feature/Infra/MailQueueTest.php`.
- **Pruebas:** con `Notification::fake()` la notificación se envía y es `ShouldQueue`; el asunto está en español; el comando rechaza correos fuera de `@colegio-piloto.test`.

#### T-0-11 · Entorno de demostración — Dev 3
- **Qué:** comando `php artisan colegio:demo` que se niega a correr en `APP_ENV=production`, ejecuta `migrate:fresh --seed` con `DatabaseSeeder` y muestra la URL y las cuentas ficticias de demostración. Guía corta "Cómo hacer la demostración" en el README (incluye Mailpit opcional para ver correos). Los *seeders* de cada sprint se suman a este comando.
- **Archivos:** `app/Console/Commands/PrepareDemo.php`, `README.md` (sección de demostración), `tests/Feature/Commands/PrepareDemoTest.php`.
- **Pruebas:** el comando deja la base con la cuenta de demostración; en `production` termina con error sin tocar datos.
