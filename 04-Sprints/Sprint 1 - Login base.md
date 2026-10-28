---
tipo: sprint
numero: 1
inicio: 2026-11-16
fin: 2026-11-27
estado: planificado
puntos_comprometidos: 17
puntos_terminados:
tags: [sprint, fase1]
---
# Sprint 1 · Login base

Volver a [[Sprints MOC]] · Épica: [[EP-01 Login plantel administrativo y docentes]]

## 🎯 Objetivo del sprint
**"El personal administrativo y docente puede iniciar sesión con su correo institucional, definir su propia contraseña y llegar a su panel según su rol; cada acceso queda registrado."**

> Confirmado por el PO en la [[2026-11-13 Sprint Review - Sprint 0]]. Alcance piloto: se demuestra con cuentas ficticias `@colegio-piloto.test` mediante `colegio:demo`. Condición de aceptación: cada historia entra por PR con el CI de GitHub en verde.

## Capacidad
| Developer | Días disponibles | Notas |
|---|---|---|
| _Dev 1_ | 10 | |
| _Dev 2_ | 10 | |
| _Dev 3_ | 9 | 1 día de capacitación |
| **Total** | **29** | Velocidad estimada: 15–20 pts |

## Sprint Backlog
| Historia | Pts | Estado |
|---|---|---|
| [[HU-001 Iniciar sesion con correo institucional]] | 5 | por hacer |
| [[HU-007 Panel segun rol]] | 5 | por hacer |
| [[HU-002 Cerrar sesion]] | 1 | por hacer |
| [[HU-006 Cambio de contrasena en primer ingreso]] | 3 | por hacer |
| [[HU-013 Registro de auditoria de accesos]] | 3 | por hacer |
| **Total** | **17** | |

## Tablero
### Por hacer
- [ ] HU-001 · Endpoint de autenticación
- [ ] HU-001 · Pantalla de login responsive
- [ ] HU-007 · Modelo de roles y verificación en servidor
- [ ] HU-007 · Paneles vacíos por rol
- [ ] HU-002 · Logout y expiración por inactividad
- [ ] HU-006 · Flujo de contraseña temporal
- [ ] HU-013 · Tabla/evento de auditoría
- [ ] Script de creación de cuentas semilla (temporal hasta [[HU-009 Invitar personal]])
### En progreso
### En revisión
### Hecho

## Tareas técnicas
> Definidas por el [[Scrum Master]] el 2026-10-28 ([[2026-10-28 Sprint Planning tecnico - Scrum Master]]). Stack: [[ADR-005 Stack PHP Laravel y Filament]] · Convenciones: [[Stack tecnologico]] · Habilitadores: [[Backlog tecnico]] · Paquetes: [[Sprint 1 - Dev 1]], [[Sprint 1 - Dev 2]], [[Sprint 1 - Dev 3]]. Los Developers las ajustan en la [[Sprint Planning]].
>
> **Terminado técnico común:** `vendor/bin/pint --test`, `vendor/bin/phpstan analyse`, `vendor/bin/pest` en verde (CI con SQLite); solo datos ficticios `@colegio-piloto.test`; cada escenario Gherkin de la historia tiene al menos una prueba Pest con su nombre; prueba con un rol sin acceso cuando aplica; textos en `lang/es`; PR revisado.
>
> Reparto: **Dev 1** = login, sesión y contraseña (HU-001, HU-002, HU-006, TEC-13) · **Dev 2** = roles y paneles, más la deuda del S0 (TEC-10, TEC-11, HU-007, TEC-18, TEC-19) · **Dev 3** = auditoría y *spikes* (TEC-12, HU-013, TEC-14, TEC-15).

