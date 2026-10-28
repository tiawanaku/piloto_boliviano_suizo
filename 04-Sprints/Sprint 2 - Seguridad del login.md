---
tipo: sprint
numero: 2
inicio: 2026-11-30
fin: 2026-12-11
estado: previsto
puntos_comprometidos: 19
tags: [sprint, fase1]
---
# Sprint 2 · Seguridad del login

Volver a [[Sprints MOC]] · Épica: [[EP-01 Login plantel administrativo y docentes]]

## 🎯 Objetivo del sprint (propuesto)
**"Las cuentas del personal están protegidas contra accesos indebidos y cada persona puede recuperar su acceso por sí misma."**

## Sprint Backlog (previsión)
| Historia | Pts |
|---|---|
| [[HU-003 Recuperar contrasena]] | 5 |
| [[HU-004 Bloqueo por intentos fallidos]] | 3 |
| [[HU-005 MFA para personal administrativo]] | 8 |
| [[HU-029 Mi cuenta datos y cambio de contrasena]] | 3 |
| **Total** | **19** |

> Se confirmará en la [[Sprint Planning]] según la velocidad real del Sprint 1.
>
> Revisión del PO (2026-10-28): la previsión anterior (21 pts) superaba la velocidad estimada (15–20). [[HU-008 Gestion de sesiones activas]] pasa al backlog, primera tras la Fase 1, y entra [[HU-029 Mi cuenta datos y cambio de contrasena]]. Si hay que recortar, la siguiente en salir es HU-029. Ver [[2026-10-28 Revision del Product Owner]].

## Capacidad (previsión)
| Developer | Días disponibles | Notas |
|---|---|---|
| Dev 1 | 10 | |
| Dev 2 | 10 | |
| Dev 3 | 10 | |
| **Total** | **30** | Sin feriados nacionales; velocidad estimada 15–20 pts |

## Tareas técnicas
> Definidas por el [[Scrum Master]] el 2026-10-28 ([[2026-10-28 Sprint Planning tecnico - Scrum Master]]); se confirman en la [[Sprint Planning]] del sprint con los resultados de los *spikes* T-1-19 y T-1-20. Stack: [[ADR-005 Stack PHP Laravel y Filament]] · [[Stack tecnologico]] · Paquetes: [[Sprint 2 - Dev 1]], [[Sprint 2 - Dev 2]], [[Sprint 2 - Dev 3]].
>
> **Terminado técnico común:** `vendor/bin/pint --test`, `vendor/bin/phpstan analyse`, `vendor/bin/pest` en verde (CI con SQLite y PostgreSQL); cada escenario Gherkin con su prueba Pest; prueba con rol sin acceso cuando aplica; correos con `Notification::fake()` y en cola; acciones sensibles auditadas; PR revisado.
>
> Reparto: **Dev 1** = recuperación y cambio de contraseña (HU-003, HU-029) · **Dev 2** = bloqueo, administración mínima de cuentas y respaldos (HU-004, TEC-16) · **Dev 3** = MFA (HU-005).

| ID | Tarea | Relacionada | Dev | Depende de |
|---|---|---|---|---|
| T-2-01 | Habilitar en `StaffPanel` restablecimiento, perfil y MFA (con páginas base) ⚠️ **primero** | HU-003, HU-005, HU-029 | Dev 3 | — |
| T-2-02 | Página "¿Olvidaste tu contraseña?" | HU-003 | Dev 1 | T-2-01 |
| T-2-03 | Página de restablecimiento y enlace vencido/usado | HU-003 | Dev 1 | T-2-01 |
| T-2-04 | Acción `UpdateUserPassword` (sesiones, aviso, desbloqueo, auditoría) | HU-003, HU-029 | Dev 1 | T-2-07 |
| T-2-05 | "Mi cuenta": ver mis datos | HU-029 | Dev 1 | T-2-01, T-2-12 |
| T-2-06 | "Mi cuenta": cambiar contraseña | HU-029 | Dev 1 | T-2-04, T-2-05 |
| T-2-07 | Servicio `AccountLockout` y columnas ⚠️ **temprano** | HU-004 | Dev 2 | — |
| T-2-08 | Bloqueo integrado en el login | HU-004 | Dev 2 | T-2-07 |
| T-2-09 | Aviso por correo y auditoría del bloqueo | HU-004 | Dev 2 | T-2-08 |
| T-2-10 | `UserResource` mínimo con "Desbloquear" (Soporte TI) | HU-004, HU-005 | Dev 2 | T-2-07 |
| T-2-11 | Respaldos y monitoreo de staging | TEC-16 | Dev 2 | — |
| T-2-12 | Columnas MFA e interfaces de Filament en `User` | HU-005 | Dev 3 | T-2-01 |
| T-2-13 | MFA obligatorio para roles administrativos | HU-005 | Dev 3 | T-2-12 |
| T-2-14 | Ingreso con código, códigos de respaldo y código incorrecto | HU-005 | Dev 3 | T-2-13, T-2-07 |
| T-2-15 | Acción "Restablecer MFA" (Soporte TI) | HU-005 | Dev 3 | T-2-10, T-2-12 |
| T-2-16 | Verificación de la DoD de experiencia en staging | Todas | Dev 3 | resto del sprint |

