---
tipo: paquete
sprint: "[[Sprint 0 - Preparacion]]"
developer: Dev 1
agente: php-senior-developer
estado: por hacer
tags: [sprint, paquete, dev1]
---
# Sprint 0 · Dev 1

Volver a [[Paquetes MOC]] · Sprint: [[Sprint 0 - Preparacion]] (02/11 – 13/11/2026) · Otros paquetes: [[Sprint 0 - Dev 2]] · [[Sprint 0 - Dev 3]]

## Objetivo del sprint
> El equipo puede construir, probar y desplegar automáticamente una versión mínima de la plataforma en el ambiente de pruebas (Laravel 13 + Filament 5 en `app-colegio/`, pruebas en verde, CI y panel `/admin` en staging).

**Foco de este paquete:** Esqueleto del proyecto, identidad base, paneles e idioma (TEC-01, TEC-06, TEC-05, TEC-07).

## Antes de empezar
1. Lee el detalle de cada tarea en [[Sprint 0 - Preparacion#Tareas técnicas]] y las historias enlazadas.
2. Lee [[ADR-005 Stack PHP Laravel y Filament]], [[Stack tecnologico]], [[Roles y permisos RBAC]], [[Flujo de autenticacion]] y la [[Definicion de Terminado]].

## Tareas en orden de ejecución
| # | ID | Tarea | Espera a |
|---|---|---|---|
| 1 | T-0-01 | Crear proyecto Laravel 13 e instalar **todas** las dependencias Composer del sprint ⚠️ debe completarse primero (día 1) | — |
| 2 | T-0-02 | Identidad base: `User` UUID, `AccountStatus`, Argon2id, sesiones en BD | T-0-01 |
| 3 | T-0-04 | Localización `lang/es` | T-0-01 |
| 4 | T-0-03 | Paneles Filament `admin` y `docente` | T-0-02 |

## Archivos de este paquete
Solo tú modificas estos archivos en este sprint (rutas bajo `app-colegio/`, salvo `.github/` y el vault):
- Esqueleto completo de `app-colegio/` (hasta integrar T-0-01)
- `composer.json`, `composer.lock` (único dueño en el Sprint 0)
- `config/app.php`, `config/colegio.php`
- `database/migrations/0001_01_01_000000_create_users_table.php`
- `app/Models/User.php`, `app/Enums/AccountStatus.php`, `database/factories/UserFactory.php`, `database/seeders/DatabaseSeeder.php`
- `app/Providers/Filament/*`, `bootstrap/providers.php`
- `lang/es/*.php` (salvo `lang/es/mail.php`)
- `tests/Unit/Models/UserTest.php`, `tests/Feature/Panels/*`, `tests/Feature/Localization/*`

Si necesitas cambiar un archivo de otro paquete, **no lo edites**: repórtalo como impedimento o coordínalo con su dueño.

## Dependencias con otros paquetes
- **Bloquea a todos:** Dev 2 y Dev 3 esperan la integración de T-0-01 en `main`. Avísales en cuanto esté.
- `.env.example`: lo dejas completo en T-0-01; después pasa a Dev 3.
- `phpunit.xml` y `tests/Pest.php` son de Dev 2: si necesitas algo, pídeselo.
- T-0-08 (Dev 2) espera tu T-0-03.

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
