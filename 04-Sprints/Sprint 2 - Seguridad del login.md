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
> 🔄 **Ajustado en el cierre del Sprint 1 (27/11/2026)** a partir de los *spikes* [[Spike T-1-20 MFA por rol]] y [[Spike T-1-19 Peso del login en 3G]] y de los defectos del S1:
> - El MFA **no se activa en T-2-01**. Se activa en T-2-13, después de que T-2-17 prepare las *factories* y *helpers*: activarlo antes rompe 16 pruebas.
> - T-2-01 centraliza los nuevos tipos de auditoría del sprint y pasa a fuentes del sistema (TEC-21).
> - El evento `MultiFactorChallengeFailed` lo emite `Login.php` (Dev 2, T-2-08) y lo escucha Dev 3 (T-2-14). Así `Login.php` tiene un solo dueño.
> - Se agregan T-2-17 (TEC-22, *helpers* de MFA, Dev 2) y T-2-18 (DEF-01, tono "tú", Dev 1). T-2-08 incorpora DEF-02 (*throttle* por IP).
> - El alcance (19 pts) no cambia. Si hay que recortar, sale primero HU-029 (decisión del PO).
> Definidas por el [[Scrum Master]] el 2026-10-28 ([[2026-10-28 Sprint Planning tecnico - Scrum Master]]); se confirman en la [[Sprint Planning]] del sprint con los resultados de los *spikes* T-1-19 y T-1-20. Stack: [[ADR-005 Stack PHP Laravel y Filament]] · [[Stack tecnologico]] · Paquetes: [[Sprint 2 - Dev 1]], [[Sprint 2 - Dev 2]], [[Sprint 2 - Dev 3]].
>
> **Terminado técnico común:** `vendor/bin/pint --test`, `vendor/bin/phpstan analyse`, `vendor/bin/pest` en verde (CI con SQLite); solo datos ficticios `@colegio-piloto.test`; cada escenario Gherkin con su prueba Pest; prueba con rol sin acceso cuando aplica; correos con `Notification::fake()` y en cola; acciones sensibles auditadas; PR revisado.
>
> Reparto: **Dev 1** = recuperación y cambio de contraseña (HU-003, HU-029) · **Dev 1** también unifica el tono de Filament (DEF-01) · **Dev 2** = bloqueo y *throttle* (HU-004, DEF-02), administración mínima de cuentas, restablecer MFA, *helpers* de MFA para pruebas y datos de demostración (parte de HU-005, TEC-22, TEC-16) · **Dev 3** = MFA (HU-005), fuentes del sistema (TEC-21) y tipos de auditoría del sprint.

### Plan de oleadas
Acordado en la [[2026-11-27 Retrospectiva - Sprint 1]]. Cada oleada se integra con el CI en verde antes de empezar la siguiente; dentro de una oleada, solo hay dependencias entre tareas del mismo developer.

| Oleada | Dev 1 | Dev 2 | Dev 3 |
|---|---|---|---|
| 1 (bases) | — (revisión y apoyo) | T-2-07 | T-2-01 → T-2-12 |
| 2 | T-2-02, T-2-03, T-2-18, T-2-04 | T-2-08, T-2-10, T-2-17 | apoyo y revisión de T-2-17; preparar T-2-13 en una rama local |
| 3 | T-2-05 → T-2-06 | T-2-09, T-2-15, T-2-11 | T-2-13 → T-2-14 → T-2-16 |

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
| T-2-11 | Datos de demostración del personal (`DemoStaffSeeder`) | TEC-16 | Dev 2 | T-2-07, T-2-12 |
| T-2-12 | Columnas MFA e interfaces de Filament en `User` | HU-005 | Dev 3 | T-2-01 |
| T-2-13 | MFA obligatorio para roles administrativos (activación) | HU-005 | Dev 3 | T-2-12, T-2-17 |
| T-2-14 | Ingreso con código, códigos de respaldo y código incorrecto | HU-005 | Dev 3 | T-2-13, T-2-07, T-2-08 |
| T-2-15 | Acción "Restablecer MFA" (Soporte TI) | HU-005 | Dev 2 | T-2-10, T-2-12 |
| T-2-16 | Verificación de la DoD de experiencia en el entorno de demostración | Todas | Dev 3 | resto del sprint |
| T-2-17 | *Factories* y *helpers* de prueba para MFA ⚠️ **antes de activar el MFA** | TEC-22, HU-005 | Dev 2 | T-2-12 |
| T-2-18 | Tono "tú" en los textos de Filament (login, recuperación, perfil) | DEF-01 | Dev 1 | T-2-01 |

