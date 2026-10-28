---
tipo: paquete
sprint: "[[Sprint 1 - Login base]]"
developer: Dev 3
agente: php-senior-developer
estado: terminado
tags: [sprint, paquete, dev3]
---
# Sprint 1 · Dev 3

Volver a [[Paquetes MOC]] · Sprint: [[Sprint 1 - Login base]] (16/11 – 27/11/2026) · Otros paquetes: [[Sprint 1 - Dev 1]] · [[Sprint 1 - Dev 2]]

## Objetivo del sprint
> El personal administrativo y docente puede iniciar sesión con su correo institucional, definir su propia contraseña y llegar a su panel según su rol; cada acceso queda registrado.

**Foco de este paquete:** Auditoría base, HU-013 y *spikes* que reducen el riesgo del Sprint 2 (TEC-12, HU-013, TEC-14, TEC-15).

## Antes de empezar
1. Lee el detalle de cada tarea en [[Sprint 1 - Login base#Tareas técnicas]] y las historias enlazadas.
2. Lee [[ADR-005 Stack PHP Laravel y Filament]], [[Stack tecnologico]], [[Roles y permisos RBAC]], [[Flujo de autenticacion]] y la [[Definicion de Terminado]].

## Tareas en orden de ejecución
| # | ID | Tarea | Espera a |
|---|---|---|---|
| 1 | T-1-15 | `audit_events`, modelo inmutable y `AuditLogger` ⚠️ temprano (día 1–2) | — |
| 2 | T-1-16 | *Trigger* de inmutabilidad (SQLite; rama `pgsql` preparada) | T-1-15 |
| 3 | T-1-17 | *Listeners* de login y logout | T-1-15 |
| 4 | T-1-18 | *Policy* de auditoría | T-1-15 |
| 5 | T-1-19 | Spike: peso del login en 3G, medido en local (timebox 1 día) | T-1-02 (Dev 1) |
| 6 | T-1-20 | Spike: MFA por rol en Filament 5, solo roles administrativos (timebox 1 día) | T-1-11 (Dev 2) |
| 7 | T-1-21 | Verificación de la DoD de experiencia en el entorno de demostración | resto del sprint |

## Archivos de este paquete
Solo tú modificas estos archivos en este sprint (rutas bajo `app-colegio/`, salvo `.github/` y el vault):
- Migraciones de `audit_events` y del *trigger*
- `app/Models/AuditEvent.php`, `app/Enums/AuditEventType.php`, `app/Services/AuditLogger.php`
- `app/Listeners/RecordSuccessfulLogin.php`, `RecordFailedLogin.php`, `RecordLogout.php`
- `app/Policies/AuditEventPolicy.php`
- `lang/es/audit.php`
- `tests/Feature/HU013/*`, `tests/Unit/Services/AuditLoggerTest.php`
- Sección "Decisiones técnicas" de [[Sprint 1 - Login base]]

Si necesitas cambiar un archivo de otro paquete, **no lo edites**: repórtalo como impedimento o coordínalo con su dueño.

## Dependencias con otros paquetes
- Entrega T-1-15 lo antes posible: Dev 2 (T-1-14) lo necesita.
- Los *listeners* se descubren solos: no edites *providers*.
- El spike de MFA se hace en una rama descartable; no integres código del prototipo.
- Si los spikes cambian el ADR, propón la actualización de [[ADR-005 Stack PHP Laravel y Filament]] al Scrum Master.

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
- [ ] Todas las tareas cumplen su "Terminado/Pruebas" de [[Sprint 1 - Login base#Tareas técnicas]].
- [ ] Cada escenario de las historias del paquete tiene una prueba Pest con su nombre; prueba con rol sin acceso cuando aplica.
- [ ] `pint --test`, `phpstan analyse` y `pest` en verde en local y en CI (SQLite).
- [ ] Solo datos ficticios (`@colegio-piloto.test`); lo nuevo se puede mostrar con `php artisan colegio:demo`.
- [ ] Sin contraseñas, tokens ni secretos en logs ni en `audit_events`; acciones sensibles auditadas.
- [ ] Textos de UI en `lang/es`, en español claro.
- [ ] Tareas marcadas en la nota del sprint y decisiones técnicas anotadas.
- [ ] Reporte final: tareas hechas, pruebas ejecutadas y resultado, impedimentos y deuda técnica. Sin commits ni push (los hace quien invoca).

## Cierre (27/11/2026)
Tareas T-1-15 a T-1-20 hechas; T-1-21 parcial (sin navegador). *Spikes*: MFA por rol viable (ver [[Spike T-1-20 MFA por rol]]); el login pesa ≈ 334 KB con gzip y no cumple el RNF (ver [[Spike T-1-19 Peso del login en 3G]]). Corrigió el bug de las etiquetas de auditoría con punto. Detalle en [[Sprint 1 - Login base#Cierre del sprint (27/11/2026)]] y [[2026-11-27 Retrospectiva - Sprint 1]].
