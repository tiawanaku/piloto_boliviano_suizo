---
tipo: paquete
sprint: "[[Sprint 0 - Preparacion]]"
developer: Dev 3
agente: php-senior-developer
estado: por hacer
tags: [sprint, paquete, dev3]
---
# Sprint 0 · Dev 3

Volver a [[Paquetes MOC]] · Sprint: [[Sprint 0 - Preparacion]] (02/11 – 13/11/2026) · Otros paquetes: [[Sprint 0 - Dev 1]] · [[Sprint 0 - Dev 2]]

## Objetivo del sprint
> El equipo puede construir, probar y desplegar automáticamente una versión mínima de la plataforma en el ambiente de pruebas (Laravel 13 + Filament 5 en `app-colegio/`, pruebas en verde, CI y panel `/admin` en staging).

**Foco de este paquete:** Entorno local, correo, colas y staging (TEC-02, TEC-08, TEC-09).

## Antes de empezar
1. Lee el detalle de cada tarea en [[Sprint 0 - Preparacion#Tareas técnicas]] y las historias enlazadas.
2. Lee [[ADR-005 Stack PHP Laravel y Filament]], [[Stack tecnologico]], [[Roles y permisos RBAC]], [[Flujo de autenticacion]] y la [[Definicion de Terminado]].

## Tareas en orden de ejecución
| # | ID | Tarea | Espera a |
|---|---|---|---|
| 1 | T-0-11 | Aprovisionar staging (puede empezar el día 1, no depende del código) | — |
| 2 | T-0-09 | Entorno local con PostgreSQL y Mailpit | T-0-01 (Dev 1) |
| 3 | T-0-10 | Correo y colas | T-0-09 |
| 4 | T-0-12 | Despliegue automático a staging | T-0-06 (Dev 2), T-0-11 |
| 5 | T-0-13 | SMTP institucional en staging y correo de prueba | T-0-10, T-0-11 |

## Archivos de este paquete
Solo tú modificas estos archivos en este sprint (rutas bajo `app-colegio/`, salvo `.github/` y el vault):
- `compose.yaml`, `.env.example` (después de T-0-01), `README.md` de `app-colegio/`
- `resources/views/vendor/mail/**`, `lang/es/mail.php`
- `app/Console/Commands/SendTestMail.php`, `app/Notifications/TestMailNotification.php`
- `deploy/**`, `.github/workflows/deploy-staging.yml`
- `tests/Feature/Infra/*`

Si necesitas cambiar un archivo de otro paquete, **no lo edites**: repórtalo como impedimento o coordínalo con su dueño.

## Dependencias con otros paquetes
- T-0-11 no depende de nadie: empieza el día 1. Si no hay servidor o dominio, regístralo como **impedimento** de inmediato.
- T-0-09 y siguientes esperan T-0-01 (Dev 1).
- T-0-12 espera el workflow de CI de Dev 2 (T-0-06).
- El SMTP institucional depende de TI del colegio (SPF/DKIM): pídelo el día 1.

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
- [ ] Todas las tareas cumplen su "Terminado/Pruebas" de [[Sprint 0 - Preparacion#Tareas técnicas]].
- [ ] Cada escenario de las historias del paquete tiene una prueba Pest con su nombre; prueba con rol sin acceso cuando aplica.
- [ ] `pint --test`, `phpstan analyse` y `pest` en verde en local y en CI (SQLite y PostgreSQL).
- [ ] Sin contraseñas, tokens ni secretos en logs ni en `audit_events`; acciones sensibles auditadas.
- [ ] Textos de UI en `lang/es`, en español claro.
- [ ] Tareas marcadas en la nota del sprint y decisiones técnicas anotadas.
- [ ] Reporte final: tareas hechas, pruebas ejecutadas y resultado, impedimentos y deuda técnica. Sin commits ni push (los hace quien invoca).