#### T-2-01 · `StaffPanel`: restablecimiento, perfil y MFA — Dev 3 ⚠️ debe completarse primero (día 1)
- **Qué:** en `StaffPanel` activar `->passwordReset(RequestPasswordReset::class, ResetPassword::class)` y `->profile(EditProfile::class)`. Crear las tres páginas como **clases base vacías** que extienden las de Filament; desde ese momento `RequestPasswordReset`, `ResetPassword` y `EditProfile` pertenecen a Dev 1. **No** activar todavía el MFA (eso es T-2-13). Además: (a) **fuentes del sistema** en lugar de Inter, con un `FontProvider` que no emite HTML (TEC-21, ≈ −67 KB en el login); (b) agregar de una vez a `AuditEventType` y a `lang/es/audit.php` todos los tipos del sprint: `password.reset_requested`, `password.reset`, `account.locked`, `account.unlocked`, `mfa.enabled`, `mfa.challenge_failed`, `mfa.recovery_code_used`, `mfa.reset` (claves de traducción con `_`). Así nadie más toca esos dos archivos en el sprint.
- **Archivos:** `app/Filament/Support/StaffPanel.php`, `app/Filament/Support/SystemFontProvider.php`, `app/Filament/Pages/Auth/RequestPasswordReset.php`, `app/Filament/Pages/Auth/ResetPassword.php`, `app/Filament/Pages/Auth/EditProfile.php`, `app/Enums/AuditEventType.php`, `lang/es/audit.php`.
- **Pruebas:** las rutas de restablecimiento y perfil responden 200 en ambos paneles; el login no referencia la fuente Inter (`woff2`); cada tipo nuevo tiene su etiqueta en español (la prueba existente recorre el enum).

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
- **Qué:** `Login` consulta `AccountLockout` antes de autenticar ("Demasiados intentos. Intenta de nuevo en 15 minutos o recupera tu contraseña"); registra fallo/éxito. **DEF-02:** el límite por IP de Filament (5/min, cuenta también los ingresos correctos) se reemplaza por uno que cuenta solo intentos fallidos por IP + correo, con un tope por IP más alto (propuesta: 20/min, valor en `config/colegio.php`). El bloqueo por cuenta de HU-004 sigue siendo el control principal; los umbrales los confirma el PO. **Emite el evento `App\Events\MultiFactorChallengeFailed`** cuando Filament lanza `ValidationException` con claves `data.multiFactor.*` (patrón del [[Spike T-1-20 MFA por rol]]). Unifica `auth.throttle` en "tú".
- **Archivos:** `app/Filament/Pages/Auth/Login.php`, `app/Events/MultiFactorChallengeFailed.php`, `config/colegio.php` (límite por IP), `lang/es/auth.php`, `tests/Feature/HU004/LockoutLoginTest.php`, `tests/Feature/HU004/LoginRateLimitTest.php`.
- **Pruebas (HU-004):** "Bloqueo tras 5 intentos", "Desbloqueo por tiempo" (`travel(16)->minutes()`); la contraseña correcta durante el bloqueo no da acceso; 7 cuentas distintas que ingresan bien desde la misma IP no se bloquean (DEF-02); un código MFA incorrecto emite `MultiFactorChallengeFailed`.

#### T-2-09 · Aviso por correo y auditoría del bloqueo — Dev 2
- **Qué:** `AccountLockedNotification` (en cola) al titular; eventos `account.locked` y `account.unlocked` en `AuditLogger`.
- **Archivos:** `app/Notifications/AccountLockedNotification.php`, `app/Services/AccountLockout.php`, `lang/es/lockout.php`, `tests/Feature/HU004/LockoutNotificationTest.php`.
- **Pruebas (HU-004):** "Bloqueo tras 5 intentos" (el titular recibe el correo; evento auditado).

#### T-2-10 · `UserResource` mínimo con "Desbloquear" — Dev 2
- **Qué:** `Admin/Resources/Users/UserResource` solo lectura (lista con búsqueda por nombre/correo y filtro por estado) — base que el Sprint 3 amplía con HU-030; `UserPolicy` (`viewAny` con `staff.view`, `unlock` con `accounts.unlock`, `resetMfa` con `mfa.reset`); acción `UnlockAccountAction`; registrar también `ResetMfaAction` de Dev 3 cuando esté lista.
- **Archivos:** `app/Filament/Admin/Resources/Users/UserResource.php`, `app/Filament/Admin/Resources/Users/Pages/ListUsers.php`, `app/Filament/Admin/Resources/Users/Tables/UsersTable.php`, `app/Filament/Admin/Resources/Users/Actions/UnlockAccountAction.php`, `app/Policies/UserPolicy.php`, `tests/Feature/HU004/UnlockAccountTest.php`.
- **Pruebas (HU-004):** "Desbloqueo manual por TI" (ingresa de inmediato y queda en auditoría); Secretaría no ve la acción; Docente recibe 403 en la lista.

