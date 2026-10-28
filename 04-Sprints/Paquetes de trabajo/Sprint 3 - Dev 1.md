---
tipo: paquete
sprint: "[[Sprint 3 - Gestion de personal]]"
developer: Dev 1
agente: php-senior-developer
estado: por hacer
tags: [sprint, paquete, dev1]
---
# Sprint 3 · Dev 1

Volver a [[Paquetes MOC]] · Sprint: [[Sprint 3 - Gestion de personal]] (14/12 – 24/12/2026) · Otros paquetes: [[Sprint 3 - Dev 2]] · [[Sprint 3 - Dev 3]]

## Objetivo del sprint
> El colegio crea, configura y desactiva por sí mismo las cuentas del personal, con trazabilidad completa.

**Foco de este paquete:** Listado y ficha del personal, roles e integración de acciones (HU-030, HU-010).

## Antes de empezar
1. Lee el detalle de cada tarea en [[Sprint 3 - Gestion de personal#Tareas técnicas]] y las historias enlazadas.
2. Lee [[ADR-005 Stack PHP Laravel y Filament]], [[Stack tecnologico]], [[Roles y permisos RBAC]], [[Flujo de autenticacion]] y la [[Definicion de Terminado]].

## Tareas en orden de ejecución
| # | ID | Tarea | Espera a |
|---|---|---|---|
| 1 | T-3-01 | Perfil `StaffMember` y `UserPolicy` completa ⚠️ debe completarse primero (día 1) | — |
| 2 | T-3-02 | Listado del personal | T-3-01 |
| 3 | T-3-03 | Ficha y último acceso | T-3-01 |
| 4 | T-3-04 | Formulario y edición con auditoría | T-3-03 |
| 5 | T-3-05 | Asignar y quitar roles | T-3-04 |
| 6 | T-3-06 | Efecto inmediato y auditoría de roles | T-3-05 |
| 7 | T-3-07 | Integrar acciones en la ficha | T-3-10, T-3-11 (Dev 2) |

## Archivos de este paquete
Solo tú modificas estos archivos en este sprint (rutas bajo `app-colegio/`, salvo `.github/` y el vault):
- `app/Models/User.php`, `app/Models/StaffMember.php`, `database/factories/StaffMemberFactory.php` y migraciones de `staff_members` y `last_login_at`
- `app/Policies/UserPolicy.php`
- `app/Filament/Admin/Resources/Users/UserResource.php`, `Tables/UsersTable.php`, `Schemas/UserForm.php`, `Schemas/UserInfolist.php`, `Pages/ViewUser.php`, `Pages/EditUser.php`, `Pages/ListUsers.php`
- `app/Actions/Staff/UpdateStaffMember.php`, `SyncStaffRoles.php`
- `app/Events/RoleAssigned.php`, `RoleRevoked.php`, `app/Listeners/RecordRoleChange.php`, `UpdateLastLoginAt.php`
- `lang/es/staff.php`
- `tests/Feature/HU030/*`, `tests/Feature/HU010/*`, `tests/Feature/Rbac/UserPolicyTest.php`

Si necesitas cambiar un archivo de otro paquete, **no lo edites**: repórtalo como impedimento o coordínalo con su dueño.

## Dependencias con otros paquetes
- **Bloquea a Dev 2:** T-3-01 (modelo `StaffMember` y habilidades de `UserPolicy`) el día 1.
- Dev 2 (T-3-09) usa tu `UserForm` (T-3-04): intégralo pronto.
- Dev 2 usa `SyncStaffRoles` (T-3-05) en la invitación: publica primero la firma del método.
- Agrega en `User` el `use HasInvitation;` de Dev 2.
- T-3-07 espera las acciones de Dev 2.

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
- [ ] Todas las tareas cumplen su "Terminado/Pruebas" de [[Sprint 3 - Gestion de personal#Tareas técnicas]].
- [ ] Cada escenario de las historias del paquete tiene una prueba Pest con su nombre; prueba con rol sin acceso cuando aplica.
- [ ] `pint --test`, `phpstan analyse` y `pest` en verde en local y en CI (SQLite).
- [ ] Solo datos ficticios (`@colegio-piloto.test`); lo nuevo se puede mostrar con `php artisan colegio:demo`.
- [ ] Sin contraseñas, tokens ni secretos en logs ni en `audit_events`; acciones sensibles auditadas.
- [ ] Textos de UI en `lang/es`, en español claro.
- [ ] Tareas marcadas en la nota del sprint y decisiones técnicas anotadas.
- [ ] Reporte final: tareas hechas, pruebas ejecutadas y resultado, impedimentos y deuda técnica. Sin commits ni push (los hace quien invoca).