#### T-2-01 · `StaffPanel`: restablecimiento, perfil y MFA — Dev 3 ⚠️ debe completarse primero (día 1)
- **Qué:** en `StaffPanel` activar `->passwordReset(RequestPasswordReset::class, ResetPassword::class)`, `->profile(EditProfile::class)` y `->multiFactorAuthentication([...])` según el resultado de T-1-20. Crear las tres páginas como **clases base vacías** que extienden las de Filament; desde ese momento `RequestPasswordReset`, `ResetPassword` y `EditProfile` pertenecen a Dev 1.
- **Archivos:** `app/Filament/Support/StaffPanel.php`, `app/Filament/Pages/Auth/RequestPasswordReset.php`, `app/Filament/Pages/Auth/ResetPassword.php`, `app/Filament/Pages/Auth/EditProfile.php`.
- **Pruebas:** las rutas de restablecimiento y perfil responden 200 en ambos paneles.

#### T-2-02 · "¿Olvidaste tu contraseña?" — Dev 1
- **Qué:** respuesta idéntica exista o no el correo ("Si el correo está registrado, recibirás un enlace en unos minutos"); límite de 3 solicitudes por hora por correo e IP con `RateLimiter::for('password-reset')`; solo correos institucionales; correo de restablecimiento en español y en cola.
- **Archivos:** `app/Filament/Pages/Auth/RequestPasswordReset.php`, `app/Notifications/ResetPasswordNotification.php`, `app/Models/Concerns/SendsStaffPasswordReset.php`, `lang/es/passwords.php`, `tests/Feature/HU003/RequestPasswordResetTest.php`.
- **Pruebas (HU-003):** "Solicitar recuperación" (correo enviado con enlace), anti-enumeración (misma respuesta y ningún correo para inexistente), cuarta solicitud en la hora rechazada.
- **Integración:** Dev 3 agrega `use SendsStaffPasswordReset;` en `User`.

#### T-2-03 · Restablecimiento y enlace vencido/usado — Dev 1
- **Qué:** `config/auth.php` → `passwords.users.expire = config('colegio.restablecimiento_minutos')`; página de restablecimiento con la política de contraseñas; enlace vencido o usado → "Este enlace ya no es válido" con botón para solicitar otro.
- **Archivos:** `config/auth.php`, `app/Filament/Pages/Auth/ResetPassword.php`, `tests/Feature/HU003/ResetPasswordTest.php`.
- **Pruebas (HU-003):** "Restablecer con enlace válido" (contraseña actualizada), "Enlace vencido o ya usado" (31 min y segundo uso).

#### T-2-04 · Acción `UpdateUserPassword` — Dev 1
- **Qué:** `App\Actions\Auth\UpdateUserPassword($user, $plain, ?string $keepSessionId)`: guarda el hash, borra las demás filas de `sessions` del usuario, quita el bloqueo (`AccountLockout::unlock`), envía `PasswordChangedNotification` (en cola) y registra `password.changed`/`password.reset` sin la contraseña. Usada por T-2-03 y T-2-06.
- **Archivos:** `app/Actions/Auth/UpdateUserPassword.php`, `app/Notifications/PasswordChangedNotification.php`, `tests/Feature/HU003/PasswordResetSideEffectsTest.php`.
- **Pruebas (HU-003):** "Restablecer con enlace válido" (todas las sesiones cerradas, correo de confirmación, cuenta desbloqueada).

