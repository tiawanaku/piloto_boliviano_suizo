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
- [x] **Estado (Dev 1, 2026-10-28):** terminada. Instalado: laravel/framework 13.39.0, filament/filament 5.11.0 (Livewire 4), spatie/laravel-permission 8.3.2, pestphp/pest 4.7.8 (+ plugin-laravel 4.1.0, plugin-livewire 4.1.0), larastan/larastan 3.13.2 (PHPStan 2.3.3), laravel/pint 1.32.1. `php artisan about`: Laravel 13.39.0, `es`, `America/La_Paz`, SQLite, sesión/caché/cola `database`. Decisiones: se instaló también `spatie/laravel-permission` (está en [[Stack tecnologico]]; sin publicar config ni migraciones, eso es del Sprint 1); `config('app.timezone')` lee `APP_TIMEZONE`; se quitaron del esqueleto los archivos de mantenimiento del repo de Laravel (`.git`, `.github`, `CHANGELOG.md`, `.styleci.yml`) y `AGENTS.md`/`CLAUDE.md` (piden instalar Laravel Boost, fuera del stack); `.gitignore` excluye `database/*.sqlite` y los recursos publicados de Filament (`public/*/filament`, se regeneran con `filament:upgrade`). `.env.example` pasa a Dev 3.

#### T-0-02 · Identidad base — Dev 1
- **Qué:** editar la migración inicial `0001_01_01_000000_create_users_table.php` (aún no integrada): `uuid('id')->primary()`, `status` (string, por defecto `pending`), tabla `sessions` con `foreignUuid('user_id')`; `password_reset_tokens` igual. `User` con `HasUuids`, *cast* `status` → enum `App\Enums\AccountStatus` (`Pending`, `Active`, `Locked`, `Deactivated`, con `label()` traducido). `UserFactory` con estado por defecto `Active` y correos `@colegio-piloto.test`. `SESSION_DRIVER=database`.
- **Archivos:** `database/migrations/0001_01_01_000000_create_users_table.php`, `app/Models/User.php`, `app/Enums/AccountStatus.php`, `database/factories/UserFactory.php`, `lang/es/account.php`, `tests/Unit/Models/UserTest.php`.
- **Pruebas:** el id es UUID; la contraseña se guarda con Argon2id (`Hash::info()`); el estado se convierte a enum; la tabla `sessions` acepta un `user_id` UUID.
- [x] **Estado (Dev 1, 2026-10-28):** terminada. Decisiones: se publicó `config/hashing.php` con `argon2id` como valor por defecto (sin `.env`, p. ej. en CI, Laravel usaría bcrypt); la migración usa el literal `'pending'` (no el enum) para no depender del código; `User` declara `status = pending` por defecto y la factory crea cuentas `Active` con estados `pending()`, `locked()`, `deactivated()`. Pruebas en `tests/Unit/Models/UserTest.php`.

#### T-0-03 · Paneles Filament `admin` y `docente` — Dev 1
- **Qué:** `php artisan filament:install --panels` → `AdminPanelProvider` (id `admin`, ruta `/admin`, por defecto, `->login()`) y `DocentePanelProvider` (id `docente`, ruta `/docente`, `->login()`), mismo guard `web`, color y nombre "Colegio Virtual". Descubrimiento en `app/Filament/Admin` y `app/Filament/Docente`. `User` implementa `FilamentUser::canAccessPanel()` provisional: solo cuentas `Active` (los roles llegan en el Sprint 1). `DatabaseSeeder` crea una cuenta ficticia `demo@colegio-piloto.test`.
- **Archivos:** `app/Providers/Filament/AdminPanelProvider.php`, `app/Providers/Filament/DocentePanelProvider.php`, `bootstrap/providers.php`, `app/Models/User.php`, `database/seeders/DatabaseSeeder.php`, `tests/Feature/Panels/PanelAccessTest.php`.
- **Pruebas:** `/admin/login` y `/docente/login` responden 200; un invitado que pide `/admin` es redirigido al login; una cuenta `Active` entra a `/admin`; una cuenta `Pending` recibe 403.
- [x] **Estado (Dev 1, 2026-10-28):** terminada. Ambos paneles con `->login()`, `->authGuard('web')`, marca "Colegio Virtual" y color primario azul; widget `FilamentInfoWidget` retirado. Las pruebas de `tests/Feature/Panels/PanelAccessTest.php` cubren ambos paneles y los estados `pending`, `locked` y `deactivated` (403). Mientras no exista `tests/Pest.php` (Dev 2, T-0-05), los archivos de prueba de Dev 1 declaran `uses(TestCase::class, RefreshDatabase::class)`: al crear `Pest.php` con `->in('Feature')`, quitar esa línea del archivo de `Feature/Panels` para evitar el doble vínculo.

