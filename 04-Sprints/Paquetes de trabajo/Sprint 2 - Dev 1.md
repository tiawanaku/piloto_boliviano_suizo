---
tipo: paquete
sprint: "[[Sprint 2 - Seguridad del login]]"
developer: Dev 1
agente: php-senior-developer
estado: por hacer
tags: [sprint, paquete, dev1]
---
# Sprint 2 · Dev 1

Volver a [[Paquetes MOC]] · Sprint: [[Sprint 2 - Seguridad del login]] (30/11 – 11/12/2026) · Otros paquetes: [[Sprint 2 - Dev 2]] · [[Sprint 2 - Dev 3]]

## Objetivo del sprint
> Las cuentas del personal están protegidas contra accesos indebidos y cada persona puede recuperar su acceso por sí misma.

**Foco de este paquete:** Recuperación y cambio de contraseña (HU-003, HU-029).

## Antes de empezar
1. Lee el detalle de cada tarea en [[Sprint 2 - Seguridad del login#Tareas técnicas]] y las historias enlazadas.
2. Lee [[ADR-005 Stack PHP Laravel y Filament]], [[Stack tecnologico]], [[Roles y permisos RBAC]], [[Flujo de autenticacion]] y la [[Definicion de Terminado]].

## Tareas en orden de ejecución
| # | ID | Tarea | Espera a |
|---|---|---|---|
| 1 | T-2-02 | Página "¿Olvidaste tu contraseña?" | T-2-01 (Dev 3) |
| 2 | T-2-03 | Restablecimiento y enlace vencido/usado | T-2-01 (Dev 3) |
| 3 | T-2-04 | Acción `UpdateUserPassword` | T-2-07 (Dev 2) |
| 4 | T-2-05 | "Mi cuenta": ver mis datos | T-2-01, T-2-12 (Dev 3) |
| 5 | T-2-06 | "Mi cuenta": cambiar contraseña | T-2-04, T-2-05 |

## Archivos de este paquete
Solo tú modificas estos archivos en este sprint (rutas bajo `app-colegio/`, salvo `.github/` y el vault):
- `app/Filament/Pages/Auth/RequestPasswordReset.php`, `ResetPassword.php`, `EditProfile.php` (después de que Dev 3 los cree en T-2-01)
- `app/Actions/Auth/UpdateUserPassword.php`
- `app/Notifications/ResetPasswordNotification.php`, `PasswordChangedNotification.php`
- `app/Models/Concerns/SendsStaffPasswordReset.php`
- `config/auth.php`
- `lang/es/passwords.php`, `lang/es/profile.php`
- `tests/Feature/HU003/*`, `tests/Feature/HU029/*`

Si necesitas cambiar un archivo de otro paquete, **no lo edites**: repórtalo como impedimento o coordínalo con su dueño.

## Dependencias con otros paquetes
- Esperas T-2-01 (Dev 3, día 1).
- T-2-04 y T-2-06 usan `AccountLockout` de Dev 2 (T-2-07).
- T-2-05 muestra el estado de MFA: usa las columnas de Dev 3 (T-2-12).
- `StaffPanel.php`, `User.php` y `Login.php` no son tuyos en este sprint.

## Verificación
```bash
cd app-colegio
vendor/bin/pint --test
vendor/bin/phpstan analyse
vendor/bin/pest
vendor/bin/pest --filter=HU0xx      # pruebas de una historia
composer audit
```

## Definición de terminado del paquete
- [ ] Todas las tareas cumplen su "Terminado/Pruebas" de [[Sprint 2 - Seguridad del login#Tareas técnicas]].
- [ ] Cada escenario de las historias del paquete tiene una prueba Pest con su nombre; prueba con rol sin acceso cuando aplica.
- [ ] `pint --test`, `phpstan analyse` y `pest` en verde en local y en CI (SQLite y PostgreSQL).
- [ ] Sin contraseñas, tokens ni secretos en logs ni en `audit_events`; acciones sensibles auditadas.
- [ ] Textos de UI en `lang/es`, en español claro.
- [ ] Tareas marcadas en la nota del sprint y decisiones técnicas anotadas.
- [ ] Reporte final: tareas hechas, pruebas ejecutadas y resultado, impedimentos y deuda técnica. Sin commits ni push (los hace quien invoca).