| ID | Tarea | Relacionada | Dev | Depende de |
|---|---|---|---|---|
| T-1-01 | Configuración compartida de paneles `StaffPanel` ⚠️ **primero** | HU-001, HU-007 | Dev 1 | — |
| T-1-02 | Página de login personalizada: validaciones y mensajes | HU-001 | Dev 1 | T-1-01 |
| T-1-03 | Login: estados de cuenta e ingreso exitoso | HU-001 | Dev 1 | T-1-02, T-1-12 |
| T-1-04 | Cierre de sesión, inactividad y "atrás" | HU-002, TEC-13 | Dev 1 | T-1-01 |
| T-1-05 | Cabeceras de seguridad | TEC-13 | Dev 1 | T-1-01 |
| T-1-06 | Política de contraseñas y columnas de contraseña temporal | HU-006 | Dev 1 | — |
| T-1-07 | Página "Cambiar contraseña" obligatoria | HU-006 | Dev 1 | T-1-01, T-1-06 |
| T-1-08 | Instalar spatie/laravel-permission y enums de roles/permisos ⚠️ **temprano** | TEC-10 | Dev 2 | — |
| T-1-09 | *Seeder* de la matriz RBAC | TEC-10 | Dev 2 | T-1-08, taller 03/11 |
| T-1-10 | *Factories*, *helpers* de Pest y comando `colegio:crear-cuenta` | TEC-11 | Dev 2 | T-1-06, T-1-09 |
| T-1-11 | Acceso a paneles por rol y rol principal | HU-007 | Dev 2 | T-1-09 |
| T-1-12 | Redirección al panel principal tras el login | HU-007 | Dev 2 | T-1-11 |
| T-1-13 | Cambio de panel y panel docente vacío | HU-007 | Dev 2 | T-1-12 |
| T-1-14 | Página 403 en español y registro del acceso denegado | HU-007 | Dev 2 | T-1-11, T-1-15 |
| T-1-15 | Tabla `audit_events`, modelo inmutable y `AuditLogger` ⚠️ **temprano** | TEC-12, HU-013 | Dev 3 | — |
| T-1-16 | *Trigger* de inmutabilidad en la base de datos | TEC-12, HU-013 | Dev 3 | T-1-15 |
| T-1-17 | *Listeners* de intentos de login y logout | HU-013 | Dev 3 | T-1-15 |
| T-1-18 | *Policy* de auditoría y pruebas de inmutabilidad | HU-013 | Dev 3 | T-1-15 |
| T-1-19 | Spike: peso del login en 3G | TEC-14 | Dev 3 | T-1-02 |
| T-1-20 | Spike: MFA por rol en Filament 5 | TEC-15 | Dev 3 | T-1-11 |
| T-1-21 | Verificación de la DoD de experiencia en el entorno de demostración | Todas | Dev 3 | resto del sprint |
| T-1-22 | Deuda: quitar `notPath` de Pint y la prueba trivial ⚠️ **primero** (día 1, mañana) | TEC-18 | Dev 2 | — |
| T-1-23 | Deuda: CI sin filtro `paths` y primera ejecución en GitHub | TEC-19 | Dev 2 | T-1-22 |

#### T-1-01 · `StaffPanel` (configuración compartida) — Dev 1 ⚠️ debe completarse primero (día 1)
- **Qué:** clase `App\Filament\Support\StaffPanel::configure(Panel $panel): Panel` con lo común a `admin` y `docente`: página de login (`Pages\Auth\Login`), *middleware* de autenticación compartido, marca y colores. Ambos *PanelProviders* la invocan (cambio de una línea; luego los *providers* pasan a Dev 2).
- **Archivos:** `app/Filament/Support/StaffPanel.php`, `app/Providers/Filament/AdminPanelProvider.php`, `app/Providers/Filament/DocentePanelProvider.php` (solo esa línea).
- **Pruebas:** las de `tests/Feature/Panels/PanelAccessTest.php` siguen en verde.

#### T-1-02 · Login personalizado: validaciones y mensajes — Dev 1
- **Qué:** `App\Filament\Pages\Auth\Login` extiende el login de Filament: etiquetas en español, contraseña con mostrar/ocultar, regla `InstitutionalEmail` (dominio de `config('colegio.dominio_institucional')`), mensaje genérico "Correo o contraseña incorrectos".
- **Archivos:** `app/Filament/Pages/Auth/Login.php`, `app/Rules/InstitutionalEmail.php`, `lang/es/auth.php`, `tests/Feature/HU001/LoginValidationTest.php`, `tests/Unit/Rules/InstitutionalEmailTest.php`.
- **Pruebas (HU-001):** "Credenciales incorrectas" (mismo mensaje con correo existente y no existente), "Correo no institucional", "Campos vacíos".