#### T-2-11 · Datos de demostración del personal — Dev 2
- **Qué:** `DemoStaffSeeder` llamado por `colegio:demo`: hasta 15 administrativos y 50 docentes **ficticios** con correos `@colegio-piloto.test` (nombres generados), al menos una cuenta por rol y una por estado (activa, pendiente, con contraseña temporal, bloqueada, desactivada), administrativos con y sin MFA configurado y un docente con rol de coordinación. Contraseña de demostración conocida solo en `local`. Reemplaza a "Respaldos y monitoreo de staging", fuera del alcance del piloto.
- **Archivos:** `database/seeders/DemoStaffSeeder.php`, `database/seeders/DatabaseSeeder.php`, `tests/Feature/Seeders/DemoStaffSeederTest.php`.
- **Pruebas:** respeta los máximos (15/50), todos los correos son del dominio ficticio, existe al menos una cuenta por rol y por estado, y ejecutarlo dos veces no duplica.

#### T-2-12 · Columnas MFA e interfaces en `User` — Dev 3
- **Qué:** migración `add_app_authentication_columns_to_users_table` (`app_authentication_secret` y `app_authentication_recovery_codes`, text, nullable); `User` implementa `HasAppAuthentication` y `HasAppAuthenticationRecovery` con los *traits* de Filament (`InteractsWithAppAuthentication`, `InteractsWithAppAuthenticationRecovery`), que agregan los *casts* cifrados y ocultan las columnas; método `requiresMultiFactorAuthentication()` (algún `StaffRole::isAdministrative()`). Entregar temprano (día 2): lo necesita T-2-17.
- **Archivos:** `database/migrations/2026_11_30_100000_add_app_authentication_columns_to_users_table.php`, `app/Models/User.php`, `tests/Unit/Models/UserMfaTest.php`.
- **Pruebas:** el secreto se guarda cifrado y no aparece en `toArray()`; `requiresMultiFactorAuthentication()` es verdadero para cada rol administrativo y falso para Docente.

#### T-2-13 · MFA obligatorio para administrativos — Dev 3
- **Qué:** según el [[Spike T-1-20 MFA por rol]]: en `StaffPanel`, `->multiFactorAuthentication(AppAuthentication::make()->brandName('Colegio Virtual')->recoverable()->recoveryCodeCount(10), isRequired: true)` y `->multiFactorAuthenticationRequiredMiddlewareName(EnsureAdministrativeMfa::class)`. El *middleware* propio exige la configuración (QR + confirmar código + 10 códigos de respaldo) solo a cuentas con rol administrativo, en ambos paneles. El orden con HU-006 se mantiene: primero contraseña, después MFA. En "Mi cuenta" se oculta la acción "Desactivar" del MFA a los roles administrativos (extender `AppAuthentication::getActions()`). Los docentes sin rol administrativo no pueden abrir la configuración: se los redirige a su panel (por defecto, según la decisión de la dirección; el PO puede cambiarlo). **Docentes sin rol administrativo: sin MFA en la Fase 1** (decisión de la dirección, 2026-10-28; queda pendiente para una fase posterior), así que no se construye activación opcional.
- **Archivos:** `app/Filament/Support/StaffPanel.php`, `app/Filament/Support/StaffAppAuthentication.php` (si hace falta subclasificar), `app/Http/Middleware/EnsureAdministrativeMfa.php`, `lang/vendor/filament-panels/es/auth/multi-factor/**`, `tests/Feature/HU005/MfaEnrollmentTest.php`.
- **Pruebas (HU-005):** "Activación obligatoria en el primer ingreso" en `/admin` y en `/docente` (Docente + Coordinación), "Abandonar la activación" (cualquier URL vuelve a la activación); docente sin rol administrativo entra sin MFA y no puede abrir la configuración; un administrativo no ve "Desactivar". **La suite completa sigue en verde** gracias a T-2-17.

#### T-2-14 · Ingreso con código, respaldo y código incorrecto — Dev 3
- **Qué:** desafío TOTP tras la contraseña; código de respaldo de un solo uso; código incorrecto o vencido → "Código incorrecto. Revisa la hora de tu celular e inténtalo de nuevo" (traducción propia en `lang/vendor/filament-panels/es`). *Listener* de `MultiFactorChallengeFailed` (lo emite Dev 2 en T-2-08) → `AccountLockout::registerFailure()` y auditoría `mfa.challenge_failed`; `mfa.recovery_code_used` al usar un código de respaldo. Alinear el limitador propio del desafío de Filament con el bloqueo de HU-004, para no mostrar dos mensajes distintos.
- **Archivos:** `app/Listeners/RecordMfaFailure.php`, `lang/vendor/filament-panels/es/auth/multi-factor/**`, `tests/Feature/HU005/MfaChallengeTest.php`. (No toca `Login.php`.)
- **Pruebas (HU-005):** "Ingreso con MFA", "Uso de código de respaldo" (queda invalidado), "Código incorrecto o vencido" (suma al bloqueo). TOTP generado en la prueba con `pragmarx/google2fa`.