#### T-2-05 · "Mi cuenta": ver mis datos — Dev 1
- **Qué:** `EditProfile` muestra nombre, correo, roles (etiquetas en español) y estado de MFA en modo lectura, con "Si algún dato es incorrecto, solicita la corrección a secretaría".
- **Archivos:** `app/Filament/Pages/Auth/EditProfile.php`, `lang/es/profile.php`, `tests/Feature/HU029/ViewMyAccountTest.php`.
- **Pruebas (HU-029):** "Ver mis datos" para un administrativo con MFA y un docente sin MFA.

#### T-2-06 · "Mi cuenta": cambiar contraseña — Dev 1
- **Qué:** sección "Contraseña" con contraseña actual, nueva y confirmación; usa `UpdateUserPassword` manteniendo la sesión actual; contraseña actual incorrecta → "La contraseña actual no es correcta" y `AccountLockout::registerFailure()`; nueva igual a la actual o fuera de política → mensaje claro.
- **Archivos:** `app/Filament/Pages/Auth/EditProfile.php`, `lang/es/profile.php`, `tests/Feature/HU029/ChangeMyPasswordTest.php`.
- **Pruebas (HU-029):** "Cambiar contraseña" (otras sesiones cerradas, correo enviado), "Contraseña actual incorrecta" (suma al bloqueo), "Nueva contraseña no válida".

#### T-2-07 · Servicio `AccountLockout` — Dev 2 ⚠️ temprano (día 1–2; lo usan T-2-04, T-2-06, T-2-14)
- **Qué:** migración `add_lockout_columns_to_users_table` (`failed_login_attempts`, `last_failed_login_at`, `locked_until`); trait `HasAccountLockout`; servicio `App\Services\AccountLockout` con `registerFailure(User)`, `registerSuccess(User)`, `isLocked(User)`, `unlock(User, ?User $by)`; umbrales desde `config/colegio.php`.
- **Archivos:** `database/migrations/2026_11_30_090000_add_lockout_columns_to_users_table.php`, `app/Models/Concerns/HasAccountLockout.php`, `app/Services/AccountLockout.php`, `tests/Unit/Services/AccountLockoutTest.php`.
- **Pruebas:** 5 fallos en 15 min bloquean 15 min; fallos fuera de la ventana no acumulan; el bloqueo expira solo.
- **Integración:** Dev 3 agrega `use HasAccountLockout;` en `User`.

#### T-2-08 · Bloqueo en el login — Dev 2
- **Qué:** `Login` consulta `AccountLockout` antes de autenticar ("Demasiados intentos. Intenta de nuevo en 15 minutos o recupera tu contraseña"); registra fallo/éxito. Se mantiene el límite por IP de Filament.
- **Archivos:** `app/Filament/Pages/Auth/Login.php`, `lang/es/auth.php`, `tests/Feature/HU004/LockoutLoginTest.php`.
- **Pruebas (HU-004):** "Bloqueo tras 5 intentos", "Desbloqueo por tiempo" (`travel(16)->minutes()`); la contraseña correcta durante el bloqueo no da acceso.

#### T-2-09 · Aviso por correo y auditoría del bloqueo — Dev 2
- **Qué:** `AccountLockedNotification` (en cola) al titular; eventos `account.locked` y `account.unlocked` en `AuditLogger`.
- **Archivos:** `app/Notifications/AccountLockedNotification.php`, `app/Services/AccountLockout.php`, `lang/es/lockout.php`, `tests/Feature/HU004/LockoutNotificationTest.php`.
- **Pruebas (HU-004):** "Bloqueo tras 5 intentos" (el titular recibe el correo; evento auditado).

#### T-2-10 · `UserResource` mínimo con "Desbloquear" — Dev 2
- **Qué:** `Admin/Resources/Users/UserResource` solo lectura (lista con búsqueda por nombre/correo y filtro por estado) — base que el Sprint 3 amplía con HU-030; `UserPolicy` (`viewAny` con `staff.view`, `unlock` con `accounts.unlock`, `resetMfa` con `mfa.reset`); acción `UnlockAccountAction`; registrar también `ResetMfaAction` de Dev 3 cuando esté lista.
- **Archivos:** `app/Filament/Admin/Resources/Users/UserResource.php`, `app/Filament/Admin/Resources/Users/Pages/ListUsers.php`, `app/Filament/Admin/Resources/Users/Tables/UsersTable.php`, `app/Filament/Admin/Resources/Users/Actions/UnlockAccountAction.php`, `app/Policies/UserPolicy.php`, `tests/Feature/HU004/UnlockAccountTest.php`.
- **Pruebas (HU-004):** "Desbloqueo manual por TI" (ingresa de inmediato y queda en auditoría); Secretaría no ve la acción; Docente recibe 403 en la lista.