#### T-1-03 · Login: estados de cuenta e ingreso exitoso — Dev 1
- **Qué:** antes de autenticar, verificar `AccountStatus`: `Deactivated` → "Tu cuenta no está activa. Comunícate con secretaría o la oficina de información"; `Pending` → mismo mensaje genérico de cuenta no activa. Al ingresar, regenerar la sesión.
- **Archivos:** `app/Filament/Pages/Auth/Login.php`, `lang/es/auth.php`, `tests/Feature/HU001/LoginSuccessTest.php`.
- **Pruebas (HU-001):** "Inicio de sesión exitoso" (autenticado y redirigido al panel según rol — usa T-1-12), "Cuenta desactivada".

#### T-1-04 · Cierre de sesión, inactividad y "atrás" — Dev 1
- **Qué:** `SESSION_LIFETIME` leído de `config('colegio.sesion_inactividad_minutos')` en `config/session.php`; cookies `http_only`, `same_site=lax` y `secure` vía `SESSION_SECURE_COOKIE` (activo solo si la demostración usa HTTPS); *middleware* `PreventBackHistory` (`Cache-Control: no-store, private`) registrado en `StaffPanel`; logout de Filament invalida la sesión.
- **Archivos:** `config/session.php`, `app/Http/Middleware/PreventBackHistory.php`, `app/Filament/Support/StaffPanel.php`, `tests/Feature/HU002/LogoutTest.php`.
- **Pruebas (HU-002):** "Cerrar sesión manualmente" (fila de `sessions` eliminada, redirección al login, cabecera `no-store`), "Expiración por inactividad" (`$this->travel(31)->minutes()` → redirige al login).

#### T-1-05 · Cabeceras de seguridad — Dev 1
- **Qué:** *middleware* `SecurityHeaders`: `X-Frame-Options: DENY`, `X-Content-Type-Options: nosniff`, `Referrer-Policy: strict-origin-when-cross-origin`, HSTS solo cuando la petición es HTTPS, `Content-Security-Policy-Report-Only` compatible con Livewire/Alpine. Registrado en `StaffPanel`.
- **Archivos:** `app/Http/Middleware/SecurityHeaders.php`, `app/Filament/Support/StaffPanel.php`, `tests/Feature/Security/SecurityHeadersTest.php`.
- **Pruebas:** cabeceras presentes en `/admin/login`.

#### T-1-06 · Política de contraseñas y columnas de contraseña temporal — Dev 1
- **Qué:** migración `add_temporary_password_columns_to_users_table` (`must_change_password` bool, `temporary_password_expires_at` nullable); trait `App\Models\Concerns\HasTemporaryPassword` (*casts* y `temporaryPasswordExpired()`); `Password::defaults()` en `AppServiceProvider` (mín. 10, `uncompromised()`), regla `NotCommonPassword` con lista local `resources/data/common-passwords.txt`; mensajes en `lang/es/passwords.php`.
- **Archivos:** `database/migrations/2026_11_16_100000_add_temporary_password_columns_to_users_table.php`, `app/Models/Concerns/HasTemporaryPassword.php`, `app/Providers/AppServiceProvider.php`, `app/Rules/NotCommonPassword.php`, `resources/data/common-passwords.txt`, `tests/Unit/Rules/PasswordPolicyTest.php`.
- **Pruebas (HU-006):** "Política de contraseña" (menos de 10 caracteres y contraseña común, cada una con su mensaje). `uncompromised()` se simula con `Http::fake()`.
- **Integración:** Dev 2 agrega `use HasTemporaryPassword;` en `User` (dueño de `User.php`).

#### T-1-07 · Página "Cambiar contraseña" obligatoria — Dev 1
- **Qué:** página `App\Filament\Pages\Auth\ChangeTemporaryPassword` y *middleware* `EnsurePasswordIsChanged` (registrado en `StaffPanel`) que redirige a ella mientras `must_change_password` sea verdadero; contraseña temporal vencida (> 72 h) bloquea el login con "Tu contraseña temporal venció. Solicita una nueva a secretaría". Indicador de fortaleza simple.
- **Archivos:** `app/Filament/Pages/Auth/ChangeTemporaryPassword.php`, `resources/views/filament/pages/auth/change-temporary-password.blade.php` (si hace falta), `app/Http/Middleware/EnsurePasswordIsChanged.php`, `app/Filament/Support/StaffPanel.php`, `app/Filament/Pages/Auth/Login.php`, `tests/Feature/HU006/TemporaryPasswordTest.php`.
- **Pruebas (HU-006):** "Contraseña temporal" (cualquier URL del panel redirige al cambio), "Contraseña temporal vencida".

