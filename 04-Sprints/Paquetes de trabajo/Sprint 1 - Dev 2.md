---
tipo: paquete
sprint: "[[Sprint 1 - Login base]]"
developer: Dev 2
agente: php-senior-developer
estado: por hacer
tags: [sprint, paquete, dev2]
---
# Sprint 1 · Dev 2

Volver a [[Paquetes MOC]] · Sprint: [[Sprint 1 - Login base]] (16/11 – 27/11/2026) · Otros paquetes: [[Sprint 1 - Dev 1]] · [[Sprint 1 - Dev 3]]

## Objetivo del sprint
> El personal administrativo y docente puede iniciar sesión con su correo institucional, definir su propia contraseña y llegar a su panel según su rol; cada acceso queda registrado.

**Foco de este paquete:** Roles, permisos, cuentas semilla y paneles por rol (TEC-10, TEC-11, HU-007).

## Antes de empezar
1. Lee el detalle de cada tarea en [[Sprint 1 - Login base#Tareas técnicas]] y las historias enlazadas.
2. Lee [[ADR-005 Stack PHP Laravel y Filament]], [[Stack tecnologico]], [[Roles y permisos RBAC]], [[Flujo de autenticacion]] y la [[Definicion de Terminado]].

## Tareas en orden de ejecución
| # | ID | Tarea | Espera a |
|---|---|---|---|
| 1 | T-1-08 | spatie/laravel-permission y enums ⚠️ temprano (día 1–2) | — |
| 2 | T-1-09 | *Seeder* de la matriz RBAC | T-1-08, taller del 03/11 |
| 3 | T-1-11 | Acceso a paneles por rol y rol principal | T-1-09 |
| 4 | T-1-12 | Redirección al panel principal | T-1-11 |
| 5 | T-1-10 | *Factories*, *helpers* de Pest y `colegio:crear-cuenta` | T-1-06 (Dev 1), T-1-09 |
| 6 | T-1-13 | Cambio de panel y panel docente vacío | T-1-12 |
| 7 | T-1-14 | Página 403 y registro del acceso denegado | T-1-11, T-1-15 (Dev 3) |

## Archivos de este paquete
Solo tú modificas estos archivos en este sprint (rutas bajo `app-colegio/`, salvo `.github/` y el vault):
- `composer.json`, `composer.lock` (único dueño en el Sprint 1)
- `config/permission.php` y migración de permisos
- `app/Models/User.php` (dueño; incorporas traits de otros)
- `app/Enums/StaffRole.php`, `app/Enums/Permission.php`
- `database/seeders/*`, `database/factories/UserFactory.php`, `tests/Pest.php`
- `app/Console/Commands/CreateStaffAccount.php`
- `app/Providers/Filament/*PanelProvider.php` (después de T-1-01), `app/Providers/StaffAuthServiceProvider.php`, `bootstrap/providers.php`, `bootstrap/app.php`
- `app/Http/Responses/StaffLoginResponse.php`, `app/Filament/Docente/Pages/Dashboard.php`, `resources/views/errors/403.blade.php`
- `lang/es/roles.php`, `permissions.php`, `panels.php`, `errors.php`
- `tests/Feature/HU007/*`, `tests/Feature/Rbac/*`, `tests/Feature/Commands/*`, `tests/Unit/Enums/*`

Si necesitas cambiar un archivo de otro paquete, **no lo edites**: repórtalo como impedimento o coordínalo con su dueño.

## Dependencias con otros paquetes
- Antes de T-1-09, revisa las decisiones del [[2026-11-03 Taller - Roles y permisos]]; si la matriz cambia, avisa al Scrum Master.
- Esperas T-1-01 (Dev 1) antes de editar los *PanelProviders*.
- T-1-10 usa las columnas de contraseña temporal de Dev 1 (T-1-06).
- T-1-14 usa `AuditLogger` de Dev 3 (T-1-15).
- Entregas pronto T-1-08/T-1-09: Dev 3 (T-1-20) y Dev 1 (T-1-03) dependen de los roles.

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
- [ ] Todas las tareas cumplen su "Terminado/Pruebas" de [[Sprint 1 - Login base#Tareas técnicas]].
- [ ] Cada escenario de las historias del paquete tiene una prueba Pest con su nombre; prueba con rol sin acceso cuando aplica.
- [ ] `pint --test`, `phpstan analyse` y `pest` en verde en local y en CI (SQLite y PostgreSQL).
- [ ] Sin contraseñas, tokens ni secretos en logs ni en `audit_events`; acciones sensibles auditadas.
- [ ] Textos de UI en `lang/es`, en español claro.
- [ ] Tareas marcadas en la nota del sprint y decisiones técnicas anotadas.
- [ ] Reporte final: tareas hechas, pruebas ejecutadas y resultado, impedimentos y deuda técnica. Sin commits ni push (los hace quien invoca).
