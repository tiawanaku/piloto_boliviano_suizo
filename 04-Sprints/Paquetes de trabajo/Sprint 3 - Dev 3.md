---
tipo: paquete
sprint: "[[Sprint 3 - Gestion de personal]]"
developer: Dev 3
agente: php-senior-developer
estado: por hacer
tags: [sprint, paquete, dev3]
---
# Sprint 3 · Dev 3

Volver a [[Paquetes MOC]] · Sprint: [[Sprint 3 - Gestion de personal]] (14/12 – 24/12/2026) · Otros paquetes: [[Sprint 3 - Dev 1]] · [[Sprint 3 - Dev 2]]

## Objetivo del sprint
> El colegio crea, configura y desactiva por sí mismo las cuentas del personal, con trazabilidad completa.

**Foco de este paquete:** Bitácora de auditoría, datos de demostración y regresión de la Fase 1 (HU-014, TEC-16). Si en la Sprint Planning sale HU-014 (decisión del PO), haces T-3-13 y T-3-17 y apoyas a Dev 1/Dev 2 con revisión y pruebas.

## Antes de empezar
1. Lee el detalle de cada tarea en [[Sprint 3 - Gestion de personal#Tareas técnicas]] y las historias enlazadas.
2. Lee [[ADR-005 Stack PHP Laravel y Filament]], [[Stack tecnologico]], [[Roles y permisos RBAC]], [[Flujo de autenticacion]] y la [[Definicion de Terminado]].

## Tareas en orden de ejecución
| # | ID | Tarea | Espera a |
|---|---|---|---|
| 1 | T-3-14 | `AuditEventResource`: lista, orden y filtros | — |
| 2 | T-3-15 | Detalle del evento y control de acceso | T-3-14 |
| 3 | T-3-16 | Exportación CSV auditada | T-3-14 |
| 4 | T-3-13 | Datos de demostración con ficha del personal | T-3-01 (Dev 1) |
| 5 | T-3-17 | Regresión de la Fase 1 y DoD de experiencia en el entorno de demostración | resto del sprint |

## Archivos de este paquete
Solo tú modificas estos archivos en este sprint (rutas bajo `app-colegio/`, salvo `.github/` y el vault):
- `app/Filament/Admin/Resources/AuditEvents/**`
- `app/Actions/Audit/ExportAuditEventsCsv.php`
- `lang/es/audit.php`
- `database/seeders/DemoStaffSeeder.php`, `database/seeders/DemoAuditEventsSeeder.php`
- `tests/Feature/HU014/*`, `tests/Feature/Seeders/*`

Si necesitas cambiar un archivo de otro paquete, **no lo edites**: repórtalo como impedimento o coordínalo con su dueño.

## Dependencias con otros paquetes
- HU-014 no depende de otros paquetes: arranca el día 1.
- T-3-13 usa `StaffMember` (Dev 1, T-3-01); respeta la escala del piloto (≤ 15 administrativos y ≤ 50 docentes ficticios, `@colegio-piloto.test`).
- La regresión (T-3-17) espera que Dev 1 y Dev 2 integren sus historias.

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
