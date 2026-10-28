---
tipo: paquete
sprint: "[[Sprint 2 - Seguridad del login]]"
developer: Dev 2
agente: php-senior-developer
estado: por hacer
tags: [sprint, paquete, dev2]
---
# Sprint 2 · Dev 2

Volver a [[Paquetes MOC]] · Sprint: [[Sprint 2 - Seguridad del login]] (30/11 – 11/12/2026) · Otros paquetes: [[Sprint 2 - Dev 1]] · [[Sprint 2 - Dev 3]]

## Objetivo del sprint
> Las cuentas del personal están protegidas contra accesos indebidos y cada persona puede recuperar su acceso por sí misma.

**Foco de este paquete:** Bloqueo por intentos fallidos y *throttle* por IP (HU-004, DEF-02), administración mínima de cuentas, "Restablecer MFA", *helpers* de MFA para las pruebas (TEC-22) y datos de demostración (TEC-16).

## Antes de empezar
1. Lee el detalle de cada tarea en [[Sprint 2 - Seguridad del login#Tareas técnicas]] y las historias enlazadas.
2. Lee [[ADR-005 Stack PHP Laravel y Filament]], [[Stack tecnologico]], [[Roles y permisos RBAC]], [[Flujo de autenticacion]] y la [[Definicion de Terminado]].

## Tareas en orden de ejecución
| # | ID | Tarea | Espera a |
|---|---|---|---|
| 1 | T-2-07 | Servicio `AccountLockout` y columnas ⚠️ temprano (día 1–2) | — |
| 2 | T-2-08 | Bloqueo en el login, *throttle* por IP y evento `MultiFactorChallengeFailed` | T-2-07 |
| 3 | T-2-17 | *Factories* y *helpers* para MFA ⚠️ antes de que Dev 3 active el MFA (T-2-13) | T-2-12 (Dev 3) |
| 4 | T-2-10 | `UserResource` mínimo con "Desbloquear" | T-2-07 |
| 5 | T-2-09 | Aviso por correo y auditoría del bloqueo | T-2-08 |
| 6 | T-2-15 | Acción "Restablecer MFA" (servicio `MultiFactorReset`) | T-2-10, T-2-12 (Dev 3) |
| 7 | T-2-11 | Datos de demostración del personal (`DemoStaffSeeder`) | T-2-07, T-2-17 |

## Archivos de este paquete
Solo tú modificas estos archivos en este sprint (rutas bajo `app-colegio/`, salvo `.github/` y el vault):
- `app/Services/AccountLockout.php`, `app/Models/Concerns/HasAccountLockout.php` y su migración
- `app/Filament/Pages/Auth/Login.php` (único dueño en el Sprint 2), `app/Events/MultiFactorChallengeFailed.php`
- `config/colegio.php` (límite por IP)
- `app/Notifications/AccountLockedNotification.php`, `lang/es/lockout.php`, `lang/es/auth.php`
- `app/Filament/Admin/Resources/Users/**` (incluida `Actions/ResetMfaAction.php`), `app/Services/MultiFactorReset.php`
- `app/Policies/UserPolicy.php`
- `database/factories/UserFactory.php`, `tests/Pest.php` y, en T-2-17, los ajustes de `LoginSuccessTest`, `LoginRedirectTest`, `LoginAuditTest` y `StaffFactoryTest`
- `database/seeders/DemoStaffSeeder.php`, `database/seeders/DatabaseSeeder.php`
- `tests/Feature/HU004/*`, `tests/Feature/HU005/ResetMfaTest.php`, `tests/Feature/Seeders/*`, `tests/Unit/Services/AccountLockoutTest.php`

Si necesitas cambiar un archivo de otro paquete, **no lo edites**: repórtalo como impedimento o coordínalo con su dueño.

## Dependencias con otros paquetes
- Entrega T-2-07 pronto: Dev 1 (T-2-04, T-2-06) y Dev 3 (T-2-14) lo usan.
- **T-2-17 desbloquea a Dev 3:** sin los *helpers*, activar el MFA rompe 16 pruebas ([[Spike T-1-20 MFA por rol]]). Prueba la suite con el MFA activado en una rama local antes de avisar.
- `User.php` es de Dev 3 en este sprint: él agrega `use HasAccountLockout;`.
- Los tipos de auditoría nuevos (`account.locked`, `account.unlocked`, `mfa.reset`) ya los agrega Dev 3 en T-2-01.
- El evento `MultiFactorChallengeFailed` lo emites tú en `Login.php` y lo escucha Dev 3 (T-2-14).
- Los umbrales del *throttle* por IP los confirma el PO (propuesta: 20/min por IP, solo intentos fallidos).

## Verificación
```bash
cd app-colegio
vendor/bin/pint --test
vendor/bin/phpstan analyse
vendor/bin/pest
vendor/bin/pest --filter=HU0xx      # pruebas de una historia
composer audit
php artisan colegio:demo            # base de demostración con datos ficticios (desde el Sprint 0, T-0-11)
```

## Definición de terminado del paquete
- [ ] Todas las tareas cumplen su "Terminado/Pruebas" de [[Sprint 2 - Seguridad del login#Tareas técnicas]].
- [ ] Cada escenario de las historias del paquete tiene una prueba Pest con su nombre; prueba con rol sin acceso cuando aplica.
- [ ] `pint --test`, `phpstan analyse` y `pest` en verde en local y en CI (SQLite).
- [ ] Solo datos ficticios (`@colegio-piloto.test`); lo nuevo se puede mostrar con `php artisan colegio:demo`.
- [ ] Sin contraseñas, tokens ni secretos en logs ni en `audit_events`; acciones sensibles auditadas.
- [ ] Textos de UI en `lang/es`, en español claro.
- [ ] Tareas marcadas en la nota del sprint y decisiones técnicas anotadas.
- [ ] Reporte final: tareas hechas, pruebas ejecutadas y resultado, impedimentos y deuda técnica. Sin commits ni push (los hace quien invoca).
