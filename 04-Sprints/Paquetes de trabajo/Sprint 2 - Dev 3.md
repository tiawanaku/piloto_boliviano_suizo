---
tipo: paquete
sprint: "[[Sprint 2 - Seguridad del login]]"
developer: Dev 3
agente: php-senior-developer
estado: por hacer
tags: [sprint, paquete, dev3]
---
# Sprint 2 · Dev 3

Volver a [[Paquetes MOC]] · Sprint: [[Sprint 2 - Seguridad del login]] (30/11 – 11/12/2026) · Otros paquetes: [[Sprint 2 - Dev 1]] · [[Sprint 2 - Dev 2]]

## Objetivo del sprint
> Las cuentas del personal están protegidas contra accesos indebidos y cada persona puede recuperar su acceso por sí misma.

**Foco de este paquete:** MFA para roles administrativos (HU-005) y configuración del panel. Los docentes sin rol administrativo no usan MFA en la Fase 1.

## Antes de empezar
1. Lee el detalle de cada tarea en [[Sprint 2 - Seguridad del login#Tareas técnicas]] y las historias enlazadas.
2. Lee [[ADR-005 Stack PHP Laravel y Filament]], [[Stack tecnologico]], [[Roles y permisos RBAC]], [[Flujo de autenticacion]] y la [[Definicion de Terminado]].

## Tareas en orden de ejecución
| # | ID | Tarea | Espera a |
|---|---|---|---|
| 1 | T-2-01 | `StaffPanel`: restablecimiento, perfil y MFA con páginas base ⚠️ debe completarse primero (día 1) | — |
| 2 | T-2-12 | Columnas MFA e interfaces en `User` | T-2-01 |
| 3 | T-2-13 | MFA obligatorio para administrativos | T-2-12 |
| 4 | T-2-14 | Ingreso con código, códigos de respaldo y código incorrecto | T-2-13, T-2-07 (Dev 2) |
| 5 | T-2-15 | Acción "Restablecer MFA" (Soporte TI) | T-2-10 (Dev 2), T-2-12 |
| 6 | T-2-16 | Verificación de la DoD de experiencia en staging | resto del sprint |

## Archivos de este paquete
Solo tú modificas estos archivos en este sprint (rutas bajo `app-colegio/`, salvo `.github/` y el vault):
- `app/Filament/Support/StaffPanel.php` (dueño en el Sprint 2)
- `app/Models/User.php` (dueño en el Sprint 2; incorporas traits de Dev 1 y Dev 2)
- Migración de columnas MFA
- `app/Http/Middleware/EnsureMfaIsConfigured.php`, `app/Listeners/RecordMfaFailure.php`
- `app/Filament/Admin/Resources/Users/Actions/ResetMfaAction.php`
- `lang/es/mfa.php`
- `tests/Feature/HU005/*`, `tests/Unit/Models/UserMfaTest.php`

Si necesitas cambiar un archivo de otro paquete, **no lo edites**: repórtalo como impedimento o coordínalo con su dueño.

## Dependencias con otros paquetes
- **Bloquea a Dev 1:** crea las páginas base de T-2-01 el día 1 y avísale; desde ese momento son de Dev 1.
- Incorpora en `User` los traits `HasAccountLockout` (Dev 2) y `SendsStaffPasswordReset` (Dev 1).
- T-2-14 usa `AccountLockout` (Dev 2) y puede tocar `Login.php` (de Dev 2): coordínalo.
- T-2-15 espera el `UserResource` de Dev 2 (T-2-10).

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