#### T-1-08 · spatie/laravel-permission y enums — Dev 2 ⚠️ temprano (día 1–2)
- **Qué:** `composer require spatie/laravel-permission:^8.3`; publicar config y migración adaptadas a UUID (`model_morph_key` = `model_uuid`, columnas `uuid`); `User` usa `HasRoles`. Enums `App\Enums\StaffRole` (7 roles, `label()`, `isAdministrative()`, `priority()`) y `App\Enums\Permission` (permisos de la matriz, p. ej. `staff.invite`, `roles.assign_high`, `accounts.deactivate`, `accounts.unlock`, `mfa.reset`, `audit.view`, `staff.view`, `staff.edit_email`).
- **Archivos:** `composer.json`, `composer.lock`, `config/permission.php`, `database/migrations/2026_11_16_090000_create_permission_tables.php`, `app/Models/User.php`, `app/Enums/StaffRole.php`, `app/Enums/Permission.php`, `lang/es/roles.php`, `lang/es/permissions.php`, `tests/Unit/Enums/StaffRoleTest.php`.

#### T-1-09 · *Seeder* de la matriz RBAC — Dev 2
- **Qué:** `RolesAndPermissionsSeeder` idempotente que replica [[Roles y permisos RBAC]] validada en el [[2026-11-03 Taller - Roles y permisos]]; llamado desde `DatabaseSeeder` y desde el despliegue.
- **Archivos:** `database/seeders/RolesAndPermissionsSeeder.php`, `database/seeders/DatabaseSeeder.php`, `tests/Feature/Rbac/PermissionMatrixTest.php`.
- **Pruebas:** *dataset* Pest rol × permiso que verifica cada celda de la matriz; ejecutar el *seeder* dos veces no duplica.

#### T-1-10 · *Factories*, *helpers* y cuentas semilla — Dev 2
- **Qué:** estados de `UserFactory`: `active()`, `pending()`, `deactivated()`, `withTemporaryPassword()`, `withRoles(StaffRole ...)`; *helper* global `actingAsStaff(StaffRole ...$roles)` en `tests/Pest.php`; comando `colegio:crear-cuenta {correo} {--rol=*}` (solo correos ficticios del dominio configurado) que crea una cuenta activa con contraseña temporal (72 h) y la muestra una sola vez (temporal hasta [[HU-009 Invitar personal]]).
- **Archivos:** `database/factories/UserFactory.php`, `tests/Pest.php`, `app/Console/Commands/CreateStaffAccount.php`, `tests/Feature/Commands/CreateStaffAccountTest.php`.
- **Pruebas:** el comando crea la cuenta con los roles y `must_change_password = true`; rechaza correos fuera del dominio.

#### T-1-11 · Acceso a paneles por rol y rol principal — Dev 2
- **Qué:** `User::canAccessPanel()`: `admin` → algún rol administrativo y cuenta activa; `docente` → rol `teacher` y cuenta activa. Migración `add_primary_role_to_users_table`; método `primaryPanelId()` (rol principal o prioridad por defecto).
- **Archivos:** `app/Models/User.php`, `database/migrations/2026_11_16_110000_add_primary_role_to_users_table.php`, `tests/Feature/HU007/PanelAuthorizationTest.php`.
- **Pruebas (HU-007):** *dataset* rol × panel (permitido/403); cuenta desactivada → 403 en ambos.

#### T-1-12 · Redirección al panel principal — Dev 2
- **Qué:** implementación propia del contrato `LoginResponse` de Filament que redirige a la URL del panel principal; registrada en un nuevo `StaffAuthServiceProvider`.
- **Archivos:** `app/Http/Responses/StaffLoginResponse.php`, `app/Providers/StaffAuthServiceProvider.php`, `bootstrap/providers.php`, `tests/Feature/HU007/LoginRedirectTest.php`.
- **Pruebas (HU-007):** "Docente" → `/docente`; "Administrativo" → `/admin`.

#### T-1-13 · Cambio de panel y panel docente vacío — Dev 2
- **Qué:** ítem del menú de usuario "Cambiar a panel docente/administrativo" en cada *PanelProvider*, visible solo si `canAccessPanel()` del otro panel es verdadero; *dashboard* docente con el mensaje "Tus aulas aparecerán aquí cuando coordinación te asigne materias".
- **Archivos:** `app/Providers/Filament/AdminPanelProvider.php`, `app/Providers/Filament/DocentePanelProvider.php`, `app/Filament/Docente/Pages/Dashboard.php`, `lang/es/panels.php`, `tests/Feature/HU007/PanelSwitchTest.php`.
- **Pruebas (HU-007):** "Varios roles" (entra al principal, ve el ítem y abre el otro panel sin nuevo login); usuario con un solo rol no ve el ítem.