#### T-2-15 · "Restablecer MFA" (Soporte TI) — Dev 2
- **Qué:** servicio `App\Services\MultiFactorReset` (en una transacción: pone en `null` el secreto y los códigos, rota `remember_token`, borra las filas de `sessions` del usuario y registra `mfa.reset`) y `ResetMfaAction` con confirmación ("¿Verificaste la identidad de la persona?"); autorizada por `UserPolicy::resetMfa` (permiso `mfa.reset`) y registrada en `UsersTable`. Reasignada a Dev 2 (dueño de `UserResource`) con la capacidad liberada por el alcance piloto.
- **Archivos:** `app/Services/MultiFactorReset.php`, `app/Filament/Admin/Resources/Users/Actions/ResetMfaAction.php`, `tests/Feature/HU005/ResetMfaTest.php`. (Usa las columnas MFA de Dev 3, T-2-12.)
- **Pruebas (HU-005):** "Restablecer MFA" (en el siguiente ingreso debe configurarlo de nuevo; auditado); Secretaría no ve la acción.

#### T-2-17 · *Factories* y *helpers* para MFA — Dev 2 ⚠️ antes de T-2-13
- **Qué:** estados `withMfa()` / `withoutMfa()` en `UserFactory`, con un secreto TOTP ficticio y 10 códigos de respaldo; `withRoles()` con un rol administrativo crea la cuenta **con MFA configurado** por defecto; *helper* `completeMfaChallenge($livewire, $user)` en `tests/Pest.php` que genera un TOTP válido con `Google2FA`. Ajustar las pruebas de login de punta a punta (`LoginRedirectTest`, `LoginAuditTest`, `LoginSuccessTest`) para que completen el desafío. Verificar en una rama local que, con el MFA activado como en el spike, la suite queda en verde **antes** de que Dev 3 integre T-2-13.
- **Archivos:** `database/factories/UserFactory.php`, `tests/Pest.php`, `tests/Feature/HU001/LoginSuccessTest.php`, `tests/Feature/HU007/LoginRedirectTest.php`, `tests/Feature/HU013/LoginAuditTest.php`, `tests/Feature/Rbac/StaffFactoryTest.php`. (Excepción acordada: Dev 2 ajusta pruebas de otras historias porque es el dueño de la *factory*; avisar a Dev 1 y Dev 3.)
- **Terminado:** con T-2-13 integrada, `pest` completo en verde sin desactivar el MFA en las pruebas.

#### T-2-18 · Tono "tú" en los textos de Filament — Dev 1
- **Qué:** sobrescribir en `lang/vendor/filament-panels/es` los textos de Filament que usan "usted" en el login, la recuperación de contraseña, el perfil y los menús ("Entre a su cuenta" → "Ingresa a tu cuenta", etc.), siguiendo el tono "tú" del resto de la aplicación (DEF-01; el PO confirma el tono). No incluye `auth/multi-factor/**` (Dev 3) ni `lang/es/auth.php` (Dev 2).
- **Archivos:** `lang/vendor/filament-panels/es/**` (salvo `auth/multi-factor/**`), `tests/Feature/Localization/InformalToneTest.php`.
- **Pruebas:** el login, la recuperación y "Mi cuenta" no contienen formas de "usted" de una lista de control ("su cuenta", "Entre", "Intente"…).

#### T-2-16 · Verificación de la DoD de experiencia — Dev 3
- **Qué:** recorrer HU-003, HU-004, HU-005 y HU-029 en el entorno de demostración (Chrome, Firefox, Android, 3G, teclado), viendo los correos en Mailpit o en el log y usando una app autenticadora real (Google Authenticator o Aegis) con cuentas ficticias. Como el entorno de los agentes no tiene navegador, Dev 3 deja una **lista de verificación manual** para que una persona con navegador (PO o usuario) la complete en la Sprint Review. Incluye repetir la medición del peso del login con DevTools/Lighthouse.

## Decisiones técnicas
_(completar durante el sprint)_

## Hito
Al cerrar este sprint se alcanza **H1 — Personal puede ingresar** ([[Fases y roadmap#Hitos]]).
