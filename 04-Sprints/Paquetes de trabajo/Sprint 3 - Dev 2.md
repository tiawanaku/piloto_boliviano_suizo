---
tipo: paquete
sprint: "[[Sprint 3 - Gestion de personal]]"
developer: Dev 2
agente: php-senior-developer
estado: por hacer
tags: [sprint, paquete, dev2]
---
# Sprint 3 · Dev 2

Volver a [[Paquetes MOC]] · Sprint: [[Sprint 3 - Gestion de personal]] (14/12 – 24/12/2026) · Otros paquetes: [[Sprint 3 - Dev 1]] · [[Sprint 3 - Dev 3]]

## Objetivo del sprint
> El colegio crea, configura y desactiva por sí mismo las cuentas del personal, con trazabilidad completa.

**Foco de este paquete:** Invitación, activación y desactivación de cuentas (HU-009, HU-011).

## Antes de empezar
1. Lee el detalle de cada tarea en [[Sprint 3 - Gestion de personal#Tareas técnicas]] y las historias enlazadas.
2. Lee [[ADR-005 Stack PHP Laravel y Filament]], [[Stack tecnologico]], [[Roles y permisos RBAC]], [[Flujo de autenticacion]] y la [[Definicion de Terminado]].

## Tareas en orden de ejecución
| # | ID | Tarea | Espera a |
|---|---|---|---|
| 1 | T-3-08 | Acción `InviteStaffMember` y correo de invitación | T-3-01 (Dev 1) |
| 2 | T-3-11 | Acciones desactivar y reactivar | T-3-01 (Dev 1) |
| 3 | T-3-10 | Activación, invitación vencida y reenvío | T-3-08 |
| 4 | T-3-09 | Página "Invitar personal" | T-3-04 (Dev 1), T-3-08 |
| 5 | T-3-12 | Efectos de la desactivación | T-3-11 |

## Archivos de este paquete
Solo tú modificas estos archivos en este sprint (rutas bajo `app-colegio/`, salvo `.github/` y el vault):
- `app/Actions/Staff/InviteStaffMember.php`, `DeactivateAccount.php`, `ReactivateAccount.php`
- `app/Models/Concerns/HasInvitation.php` y su migración
- `app/Notifications/StaffInvitationNotification.php`
- `app/Filament/Admin/Resources/Users/Pages/CreateUser.php`
- `app/Filament/Admin/Resources/Users/Actions/ResendInvitationAction.php`, `DeactivateAccountAction.php`, `ReactivateAccountAction.php`
- `app/Filament/Pages/Auth/ActivateAccount.php`, `routes/web.php`
- `lang/es/invitation.php`, `lang/es/accounts.php`
- `tests/Feature/HU009/*`, `tests/Feature/HU011/*`

Si necesitas cambiar un archivo de otro paquete, **no lo edites**: repórtalo como impedimento o coordínalo con su dueño.

## Dependencias con otros paquetes
- Esperas T-3-01 (Dev 1, día 1).
- T-3-09 reutiliza el `UserForm` de Dev 1 (T-3-04); no lo copies.
- La invitación asigna roles con `SyncStaffRoles` de Dev 1.
- Tus acciones las registra Dev 1 en la ficha (T-3-07): avísale cuando estén integradas.

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
- [ ] Todas las tareas cumplen su "Terminado/Pruebas" de [[Sprint 3 - Gestion de personal#Tareas técnicas]].
- [ ] Cada escenario de las historias del paquete tiene una prueba Pest con su nombre; prueba con rol sin acceso cuando aplica.
- [ ] `pint --test`, `phpstan analyse` y `pest` en verde en local y en CI (SQLite y PostgreSQL).
- [ ] Sin contraseñas, tokens ni secretos en logs ni en `audit_events`; acciones sensibles auditadas.
- [ ] Textos de UI en `lang/es`, en español claro.
- [ ] Tareas marcadas en la nota del sprint y decisiones técnicas anotadas.
- [ ] Reporte final: tareas hechas, pruebas ejecutadas y resultado, impedimentos y deuda técnica. Sin commits ni push (los hace quien invoca).