#### T-0-04 · Localización `lang/es` — Dev 3
- **Qué:** `php artisan lang:publish`; crear `lang/es/auth.php`, `passwords.php`, `validation.php` (con `attributes` en español), `pagination.php`. Verificar que Filament usa su traducción `es`.
- **Archivos:** `lang/es/auth.php`, `passwords.php`, `validation.php`, `pagination.php`, `tests/Feature/Localization/SpanishMessagesTest.php`.
- **Pruebas:** un error de validación de campo requerido y el mensaje de credenciales incorrectas se muestran en español.
- [x] **Estado (Dev 3, 2026-10-28):** terminada. `lang/es/auth.php`, `passwords.php`, `pagination.php` y `validation.php` (todas las reglas de Laravel 13 + `attributes` de los campos de la Fase 1) escritos a mano: no se instaló `laravel-lang` (habría que tocar `composer.json`). Decisiones: no se ejecutó `lang:publish` (solo copiaría `lang/en`, que Laravel ya usa como respaldo); `auth.failed` es genérico ("El correo o la contraseña no son correctos."); el login de Filament usa su propia traducción `es` (`filament-panels::auth/pages/login.messages.failed`), que HU-001 podrá reemplazar. Pruebas en `tests/Feature/Localization/SpanishMessagesTest.php` (validador, `auth.failed`, errores del login en ambos paneles y página de login en español).

#### T-0-05 · Pest 4, Larastan, Pint — Dev 2
- **Qué:** `vendor/bin/pest --init`; convertir pruebas de ejemplo; `phpunit.xml` con `DB_CONNECTION=sqlite`, `DB_DATABASE=:memory:`, `QUEUE_CONNECTION=sync`, `MAIL_MAILER=array`; `tests/Pest.php` con `RefreshDatabase` para `Feature`; `phpstan.neon` (Larastan, nivel 6, rutas `app`, `config`, `database`, `routes`); `pint.json` (`preset: laravel`, regla `declare_strict_types`).
- **Archivos:** `phpunit.xml`, `tests/Pest.php`, `tests/TestCase.php`, `phpstan.neon`, `pint.json`, `tests/Feature/ExampleTest.php` (eliminar o convertir).
- **Terminado:** `composer quality` pasa en limpio sobre el esqueleto.
- [x] **Estado (Dev 2, 2026-10-28):** terminada. `tests/Pest.php` vincula `TestCase` + `RefreshDatabase` en `Feature` y `Unit/Models` (se quitaron los `uses(...)` de las pruebas de Dev 1); `ExampleTest` de Feature eliminado (lo cubre la prueba de humo) y el de Unit convertido a Pest; `phpunit.xml` ya traía SQLite `:memory:`, cola `sync` y correo `array` (sin cambios); `phpstan.neon` con Larastan nivel 6 sobre `app`, `config`, `database`, `routes`, sin baseline; `pint.json` con `preset: laravel` + `declare_strict_types`. Decisión: la regla aplica a archivos **nuevos** ([[Stack tecnologico]]), por eso los 20 archivos PHP del esqueleto de Laravel sin `declare` están en `notPath` de `pint.json` (deuda: añadirles `declare` con `vendor/bin/pint` y vaciar `notPath` cuando nadie los esté editando). `composer quality` pasa en limpio; cobertura local con pcov 98,6 %.