#### T-1-14 · 403 en español y registro del acceso denegado — Dev 2
- **Qué:** vista `errors/403.blade.php` liviana con "No tienes permiso para ver esta página" y enlace a su panel; en `bootstrap/app.php` (`withExceptions`) registrar `access.denied` con `AuditLogger` (URL, usuario, IP).
- **Archivos:** `resources/views/errors/403.blade.php`, `bootstrap/app.php`, `lang/es/errors.php`, `tests/Feature/HU007/UnauthorizedAccessTest.php`.
- **Pruebas (HU-007):** "Acceso no autorizado por URL" (docente → `/admin` = 403 con el texto y un `AuditEvent` `access.denied`).

#### T-1-15 · `audit_events`, modelo inmutable y `AuditLogger` — Dev 3 ⚠️ temprano (día 1–2; lo usa T-1-14)
- **Qué:** migración `create_audit_events_table` (UUID, `occurred_at`, `event_type`, `actor_id` nullable, `subject_type`/`subject_id` nullable, `email_attempted`, `result`, `ip_address` (`ipAddress()`), `user_agent`, `context` json/jsonb; índices por fecha, tipo y actor); enum `AuditEventType`; modelo `AuditEvent` que lanza excepción en `updating`/`deleting`; servicio `App\Services\AuditLogger::record()` que filtra claves sensibles (`password`, `token`, `secret`, `code`…).
- **Archivos:** `database/migrations/2026_11_16_080000_create_audit_events_table.php`, `app/Models/AuditEvent.php`, `app/Enums/AuditEventType.php`, `app/Services/AuditLogger.php`, `lang/es/audit.php`, `tests/Unit/Services/AuditLoggerTest.php`.
- **Pruebas:** registra un evento con contexto; nunca guarda claves sensibles; `update()`/`delete()` lanzan excepción.

#### T-1-16 · *Trigger* de inmutabilidad — Dev 3
- **Qué:** migración que crea los *triggers* que rechazan `UPDATE`/`DELETE` en `audit_events`: rama `sqlite` (`BEFORE UPDATE/DELETE … SELECT RAISE(ABORT, …)`), usada en el piloto, y rama `pgsql` (función + *trigger*) preparada para una implementación real. Sin purga por retención (fuera del alcance del piloto).
- **Archivos:** `database/migrations/2026_11_16_080100_add_immutability_trigger_to_audit_events.php`, `tests/Feature/HU013/AuditImmutabilityDatabaseTest.php` (corre en la suite normal con SQLite).
- **Pruebas (HU-013):** "Inmutabilidad" a nivel de base de datos (`DB::table()->update()` falla).

#### T-1-17 · *Listeners* de login y logout — Dev 3
- **Qué:** *listeners* descubiertos automáticamente para `Illuminate\Auth\Events\Login`, `Failed`, `Logout`: registran fecha/hora, correo intentado, resultado, IP y navegador; nunca la contraseña.
- **Archivos:** `app/Listeners/RecordSuccessfulLogin.php`, `app/Listeners/RecordFailedLogin.php`, `app/Listeners/RecordLogout.php`, `tests/Feature/HU013/LoginAuditTest.php`.
- **Pruebas (HU-013):** "Registro de intento" (éxito y fallo vía página de login de Filament con `Livewire::test`), la contraseña no aparece en ninguna columna.

#### T-1-18 · *Policy* de auditoría — Dev 3
- **Qué:** `AuditEventPolicy`: `update`/`delete`/`create` siempre `false`; `viewAny`/`view` con permiso `audit.view` (para HU-014).
- **Archivos:** `app/Policies/AuditEventPolicy.php`, `tests/Feature/HU013/AuditPolicyTest.php`.
- **Pruebas (HU-013):** "Inmutabilidad" a nivel de aplicación.

