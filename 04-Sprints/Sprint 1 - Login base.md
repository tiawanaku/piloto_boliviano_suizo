---
tipo: sprint
numero: 1
inicio: 2026-11-16
fin: 2026-11-27
estado: terminado
puntos_comprometidos: 17
puntos_terminados: 17
aceptacion: pendiente de la Sprint Review (verificación manual de la DoD de experiencia)
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
| [[HU-001 Iniciar sesion con correo institucional]] | 5 | terminada (código y pruebas) · UX manual pendiente |
| [[HU-007 Panel segun rol]] | 5 | terminada (código y pruebas) · UX manual pendiente |
| [[HU-002 Cerrar sesion]] | 1 | terminada (código y pruebas) · UX manual pendiente |
| [[HU-006 Cambio de contrasena en primer ingreso]] | 3 | terminada (código y pruebas) · UX manual pendiente |
| [[HU-013 Registro de auditoria de accesos]] | 3 | terminada (código y pruebas) · UX manual pendiente |
| **Total** | **17** | |

## Tablero
> Cerrado el 27/11/2026. El estado de cada tarea está en la sección [[#Tareas técnicas]] y el resumen en [[#Cierre del sprint (27/11/2026)]].

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
- [x] Hecho (Dev 1). Desde T-1-02 registra `Pages\Auth\Login`.
- **Qué:** clase `App\Filament\Support\StaffPanel::configure(Panel $panel): Panel` con lo común a `admin` y `docente`: página de login (`Pages\Auth\Login`), *middleware* de autenticación compartido, marca y colores. Ambos *PanelProviders* la invocan (cambio de una línea; luego los *providers* pasan a Dev 2).
- **Archivos:** `app/Filament/Support/StaffPanel.php`, `app/Providers/Filament/AdminPanelProvider.php`, `app/Providers/Filament/DocentePanelProvider.php` (solo esa línea).
- **Pruebas:** las de `tests/Feature/Panels/PanelAccessTest.php` siguen en verde.

#### T-1-02 · Login personalizado: validaciones y mensajes — Dev 1
- [x] Hecho (Dev 1, oleada 2).
- **Qué:** `App\Filament\Pages\Auth\Login` extiende el login de Filament: etiquetas en español, contraseña con mostrar/ocultar, regla `InstitutionalEmail` (dominio de `config('colegio.dominio_institucional')`), mensaje genérico "Correo o contraseña incorrectos".
- **Archivos:** `app/Filament/Pages/Auth/Login.php`, `app/Rules/InstitutionalEmail.php`, `lang/es/auth.php`, `tests/Feature/HU001/LoginValidationTest.php`, `tests/Unit/Rules/InstitutionalEmailTest.php`.
- **Pruebas (HU-001):** "Credenciales incorrectas" (mismo mensaje con correo existente y no existente), "Correo no institucional", "Campos vacíos".

#### T-1-03 · Login: estados de cuenta e ingreso exitoso — Dev 1
- [x] Hecho (Dev 1, oleada 3).
- **Qué:** antes de autenticar, verificar `AccountStatus`: `Deactivated` → "Tu cuenta no está activa. Comunícate con secretaría o la oficina de información"; `Pending` → mismo mensaje genérico de cuenta no activa. Al ingresar, regenerar la sesión.
- **Archivos:** `app/Filament/Pages/Auth/Login.php`, `lang/es/auth.php`, `tests/Feature/HU001/LoginSuccessTest.php`.
- **Pruebas (HU-001):** "Inicio de sesión exitoso" (autenticado y redirigido al panel según rol — usa T-1-12), "Cuenta desactivada".

#### T-1-04 · Cierre de sesión, inactividad y "atrás" — Dev 1
- [x] Hecho (Dev 1, oleada 2).
- **Qué:** `SESSION_LIFETIME` leído de `config('colegio.sesion_inactividad_minutos')` en `config/session.php`; cookies `http_only`, `same_site=lax` y `secure` vía `SESSION_SECURE_COOKIE` (activo solo si la demostración usa HTTPS); *middleware* `PreventBackHistory` (`Cache-Control: no-store, private`) registrado en `StaffPanel`; logout de Filament invalida la sesión.
- **Archivos:** `config/session.php`, `app/Http/Middleware/PreventBackHistory.php`, `app/Filament/Support/StaffPanel.php`, `tests/Feature/HU002/LogoutTest.php`.
- **Pruebas (HU-002):** "Cerrar sesión manualmente" (fila de `sessions` eliminada, redirección al login, cabecera `no-store`), "Expiración por inactividad" (`$this->travel(31)->minutes()` → redirige al login).

#### T-1-05 · Cabeceras de seguridad — Dev 1
- [x] Hecho (Dev 1, oleada 2).
- **Qué:** *middleware* `SecurityHeaders`: `X-Frame-Options: DENY`, `X-Content-Type-Options: nosniff`, `Referrer-Policy: strict-origin-when-cross-origin`, HSTS solo cuando la petición es HTTPS, `Content-Security-Policy-Report-Only` compatible con Livewire/Alpine. Registrado en `StaffPanel`.
- **Archivos:** `app/Http/Middleware/SecurityHeaders.php`, `app/Filament/Support/StaffPanel.php`, `tests/Feature/Security/SecurityHeadersTest.php`.
- **Pruebas:** cabeceras presentes en `/admin/login`.

#### T-1-06 · Política de contraseñas y columnas de contraseña temporal — Dev 1
- [x] Hecho (Dev 1); `Password::defaults()` registrado en `AppServiceProvider` en la oleada 2.
- **Qué:** migración `add_temporary_password_columns_to_users_table` (`must_change_password` bool, `temporary_password_expires_at` nullable); trait `App\Models\Concerns\HasTemporaryPassword` (*casts* y `temporaryPasswordExpired()`); `Password::defaults()` en `AppServiceProvider` (mín. 10, `uncompromised()`), regla `NotCommonPassword` con lista local `resources/data/common-passwords.txt`; mensajes en `lang/es/passwords.php`.
- **Archivos:** `database/migrations/2026_11_16_100000_add_temporary_password_columns_to_users_table.php`, `app/Models/Concerns/HasTemporaryPassword.php`, `app/Providers/AppServiceProvider.php`, `app/Rules/NotCommonPassword.php`, `resources/data/common-passwords.txt`, `tests/Unit/Rules/PasswordPolicyTest.php`.
- **Pruebas (HU-006):** "Política de contraseña" (menos de 10 caracteres y contraseña común, cada una con su mensaje). `uncompromised()` se simula con `Http::fake()`.
- **Integración:** Dev 2 agrega `use HasTemporaryPassword;` en `User` (dueño de `User.php`).

#### T-1-07 · Página "Cambiar contraseña" obligatoria — Dev 1
- [x] Hecho (Dev 1, oleada 2).
- **Qué:** página `App\Filament\Pages\Auth\ChangeTemporaryPassword` y *middleware* `EnsurePasswordIsChanged` (registrado en `StaffPanel`) que redirige a ella mientras `must_change_password` sea verdadero; contraseña temporal vencida (> 72 h) bloquea el login con "Tu contraseña temporal venció. Solicita una nueva a secretaría". Indicador de fortaleza simple.
- **Archivos:** `app/Filament/Pages/Auth/ChangeTemporaryPassword.php`, `resources/views/filament/pages/auth/change-temporary-password.blade.php` (si hace falta), `app/Http/Middleware/EnsurePasswordIsChanged.php`, `app/Filament/Support/StaffPanel.php`, `app/Filament/Pages/Auth/Login.php`, `tests/Feature/HU006/TemporaryPasswordTest.php`.
- **Pruebas (HU-006):** "Contraseña temporal" (cualquier URL del panel redirige al cambio), "Contraseña temporal vencida".

#### T-1-08 · spatie/laravel-permission y enums — Dev 2 ⚠️ temprano (día 1–2)
- **Qué:** `composer require spatie/laravel-permission:^8.3`; publicar config y migración adaptadas a UUID (`model_morph_key` = `model_uuid`, columnas `uuid`); `User` usa `HasRoles`. Enums `App\Enums\StaffRole` (7 roles, `label()`, `isAdministrative()`, `priority()`) y `App\Enums\Permission` (permisos de la matriz, p. ej. `staff.invite`, `roles.assign_high`, `accounts.deactivate`, `accounts.unlock`, `mfa.reset`, `audit.view`, `staff.view`, `staff.edit_email`).
- **Archivos:** `composer.json`, `composer.lock`, `config/permission.php`, `database/migrations/2026_11_16_090000_create_permission_tables.php`, `app/Models/User.php`, `app/Enums/StaffRole.php`, `app/Enums/Permission.php`, `lang/es/roles.php`, `lang/es/permissions.php`, `tests/Unit/Enums/StaffRoleTest.php`.
- [x] Hecho (Dev 2). El paquete ya estaba en `composer.json`/`composer.lock` (8.3.2); no hubo descargas. `User` también incorpora `HasTemporaryPassword` (Dev 1).

#### T-1-09 · *Seeder* de la matriz RBAC — Dev 2
- **Qué:** `RolesAndPermissionsSeeder` idempotente que replica [[Roles y permisos RBAC]] validada en el [[2026-11-03 Taller - Roles y permisos]]; llamado desde `DatabaseSeeder` y desde el despliegue.
- **Archivos:** `database/seeders/RolesAndPermissionsSeeder.php`, `database/seeders/DatabaseSeeder.php`, `tests/Feature/Rbac/PermissionMatrixTest.php`.
- **Pruebas:** *dataset* Pest rol × permiso que verifica cada celda de la matriz; ejecutar el *seeder* dos veces no duplica.
- [x] Hecho (Dev 2). `tests/Feature/Rbac/PermissionMatrixTest.php`: 147 celdas, idempotencia y asignación a usuario UUID.

#### T-1-10 · *Factories*, *helpers* y cuentas semilla — Dev 2
- **Qué:** estados de `UserFactory`: `active()`, `pending()`, `deactivated()`, `withTemporaryPassword()`, `withRoles(StaffRole ...)`; *helper* global `actingAsStaff(StaffRole ...$roles)` en `tests/Pest.php`; comando `colegio:crear-cuenta {correo} {--rol=*}` (solo correos ficticios del dominio configurado) que crea una cuenta activa con contraseña temporal (72 h) y la muestra una sola vez (temporal hasta [[HU-009 Invitar personal]]).
- **Archivos:** `database/factories/UserFactory.php`, `tests/Pest.php`, `app/Console/Commands/CreateStaffAccount.php`, `tests/Feature/Commands/CreateStaffAccountTest.php`.
- **Pruebas:** el comando crea la cuenta con los roles y `must_change_password = true`; rechaza correos fuera del dominio.
- [x] Hecho (Dev 2). Además: `withPrimaryRole()`, `RolesAndPermissionsSeeder::ensureSeeded()` y cuentas de demostración por rol en `DatabaseSeeder` (`demo@` = Coordinación + Docente). Textos del comando en `lang/es/staff_account.php`.

#### T-1-11 · Acceso a paneles por rol y rol principal — Dev 2
- **Qué:** `User::canAccessPanel()`: `admin` → algún rol administrativo y cuenta activa; `docente` → rol `teacher` y cuenta activa. Migración `add_primary_role_to_users_table`; método `primaryPanelId()` (rol principal o prioridad por defecto).
- **Archivos:** `app/Models/User.php`, `database/migrations/2026_11_16_110000_add_primary_role_to_users_table.php`, `tests/Feature/HU007/PanelAuthorizationTest.php`.
- **Pruebas (HU-007):** *dataset* rol × panel (permitido/403); cuenta desactivada → 403 en ambos.
- [x] Hecho (Dev 2). `tests/Feature/Panels/PanelAccessTest.php` ajustada (las cuentas necesitan rol).

#### T-1-12 · Redirección al panel principal — Dev 2
- **Qué:** implementación propia del contrato `LoginResponse` de Filament que redirige a la URL del panel principal; registrada en un nuevo `StaffAuthServiceProvider`.
- **Archivos:** `app/Http/Responses/StaffLoginResponse.php`, `app/Providers/StaffAuthServiceProvider.php`, `bootstrap/providers.php`, `tests/Feature/HU007/LoginRedirectTest.php`.
- **Pruebas (HU-007):** "Docente" → `/docente`; "Administrativo" → `/admin`.
- [x] Hecho (Dev 2). Descarta `url.intended`. Falta que el login de un panel acepte a quien solo puede entrar al otro (T-1-03, Dev 1).

#### T-1-13 · Cambio de panel y panel docente vacío — Dev 2
- **Qué:** ítem del menú de usuario "Cambiar a panel docente/administrativo" en cada *PanelProvider*, visible solo si `canAccessPanel()` del otro panel es verdadero; *dashboard* docente con el mensaje "Tus aulas aparecerán aquí cuando coordinación te asigne materias".
- **Archivos:** `app/Providers/Filament/AdminPanelProvider.php`, `app/Providers/Filament/DocentePanelProvider.php`, `app/Filament/Docente/Pages/Dashboard.php`, `lang/es/panels.php`, `tests/Feature/HU007/PanelSwitchTest.php`.
- **Pruebas (HU-007):** "Varios roles" (entra al principal, ve el ítem y abre el otro panel sin nuevo login); usuario con un solo rol no ve el ítem.
- [x] Hecho (Dev 2). Ítem en `App\Filament\Support\PanelSwitchAction`; el *dashboard* docente se registra por descubrimiento.

#### T-1-14 · 403 en español y registro del acceso denegado — Dev 2
- **Qué:** vista `errors/403.blade.php` liviana con "No tienes permiso para ver esta página" y enlace a su panel; en `bootstrap/app.php` (`withExceptions`) registrar `access.denied` con `AuditLogger` (URL, usuario, IP).
- **Archivos:** `resources/views/errors/403.blade.php`, `bootstrap/app.php`, `lang/es/errors.php`, `tests/Feature/HU007/UnauthorizedAccessTest.php`.
- **Pruebas (HU-007):** "Acceso no autorizado por URL" (docente → `/admin` = 403 con el texto y un `AuditEvent` `access.denied`).
- [x] Hecho (Dev 2). Callback de render `App\Exceptions\RecordAccessDenied` en `bootstrap/app.php`: registra todo 403 (también los de *Gate*/*Policy*) con contexto `method`, `path` (sin *query string*) y `panel`; si la auditoría falla, se reporta y la página 403 se muestra igual. La vista no usa JS ni recursos externos y enlaza a `primaryPanelUrl()`.

#### T-1-15 · `audit_events`, modelo inmutable y `AuditLogger` — Dev 3 ⚠️ temprano (día 1–2; lo usa T-1-14)
- **Qué:** migración `create_audit_events_table` (UUID, `occurred_at`, `event_type`, `actor_id` nullable, `subject_type`/`subject_id` nullable, `email_attempted`, `result`, `ip_address` (`ipAddress()`), `user_agent`, `context` json/jsonb; índices por fecha, tipo y actor); enum `AuditEventType`; modelo `AuditEvent` que lanza excepción en `updating`/`deleting`; servicio `App\Services\AuditLogger::record()` que filtra claves sensibles (`password`, `token`, `secret`, `code`…).
- **Archivos:** `database/migrations/2026_11_16_080000_create_audit_events_table.php`, `app/Models/AuditEvent.php`, `app/Enums/AuditEventType.php`, `app/Services/AuditLogger.php`, `lang/es/audit.php`, `tests/Unit/Services/AuditLoggerTest.php`.
- **Pruebas:** registra un evento con contexto; nunca guarda claves sensibles; `update()`/`delete()` lanzan excepción.
- [x] Hecho (Dev 3). API: `app(AuditLogger::class)->record(AuditEventType $type, actor:, subject:, email:, result:, context:)`; IP y navegador salen de `request()`. Resultados en `AuditEvent::RESULT_SUCCESS|FAILURE|DENIED` (por defecto según el tipo). Tipos: `login.succeeded`, `login.failed`, `logout`, `access.denied`, `audit.exported`.

#### T-1-16 · *Trigger* de inmutabilidad — Dev 3
- **Qué:** migración que crea los *triggers* que rechazan `UPDATE`/`DELETE` en `audit_events`: rama `sqlite` (`BEFORE UPDATE/DELETE … SELECT RAISE(ABORT, …)`), usada en el piloto, y rama `pgsql` (función + *trigger*) preparada para una implementación real. Sin purga por retención (fuera del alcance del piloto).
- **Archivos:** `database/migrations/2026_11_16_080100_add_immutability_trigger_to_audit_events.php`, `tests/Feature/HU013/AuditImmutabilityDatabaseTest.php` (corre en la suite normal con SQLite).
- **Pruebas (HU-013):** "Inmutabilidad" a nivel de base de datos (`DB::table()->update()` falla).
- [x] Hecho (Dev 3). Probado `migrate:fresh` y `rollback` en SQLite en archivo; la rama `pgsql` (función + *triggers* `UPDATE`/`DELETE` por fila y `TRUNCATE`) no se ejecuta en el piloto.

#### T-1-17 · *Listeners* de login y logout — Dev 3
- **Qué:** *listeners* descubiertos automáticamente para `Illuminate\Auth\Events\Login`, `Failed`, `Logout`: registran fecha/hora, correo intentado, resultado, IP y navegador; nunca la contraseña.
- **Archivos:** `app/Listeners/RecordSuccessfulLogin.php`, `app/Listeners/RecordFailedLogin.php`, `app/Listeners/RecordLogout.php`, `tests/Feature/HU013/LoginAuditTest.php`.
- **Pruebas (HU-013):** "Registro de intento" (éxito y fallo vía página de login de Filament con `Livewire::test`), la contraseña no aparece en ninguna columna.
- [x] Hecho (Dev 3). Las pruebas usan `getLoginRouteAction()` del panel, así siguen valiendo cuando T-1-02 cambie la página de login.

#### T-1-18 · *Policy* de auditoría — Dev 3
- **Qué:** `AuditEventPolicy`: `update`/`delete`/`create` siempre `false`; `viewAny`/`view` con permiso `audit.view` (para HU-014).
- **Archivos:** `app/Policies/AuditEventPolicy.php`, `tests/Feature/HU013/AuditPolicyTest.php`.
- **Pruebas (HU-013):** "Inmutabilidad" a nivel de aplicación.
- [x] Hecho (Dev 3). `viewAny`/`view` exigen `Permission::AuditView` y cuenta activa; prueba con la matriz sembrada (`RolesAndPermissionsSeeder`): solo `director` e `it_support`.

#### T-1-19 · Spike: peso del login en 3G — Dev 3 (timebox 1 día)
- **Qué:** medir `/admin/login` en el entorno local/demostración con `php artisan optimize` y recursos compilados, usando Chrome DevTools (perfil "Slow 3G") y Lighthouse: bytes transferidos, tiempo hasta interactivo. Si supera 200 KB / 10 s, proponer medidas en la aplicación (recursos mínimos, fuentes del sistema); la compresión del servidor web se anota como recomendación para una implementación real.
- **Entregable:** resultados y decisión en la sección "Decisiones técnicas" de este sprint; tareas nuevas si hacen falta.
- [x] Hecho (Dev 3). Resultado en [[Spike T-1-19 Peso del login en 3G]]: ≈ 1,38 MB sin comprimir / ≈ 334 KB con gzip; **no cumple 200 KB**. Medido con script (sin Chrome/Lighthouse en el entorno; repetir con DevTools en un equipo con navegador).

#### T-1-20 · Spike: MFA por rol en Filament 5 — Dev 3 (timebox 1 día)
- **Qué:** prototipo en rama descartable: activar MFA de app autenticadora con códigos de recuperación (10), exigirlo según `StaffRole::isAdministrative()` aunque el usuario entre por `/docente`, y engancharse al código incorrecto para sumar al bloqueo de HU-004.
- **Entregable:** nota en "Decisiones técnicas" y, si cambia algo, actualización de [[ADR-005 Stack PHP Laravel y Filament]] §4; tareas del Sprint 2 ajustadas.
- [x] Hecho (Dev 3). Resultado en [[Spike T-1-20 MFA por rol]]; propuesta de ajuste del ADR-005 §4 para el Scrum Master (sin editar el ADR).

#### T-1-21 · Verificación de la DoD de experiencia — Dev 3
- **Qué:** en el entorno de demostración (`colegio:demo`), recorrer HU-001, HU-002, HU-006, HU-007 en Chrome, Firefox y Android, con red 3G simulada, navegación por teclado y contraste (Lighthouse Accesibilidad ≥ 90).
- **Entregable:** lista de verificación en esta nota; defectos como tareas o *bugs*.
- [x] Hecho (Dev 3), con alcance reducido: el entorno no tiene navegador, así que se recorrió por HTTP (script que maneja el login de Livewire) sobre `colegio:demo --force` en una copia local. **Pendiente manual (sin navegador no se pudo):** Chrome, Firefox y Android reales, 3G simulada en DevTools, contraste y Lighthouse Accesibilidad ≥ 90.

  **Lista de verificación (28/10):**
  - [x] HU-001/HU-007: las 7 cuentas demo entran y llegan a su panel: 5 administrativas → `/admin` "Escritorio" (`/docente` = 403); `teacher` → `/docente` "Mis aulas" aunque entre por `/admin/login` (`/admin` = 403); `demo` (varios roles) ve "Cambiar a panel" y abre ambos paneles.
  - [x] HU-001: contraseña incorrecta → "Correo o contraseña incorrectos." (genérico); correo de otro dominio → "Usa tu correo institucional (termina en @colegio-piloto.test)."
  - [x] HU-007: 403 en español ("No tienes permiso para ver esta página", enlace "Ir a mi panel").
  - [x] HU-002: "Salir" vuelve a `/admin/login`; después `/admin` redirige al login; las páginas del panel responden `Cache-Control: no-store, private`.
  - [x] HU-006: una cuenta creada con `colegio:crear-cuenta` (contraseña temporal) es llevada a `/docente/cambiar-contrasena` ("Define tu contraseña").
  - [x] Accesibilidad básica del HTML: `lang="es"`; cada campo tiene `<label for>`; `autocomplete` `username`/`current-password`; foco inicial en el correo; botón "Mostrar contraseña" con `aria-label` y `type="button"`; enlace "Saltar al contenido" en el panel; título de página "Acceso - Colegio Virtual".
  - [ ] **Defecto (textos):** se mezcla "usted" y "tú": el login dice "Entre a su cuenta" (traducción de Filament) y `auth.throttle` dice "Intente…", mientras que el resto usa "tú" ("Usa tu correo…", "No tienes permiso…"). → Tarea Sprint 2: unificar en "tú" (`lang/es/auth.php` y `lang/vendor/filament-panels/es`).
  - [ ] **Riesgo (HU-004):** el límite de Filament en el login es de **5 intentos por minuto por IP**, y cuenta también los ingresos correctos (lo vimos al recorrer las cuentas demo). Si varias personas del colegio comparten una IP pública (oficina, NAT), se bloquean entre sí. → Revisar con el bloqueo por cuenta de HU-004 (Dev 1).
  - [ ] Peso del login en 3G: no cumple 200 KB (ver T-1-19).

#### T-1-22 · Pint sin exclusiones — Dev 2 ⚠️ debe completarse primero (día 1, mañana)
- **Qué:** quitar los 20 `notPath` de `pint.json` y ejecutar `vendor/bin/pint` para aplicar `declare(strict_types=1)` y el formato a los archivos del esqueleto; eliminar `tests/Unit/ExampleTest.php` (prueba trivial). Integrar **antes** de que Dev 1 edite `AppServiceProvider.php` (T-1-06) y `config/session.php` (T-1-04), y antes de que Dev 2 edite `bootstrap/app.php` (T-1-14).
- **Archivos:** `pint.json`, `tests/Unit/ExampleTest.php` y, solo por formato, los 20 archivos listados en `notPath` (excepción acordada a la regla de dueños: cambio mecánico, un solo PR, avisando al equipo).
- **Terminado:** `pint.json` sin `notPath`; `pint --test`, `phpstan` y `pest` en verde.
- [x] Hecho (Dev 2). Pint reformateó los 19 archivos (strict types; migraciones de caché/colas con formato de clase); `tests/Unit/ExampleTest.php` eliminado.

#### T-1-23 · CI sin filtro `paths` y primera ejecución — Dev 2
- **Qué:** en `.github/workflows/app-colegio.yml`, quitar el filtro `paths` del disparador `pull_request` para que los 4 trabajos siempre informen (dejarlo en `push` es opcional); abrir el primer PR y verificar en GitHub los 4 trabajos en verde. Con eso el SM pide al administrador del repositorio la protección de `main` (TEC-20).
- **Archivos:** `.github/workflows/app-colegio.yml`.
- **Terminado:** enlace a una ejecución en verde anotado en "Decisiones técnicas"; un PR que solo toca el vault también muestra los 4 trabajos.
- [x] Workflow sin `paths` en `pull_request` (se mantiene en `push` a `main`) (Dev 2). Pendiente: la primera ejecución en GitHub la verifica el coordinador en el PR #1.

## Decisiones técnicas
- **Heredado del Sprint 0 (13/11):** `User` usa los atributos de Laravel 13 `#[Fillable]` y `#[Hidden]`; las columnas nuevas se agregan ahí (o en *traits* con sus *casts*), no con `$fillable`/`$hidden`. Los *PanelProviders* ya usan `PreventRequestForgery` (nombre de Laravel 13 para la protección CSRF).
- **Taller de roles (03/11):** no registró decisiones. T-1-09 parte de la matriz vigente en [[Roles y permisos RBAC]]; los cambios posteriores se cargan en el *seeder*.
- **Auditoría (T-1-15 a T-1-18, Dev 3):** `audit_events.actor_id` **sin clave foránea** a `users`: un `ON DELETE SET NULL` sería un `UPDATE` que el *trigger* rechaza, y el registro debe sobrevivir a la cuenta. `AuditLogger` elimina (no enmascara) las claves de contexto que contienen `password`, `token`, `secret`, `otp`, `recovery`, `credential`, `api_key`, `authorization`, `cookie`, o que son `code`/`*_code(s)`, a cualquier profundidad; el correo se guarda en minúsculas. Los *listeners* son síncronos (no `ShouldQueue`) para no perder eventos. Un login fallido de una cuenta existente guarda la cuenta como `subject` (no como `actor`). La prueba unitaria de `AuditLogger` declara `uses(TestCase, RefreshDatabase)` en el propio archivo porque `tests/Pest.php` solo enlaza `Feature` y `Unit/Models`.
- **Spike MFA (T-1-20, Dev 3):** viable con el MFA nativo de Filament 5 y sin dependencias nuevas. `isRequired` de Filament se evalúa al registrar rutas (por panel, no por usuario), por eso: proveedor `AppAuthentication` (10 códigos) en ambos paneles, `isRequired: true` y *middleware* propio `EnsureAdministrativeMfa` que lo exige solo a roles administrativos. Filament no emite evento con código incorrecto → evento propio para HU-004. Al activarlo fallan 16 pruebas actuales: en el Sprint 2 primero hay que adaptar *factories*/*helpers* (`withMfa()`). Detalle en [[Spike T-1-20 MFA por rol]].
- **Spike peso del login (T-1-19, Dev 3):** `/admin/login` pesa ≈ 1,38 MB sin comprimir y ≈ 334 KB con gzip (12 solicitudes; Livewire 84 KB, CSS de Filament 67 KB, Inter 67 KB, `support.js` 64 KB, `echo.js` 24 KB). En Slow 3G son unos 28 s sin compresión y unos 9–11 s con gzip. Propuesta: fuentes del sistema (≈ −67 KB, probado), compresión + caché larga en el servidor web (implementación real) y revisar con el PO el presupuesto de 200 KB (realista con Filament: ≈ 250–270 KB en la primera visita). Detalle y propuesta para el ADR en [[Spike T-1-19 Peso del login en 3G]].
- **Etiquetas de auditoría (bug de Dev 3, reportado por Dev 1):** `__()` interpreta los puntos de `login.succeeded` como anidación. Las claves de `lang/es/audit.php` usan `_` (`AuditEventType::translationKey()`); una prueba recorre todos los casos del enum.
- **T-1-23 (cierre):** la primera ejecución real del CI en GitHub quedó en verde en el PR #1. El SM verificó por la API REST los 4 *check runs* (`pint`, `phpstan`, `pest`, `audit`) sobre el commit `7fd6d77`.
- **Decisiones del SM sobre los *spikes*:** aplicadas en [[ADR-005 Stack PHP Laravel y Filament]] §4 (ver [[2026-11-27 Retrospectiva - Sprint 1]]).

- **Dev 1 (T-1-01/T-1-06):** `StaffPanel::configure()` concentra login, guard, marca, colores y *middleware*; los *PanelProviders* solo definen id, ruta y descubrimiento. El *trait* `HasTemporaryPassword` agrega sus *casts* con `initializeHasTemporaryPassword()` (no hace falta tocar `casts()` de `User`) y ofrece `markPasswordAsTemporary()` (usa `colegio.contrasena_temporal_horas`), `clearTemporaryPassword()` y `temporaryPasswordExpired()`. Política: `Password::min(10)->uncompromised()->rules([new NotCommonPassword])`; la lista local se compara sin mayúsculas ni espacios extremos.
- **Dev 2 (T-1-08/T-1-09):** tablas de spatie con `model_uuid` (UUID) y sin *teams*; la migración usa nombres literales. Permisos (21, `recurso.accion`) en `App\Enums\Permission`, uno por fila de la matriz; "Desbloquear / restablecer MFA" se separa en `accounts.unlock` y `mfa.reset`, y "Ver y corregir la ficha" en `staff.view`, `staff.edit` y `staff.edit_email` (solo TI). `StaffRole` incluye `student` (7 roles) sin permisos hasta la Fase 4. `priority()`: Dirección 100, Secretaría 90, Coordinación 80, TI 70, Oficina 60, Docente 50, Estudiante 10 (orden de la matriz; a confirmar con dirección). La matriz vive en `RolesAndPermissionsSeeder::matrix()` y la prueba mantiene una copia independiente. El *seeder* limpia la caché de spatie a mano porque `DatabaseSeeder` usa `WithoutModelEvents`.
- **Dev 2 (T-1-10 a T-1-13):** URL de destino tras el login: `User::primaryPanelUrl()` (null si no tiene panel o la cuenta no está activa); también `primaryPanelId()`, `primaryRole()` y `staffRoles()` (ordenados por prioridad). `primary_role` se ignora si el usuario ya no tiene ese rol. Panel de cada rol: `StaffRole::panelId()` (`ADMIN_PANEL`/`TEACHER_PANEL`). `StaffLoginResponse` siempre va al panel principal y descarta `url.intended` (podía apuntar a un panel sin acceso). `canAccessPanel()` exige cuenta activa y un rol del panel; una cuenta activa sin roles recibe 403 en ambos.

- **Dev 1 (oleada 2):** el mensaje genérico de login vive en `auth.login.failed` ("Correo o contraseña incorrectos."); `auth.failed` no se cambió porque lo verifica `SpanishMessagesTest`. La contraseña temporal vencida se detecta en `Login::isUserAllowedToAccessPanel()` (dentro del *timebox* y tras validar credenciales: con contraseña errónea solo se ve el mensaje genérico) y dispara `Failed`, así que queda auditada como intento fallido. `session.lifetime` usa la misma variable que `colegio.sesion_inactividad_minutos` (`COLEGIO_SESION_INACTIVIDAD_MINUTOS`); `SESSION_LIFETIME` ya no se usa. La página "Define tu contraseña" es una `SimplePage` en `/{panel}/cambiar-contrasena` (ruta `auth.change-temporary-password`, registrada en `StaffPanel`); al guardar actualiza `password_hash_web` en sesión para que `AuthenticateSession` no cierre la sesión. Indicador de fortaleza en el navegador (Alpine), sin enviar la contraseña al servidor. CSP en modo informe con `'unsafe-inline'`/`'unsafe-eval'` (Livewire/Alpine), `fonts.bunny.net` y `ui-avatars.com`.

- **Dev 1 (oleada 3):** el estado de la cuenta se evalúa en `Login::isUserAllowedToAccessPanel()` tras validar credenciales: pendiente/desactivada → "Tu cuenta no está activa…"; bloqueada o sin roles → mensaje genérico. Se acepta a quien tenga `primaryPanelId() !== null` aunque entre por el login del otro panel (`StaffLoginResponse` lo redirige). Nuevo `AuditEventType::PasswordChanged` (`password.changed`), registrado al definir la contraseña propia, sin contraseña ni hash. Hallazgo: `AuditEventType::label()` no traduce los valores con punto (`login.succeeded`, `password.changed`…) porque `__()` interpreta el punto como anidación; solo `logout` funciona.

## Riesgos del sprint
- Definición final de roles pendiente con dirección → usar roles base de [[Roles y permisos RBAC]].
- Personalizar el login de Filament exige conocer sus internos (T-1-02/T-1-03) → *pairing* Dev 1 + Dev 2 si se atasca más de medio día.
- Muchos archivos compartidos el primer día (`User.php`, *PanelProviders*) → respetar los dueños de archivo de los [[Paquetes MOC|paquetes de trabajo]].

## Daily Scrum
_Enlazar aquí las notas diarias de `07-Reuniones`._

## Cierre del sprint (27/11/2026)
> Verificación del [[Scrum Master]] sobre la rama del PR #1 (commit `7fd6d77`).

### Evidencias
- **Calidad (local):** `pint --test` OK · `phpstan analyse` (nivel 6) 0 errores · `pest` **397/397** (991 aserciones) · `composer audit` sin vulnerabilidades.
- **CI en GitHub:** los 4 trabajos en verde sobre el último commit del PR #1. Se cumple la condición de aceptación de la Review del S0.
- **Escenarios Gherkin:** los 5 escenarios de HU-001, los 2 de HU-002, los 3 de HU-006, los 4 de HU-007 y los 2 de HU-013 tienen pruebas Pest con su nombre, más pruebas de rol sin acceso (403 en ambos paneles) y de auditoría sin contraseñas.
- **Demostración:** `colegio:demo --force`, ejecutado contra una base temporal fuera del repositorio, crea 7 cuentas ficticias: una por rol, más `demo@`, que tiene los roles Coordinación y Docente. Dev 3 recorrió por HTTP el login de cada una (T-1-21).

### Estado
| Historia | Pts | Código y pruebas | DoD de experiencia | Observaciones |
|---|---|---|---|---|
| HU-001 | 5 | ✅ | ⏳ navegadores, Android, 3G y Lighthouse sin verificar | Peso del login ≈ 334 KB con gzip: **no cumple el RNF de 200 KB** (propuesta al PO). Mezcla de "usted" y "tú" en los textos de Filament (DEF-01). |
| HU-007 | 5 | ✅ | ⏳ | — |
| HU-002 | 1 | ✅ | ⏳ | La inactividad se configura con `COLEGIO_SESION_INACTIVIDAD_MINUTOS` (30 por defecto), que alimenta `session.lifetime`. `SESSION_LIFETIME` ya no se usa: es la variable única acordada, no un valor fijo en el código. Queda para TI como variable de entorno. |
| HU-006 | 3 | ✅ | ⏳ | — |
| HU-013 | 3 | ✅ | n/a (sin UI) | `actor_id` sin clave foránea, a propósito (el *trigger* impide `SET NULL`). |
| **Total** | **17** | **17** | **pendiente** | |

**Puntos terminados: 17, condicionados.** El código, las pruebas y el CI cumplen la DoD. Faltan los ítems de experiencia (Chrome, Firefox, Android, 3G simulada, contraste/Lighthouse): el entorno de los agentes no tiene navegador. **La DoD no se relaja.** El SM propone al PO hacer esa verificación manual con una persona con navegador en la Sprint Review, usando la lista de T-1-21. Si una historia falla, vuelve al backlog y la velocidad se corrige.

### Tareas
T-1-01 a T-1-18, T-1-20, T-1-22 y T-1-23: ✅ hechas. T-1-19: ✅ hecha, con resultado negativo frente al RNF. T-1-21: 🟡 parcial (recorrido por HTTP; falta el navegador real).

### Impedimentos
| Impedimento | Estado |
|---|---|
| Protección de `main` (TEC-20): la API sigue devolviendo 403 a la integración | **Abierto**: lo tiene que activar el dueño del repositorio, y ya hay CI verde para exigirlo |
| Sin navegador gráfico en el entorno de los agentes (T-1-19, T-1-21) | **Abierto** → verificación manual en la Review (acción de la retro) |

### Defectos y deuda detectados
Registrados en [[Backlog tecnico#Defectos y deuda del Sprint 1]]: DEF-01 (tono), DEF-02 (*throttle* por IP), TEC-21 (fuentes del sistema), TEC-22 (helpers de MFA para las pruebas).

## Sprint Review
[[2026-11-27 Sprint Review - Sprint 1]]: las 5 historias quedan **aceptadas con condición** (17 pts). Faltan el PR #1 revisado por una persona y fusionado, y la verificación en un navegador real por parte del usuario.

## Retrospectiva
[[2026-11-27 Retrospectiva - Sprint 1]]