#### T-0-06 · Workflow de CI — Dev 2
- **Qué:** `.github/workflows/app-colegio.yml` (en la raíz del repositorio), disparado en PR y *push* a `main` cuando cambia `app-colegio/**` o el propio workflow; `defaults.run.working-directory: app-colegio`; `shivammathur/setup-php` con PHP 8.3 y `pcov`; trabajos: `pint` (`--test`), `phpstan`, `pest` (SQLite, `--coverage --min=80`), `audit` (`composer audit`). Caché de Composer. Sin trabajos de despliegue.
- **Archivos:** `.github/workflows/app-colegio.yml`.
- **Terminado:** una PR de prueba muestra los 4 trabajos en verde; una PR con un error de Pint falla.
- [x] **Estado (Dev 2, 2026-10-28):** workflow escrito (trabajos `pint`, `phpstan`, `pest` con pcov y `--coverage --min=80`, `audit` con `composer audit --locked`; caché de Composer; `permissions: contents: read`; `concurrency`; sin despliegue). El trabajo `pest` crea `.env` desde `.env.example` y genera `APP_KEY` (clave efímera, sin secretos). YAML validado y comandos ejecutados en local sobre una copia limpia (sin `.env`): todo en verde. Pendiente de verificar en GitHub con una PR de prueba (aquí no se puede ejecutar Actions).

#### T-0-07 · Plantilla de PR y protección de `main` — Dev 2
- **Qué:** plantilla con la [[Definicion de Terminado]] como lista de verificación (historia, escenarios cubiertos, prueba con rol sin acceso, auditoría, solo datos ficticios, capturas). Pedir al administrador del repositorio la regla de protección de `main`: PR obligatorio, 1 revisión, los 4 trabajos de CI requeridos.
- **Archivos:** `.github/pull_request_template.md`.
- **Terminado:** la protección está activa (o registrada como impedimento si falta el permiso).
- [ ] **Estado (Dev 2, 2026-10-28):** plantilla creada. ⚠️ **Impedimento:** la protección de `main` no se pudo consultar ni configurar desde la sesión (API 403); la debe activar el administrador del repositorio: PR obligatorio, 1 revisión, checks requeridos `pint`, `phpstan`, `pest`, `audit`. Ojo: el workflow filtra por `paths`, así que una PR que solo toca el vault nunca reportaría esos checks y quedaría bloqueada; decidir entre quitar el filtro de `pull_request` o exigir los checks con un *ruleset* que lo contemple.

#### T-0-08 · Pruebas de humo — Dev 2
- **Qué:** pruebas que fallan si la aplicación no arranca: página de inicio, salud (`/up`), migraciones completas, `php artisan config:cache` sin errores.
- **Archivos:** `tests/Feature/Smoke/ApplicationBootTest.php`.
- **Terminado:** corre en el trabajo `pest` del CI.
- [x] **Estado (Dev 2, 2026-10-28):** terminada. `tests/Feature/Smoke/ApplicationBootTest.php`: inicio 200, `/up` 200, ninguna migración pendiente (y tablas `users`, `sessions`, `jobs`, `cache`), `config:cache` sin errores (limpia la caché al terminar). Corre en el trabajo `pest` del CI.