#### T-1-19 · Spike: peso del login en 3G — Dev 3 (timebox 1 día)
- **Qué:** medir `/admin/login` en el entorno local/demostración con `php artisan optimize` y recursos compilados, usando Chrome DevTools (perfil "Slow 3G") y Lighthouse: bytes transferidos, tiempo hasta interactivo. Si supera 200 KB / 10 s, proponer medidas en la aplicación (recursos mínimos, fuentes del sistema); la compresión del servidor web se anota como recomendación para una implementación real.
- **Entregable:** resultados y decisión en la sección "Decisiones técnicas" de este sprint; tareas nuevas si hacen falta.

#### T-1-20 · Spike: MFA por rol en Filament 5 — Dev 3 (timebox 1 día)
- **Qué:** prototipo en rama descartable: activar MFA de app autenticadora con códigos de recuperación (10), exigirlo según `StaffRole::isAdministrative()` aunque el usuario entre por `/docente`, y engancharse al código incorrecto para sumar al bloqueo de HU-004.
- **Entregable:** nota en "Decisiones técnicas" y, si cambia algo, actualización de [[ADR-005 Stack PHP Laravel y Filament]] §4; tareas del Sprint 2 ajustadas.

#### T-1-21 · Verificación de la DoD de experiencia — Dev 3
- **Qué:** en el entorno de demostración (`colegio:demo`), recorrer HU-001, HU-002, HU-006, HU-007 en Chrome, Firefox y Android, con red 3G simulada, navegación por teclado y contraste (Lighthouse Accesibilidad ≥ 90).
- **Entregable:** lista de verificación en esta nota; defectos como tareas o *bugs*.

#### T-1-22 · Pint sin exclusiones — Dev 2 ⚠️ debe completarse primero (día 1, mañana)
- **Qué:** quitar los 20 `notPath` de `pint.json` y ejecutar `vendor/bin/pint` para aplicar `declare(strict_types=1)` y el formato a los archivos del esqueleto; eliminar `tests/Unit/ExampleTest.php` (prueba trivial). Integrar **antes** de que Dev 1 edite `AppServiceProvider.php` (T-1-06) y `config/session.php` (T-1-04), y antes de que Dev 2 edite `bootstrap/app.php` (T-1-14).
- **Archivos:** `pint.json`, `tests/Unit/ExampleTest.php` y, solo por formato, los 20 archivos listados en `notPath` (excepción acordada a la regla de dueños: cambio mecánico, un solo PR, avisando al equipo).
- **Terminado:** `pint.json` sin `notPath`; `pint --test`, `phpstan` y `pest` en verde.

#### T-1-23 · CI sin filtro `paths` y primera ejecución — Dev 2
- **Qué:** en `.github/workflows/app-colegio.yml`, quitar el filtro `paths` del disparador `pull_request` para que los 4 trabajos siempre informen (dejarlo en `push` es opcional); abrir el primer PR y verificar en GitHub los 4 trabajos en verde. Con eso el SM pide al administrador del repositorio la protección de `main` (TEC-20).
- **Archivos:** `.github/workflows/app-colegio.yml`.
- **Terminado:** enlace a una ejecución en verde anotado en "Decisiones técnicas"; un PR que solo toca el vault también muestra los 4 trabajos.

## Decisiones técnicas
- **Heredado del Sprint 0 (13/11):** `User` usa los atributos de Laravel 13 `#[Fillable]` y `#[Hidden]`; las columnas nuevas se agregan ahí (o en *traits* con sus *casts*), no con `$fillable`/`$hidden`. Los *PanelProviders* ya usan `PreventRequestForgery` (nombre de Laravel 13 para la protección CSRF).
- **Taller de roles (03/11):** no registró decisiones. T-1-09 parte de la matriz vigente en [[Roles y permisos RBAC]]; los cambios posteriores se cargan en el *seeder*.
- _(completar durante el sprint: resultados de T-1-19, T-1-20 y T-1-23)_

## Riesgos del sprint
- Definición final de roles pendiente con dirección → usar roles base de [[Roles y permisos RBAC]].
- Personalizar el login de Filament exige conocer sus internos (T-1-02/T-1-03) → *pairing* Dev 1 + Dev 2 si se atasca más de medio día.
- Muchos archivos compartidos el primer día (`User.php`, *PanelProviders*) → respetar los dueños de archivo de los [[Paquetes MOC|paquetes de trabajo]].

## Daily Scrum
_Enlazar aquí las notas diarias de `07-Reuniones`._

## Sprint Review
_Pendiente — usar [[Plantilla Sprint Review]]._

## Retrospectiva
_Pendiente — usar [[Plantilla Retrospectiva]]._
