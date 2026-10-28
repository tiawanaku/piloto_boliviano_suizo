---
tipo: paquete
sprint: "[[Sprint 0 - Preparacion]]"
developer: Dev 2
agente: php-senior-developer
estado: por hacer
tags: [sprint, paquete, dev2]
---
# Sprint 0 · Dev 2

Volver a [[Paquetes MOC]] · Sprint: [[Sprint 0 - Preparacion]] (02/11 – 13/11/2026) · Otros paquetes: [[Sprint 0 - Dev 1]] · [[Sprint 0 - Dev 3]]

## Objetivo del sprint
> El equipo puede construir, probar y desplegar automáticamente una versión mínima de la plataforma en el ambiente de pruebas (Laravel 13 + Filament 5 en `app-colegio/`, pruebas en verde, CI y panel `/admin` en staging).

**Foco de este paquete:** Herramientas de calidad y CI (TEC-03, TEC-04).

## Antes de empezar
1. Lee el detalle de cada tarea en [[Sprint 0 - Preparacion#Tareas técnicas]] y las historias enlazadas.
2. Lee [[ADR-005 Stack PHP Laravel y Filament]], [[Stack tecnologico]], [[Roles y permisos RBAC]], [[Flujo de autenticacion]] y la [[Definicion de Terminado]].

## Tareas en orden de ejecución
| # | ID | Tarea | Espera a |
|---|---|---|---|
| 1 | T-0-05 | Configurar Pest 4, Larastan (nivel 6), Pint y `composer quality` | T-0-01 (Dev 1) |
| 2 | T-0-06 | Workflow de CI en GitHub Actions | T-0-05 |
| 3 | T-0-07 | Plantilla de PR y protección de `main` | T-0-06 |
| 4 | T-0-08 | Pruebas de humo | T-0-03 (Dev 1), T-0-05 |

## Archivos de este paquete
Solo tú modificas estos archivos en este sprint (rutas bajo `app-colegio/`, salvo `.github/` y el vault):
- `phpunit.xml`, `tests/Pest.php`, `tests/TestCase.php`
- `phpstan.neon`, `pint.json`
- `.github/workflows/app-colegio.yml`, `.github/pull_request_template.md`
- `tests/Feature/Smoke/*`

Si necesitas cambiar un archivo de otro paquete, **no lo edites**: repórtalo como impedimento o coordínalo con su dueño.

## Dependencias con otros paquetes
- Esperas T-0-01 (Dev 1) para empezar.
- No modificas `composer.json`: las dependencias de desarrollo las instala Dev 1 en T-0-01. Si falta una, pídesela.
- Dev 3 (T-0-12) espera tu T-0-06 para encadenar el despliegue.

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