#### T-0-09 · Entorno local con SQLite y `composer dev` — Dev 3
- **Qué:** `.env.example` completo para el piloto (`DB_CONNECTION=sqlite`, `QUEUE_CONNECTION=database`, `CACHE_STORE=database`, `MAIL_MAILER=log`, variables opcionales de Mailpit comentadas); README de arranque: `composer install`, `cp .env.example .env`, `php artisan key:generate`, `touch database/database.sqlite`, `php artisan migrate --seed`, `composer dev`.
- **Archivos:** `.env.example` (después de T-0-01), `README.md` de `app-colegio/`.
- **Terminado:** otra persona del equipo arranca el proyecto desde cero solo con el README, sin Docker ni servidor de base de datos.
- [x] **Estado (Dev 3, 2026-10-28):** terminada (falta la verificación de otra persona del equipo con el README). `.env.example` comentado para el piloto (SQLite, cola/caché/sesión `database`, `MAIL_MAILER=log`, bloque de Mailpit comentado, Redis comentado, `APP_URL=http://127.0.0.1:8000`). README de `app-colegio/` reescrito en español: requisitos, arranque desde cero, paneles, variables, correo y colas, demostración y calidad. Decisión: `composer dev` (= `php artisan dev`) lanza los procesos con `npx`, así que el README incluye `npm install`; sin npm se documenta `php artisan serve` + `php artisan queue:work`.

#### T-0-10 · Correo y colas — Dev 3
- **Qué:** cola y caché `database`; publicar y traducir la plantilla de correo (`vendor:publish --tag=laravel-mail`) con pie "Colegio Virtual — piloto"; comando `colegio:correo-prueba {correo}` que envía una notificación en cola (queda en el log o en Mailpit); *scheduler* mínimo en `routes/console.php`: `auth:clear-resets` diario.
- **Archivos:** `resources/views/vendor/mail/**`, `app/Console/Commands/SendTestMail.php`, `app/Notifications/TestMailNotification.php`, `lang/es/mail.php`, `routes/console.php`, `tests/Feature/Infra/MailQueueTest.php`.
- **Pruebas:** con `Notification::fake()` la notificación se envía y es `ShouldQueue`; el asunto está en español; el comando rechaza correos fuera de `@colegio-piloto.test`.
- [x] **Estado (Dev 3, 2026-10-28):** terminada. Plantillas `laravel-mail` publicadas con pie "Colegio Virtual — piloto" y aviso de datos ficticios (`lang/es/mail.php`); `TestMailNotification` (`ShouldQueue`) fija saludo y despedida en español, por eso no se publicó la plantilla `vendor/notifications` (fuera del paquete). `colegio:correo-prueba {correo}` valida formato y dominio exacto `@colegio-piloto.test`. `routes/console.php`: `auth:clear-resets` diario (se quitó el comando de ejemplo `inspire`). Verificado a mano: el correo en cola se procesa con `queue:work` y queda en `storage/logs/laravel.log`. Pruebas en `tests/Feature/Infra/MailQueueTest.php` (envío en cola, asunto y pie en español, rechazo de 3 correos inválidos, job en la tabla `jobs`, *scheduler*).

#### T-0-11 · Entorno de demostración — Dev 3
- **Qué:** comando `php artisan colegio:demo` que se niega a correr en `APP_ENV=production`, ejecuta `migrate:fresh --seed` con `DatabaseSeeder` y muestra la URL y las cuentas ficticias de demostración. Guía corta "Cómo hacer la demostración" en el README (incluye Mailpit opcional para ver correos). Los *seeders* de cada sprint se suman a este comando.
- **Archivos:** `app/Console/Commands/PrepareDemo.php`, `README.md` (sección de demostración), `tests/Feature/Commands/PrepareDemoTest.php`.
- **Pruebas:** el comando deja la base con la cuenta de demostración; en `production` termina con error sin tocar datos.
- [x] **Estado (Dev 3, 2026-10-28):** terminada. `php artisan colegio:demo [--force]`: se niega en `production` antes de tocar nada, pide confirmación (salvo `--force`), crea el archivo SQLite si falta, ejecuta `migrate:fresh --seed --force` y muestra las URL de `/admin` y `/docente`, una tabla con las cuentas ficticias (leídas de la base, así incluye los *seeders* futuros) y la contraseña ficticia. Textos en `lang/es/demo.php` (archivo nuevo, no listado en el paquete). Guía "Cómo hacer la demostración" en el README. Pruebas en `tests/Feature/Commands/PrepareDemoTest.php`: usan una base SQLite temporal en archivo porque `migrate:fresh` no puede correr dentro de la transacción de `RefreshDatabase`.