#### T-2-11 · Respaldos y monitoreo de staging — Dev 2
- **Qué:** `pg_dump` diario cifrado fuera del servidor con retención de 14 días; restauración probada en una base temporal; rotación de `storage/logs`; alerta por correo a TI ante errores 500 repetidos (canal `log` `slack`/`mail` o monitoreo del proveedor).
- **Archivos:** `deploy/backup.sh`, `deploy/crontab.example`, `config/logging.php` (canal diario).
- **Terminado:** restauración probada y documentada en "Decisiones técnicas".

#### T-2-12 · Columnas MFA e interfaces en `User` — Dev 3
- **Qué:** migración `add_app_authentication_columns_to_users_table` (secreto y códigos de recuperación, cifrados con *casts* `encrypted`); `User` implementa las interfaces de MFA por app y de recuperación de Filament; `$hidden` para secreto y códigos.
- **Archivos:** `database/migrations/2026_11_30_100000_add_app_authentication_columns_to_users_table.php`, `app/Models/User.php`, `tests/Unit/Models/UserMfaTest.php`.
- **Pruebas:** el secreto se guarda cifrado y no aparece en `toArray()`.

#### T-2-13 · MFA obligatorio para administrativos — Dev 3
- **Qué:** según T-1-20: un usuario con algún rol administrativo sin MFA es enviado a la activación (QR + confirmar código + 10 códigos de respaldo) antes de cualquier pantalla, en ambos paneles. **Docentes sin rol administrativo: sin MFA en la Fase 1** (decisión de la dirección, 2026-10-28; queda pendiente para una fase posterior), así que no se construye activación opcional.
- **Archivos:** `app/Filament/Support/StaffPanel.php`, `app/Http/Middleware/EnsureMfaIsConfigured.php` (si Filament no lo cubre), `lang/es/mfa.php`, `tests/Feature/HU005/MfaEnrollmentTest.php`.
- **Pruebas (HU-005):** "Activación obligatoria en el primer ingreso", "Abandonar la activación" (cualquier URL vuelve a la activación); docente sin rol administrativo entra sin que se le pida MFA.

#### T-2-14 · Ingreso con código, respaldo y código incorrecto — Dev 3
- **Qué:** desafío TOTP tras la contraseña; código de respaldo de un solo uso; código incorrecto o vencido → "Código incorrecto. Revisa la hora de tu celular e inténtalo de nuevo" y `AccountLockout::registerFailure()`; eventos `mfa.challenge_failed`, `mfa.recovery_code_used`.
- **Archivos:** `app/Filament/Pages/Auth/Login.php` (solo el *hook* del desafío, coordinado con Dev 2) o `app/Listeners/RecordMfaFailure.php` según el spike, `lang/es/mfa.php`, `tests/Feature/HU005/MfaChallengeTest.php`.
- **Pruebas (HU-005):** "Ingreso con MFA", "Uso de código de respaldo" (queda invalidado), "Código incorrecto o vencido" (suma al bloqueo). TOTP generado en la prueba con `pragmarx/google2fa`.

#### T-2-15 · "Restablecer MFA" (Soporte TI) — Dev 3
- **Qué:** `ResetMfaAction` con confirmación ("¿Verificaste la identidad de la persona?"), borra secreto y códigos, registra `mfa.reset`; autorizada por `UserPolicy::resetMfa` (permiso `mfa.reset`). Dev 2 la registra en `UsersTable`.
- **Archivos:** `app/Filament/Admin/Resources/Users/Actions/ResetMfaAction.php`, `tests/Feature/HU005/ResetMfaTest.php`. (El método `resetMfa` de `UserPolicy` lo agrega Dev 2 en T-2-10.)
- **Pruebas (HU-005):** "Restablecer MFA" (en el siguiente ingreso debe configurarlo de nuevo; auditado); Secretaría no ve la acción.

#### T-2-16 · Verificación de la DoD de experiencia — Dev 3
- **Qué:** recorrer HU-003, HU-004, HU-005 y HU-029 en staging (Chrome, Firefox, Android, 3G, teclado), incluyendo correos reales del SMTP institucional y una app autenticadora real (Google Authenticator o Aegis).

## Decisiones técnicas
_(completar durante el sprint)_

## Hito
Al cerrar este sprint se alcanza **H1 — Personal puede ingresar** ([[Fases y roadmap#Hitos]]).
