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

**Foco de este paquete:** MFA para roles administrativos (HU-005), configuración del panel, fuentes del sistema (TEC-21) y tipos de auditoría del sprint. Los docentes sin rol administrativo no usan MFA en la Fase 1.

## Antes de empezar
1. Lee el detalle de cada tarea en [[Sprint 2 - Seguridad del login#Tareas técnicas]] y las historias enlazadas.
2. Lee [[ADR-005 Stack PHP Laravel y Filament]], [[Stack tecnologico]], [[Roles y permisos RBAC]], [[Flujo de autenticacion]] y la [[Definicion de Terminado]].

## Tareas en orden de ejecución
| # | ID | Tarea | Espera a |
|---|---|---|---|
| 1 | T-2-01 | `StaffPanel`: restablecimiento, perfil, fuentes del sistema y tipos de auditoría del sprint (sin activar MFA) ⚠️ debe completarse primero (día 1) | — |
| 2 | T-2-12 | Columnas MFA, *traits* de Filament y `requiresMultiFactorAuthentication()` en `User` (día 2) | T-2-01 |
| 3 | T-2-13 | Activación del MFA obligatorio para administrativos (`EnsureAdministrativeMfa`) | T-2-12, T-2-17 (Dev 2) |
| 4 | T-2-14 | Desafío, códigos de respaldo y código incorrecto (*listener*) | T-2-13, T-2-07 y T-2-08 (Dev 2) |
| 5 | T-2-16 | Verificación de la DoD de experiencia y lista para la verificación manual | resto del sprint |

## Archivos de este paquete
Solo tú modificas estos archivos en este sprint (rutas bajo `app-colegio/`, salvo `.github/` y el vault):
- `app/Filament/Support/StaffPanel.php`, `app/Filament/Support/SystemFontProvider.php`, `app/Filament/Support/StaffAppAuthentication.php` (dueño en el Sprint 2)
- `app/Models/User.php` (dueño en el Sprint 2; incorporas los *traits* de Dev 1 y Dev 2)
- `app/Enums/AuditEventType.php`, `lang/es/audit.php` (todos los tipos del sprint en T-2-01)
- Migración de columnas MFA
- `app/Http/Middleware/EnsureAdministrativeMfa.php`, `app/Listeners/RecordMfaFailure.php`
- `lang/vendor/filament-panels/es/auth/multi-factor/**`
- `tests/Feature/HU005/*` (salvo `ResetMfaTest.php`), `tests/Unit/Models/UserMfaTest.php`

Si necesitas cambiar un archivo de otro paquete, **no lo edites**: repórtalo como impedimento o coordínalo con su dueño.

## Dependencias con otros paquetes
- **Bloquea a Dev 1:** crea las páginas base de T-2-01 el día 1 y avísale; desde ese momento son de Dev 1.
- No actives el MFA (T-2-13) hasta que Dev 2 integre T-2-17.
- Entrega T-2-12 el día 2: Dev 2 lo necesita para T-2-17, T-2-15 y T-2-11.
- Incorpora en `User` los *traits* `HasAccountLockout` (Dev 2) y `SendsStaffPasswordReset` (Dev 1).
- No toques `Login.php` (de Dev 2): escucha `MultiFactorChallengeFailed`.
- La verificación en navegador real la completa una persona (PO o usuario) con tu lista; el entorno de los agentes no tiene navegador.

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
