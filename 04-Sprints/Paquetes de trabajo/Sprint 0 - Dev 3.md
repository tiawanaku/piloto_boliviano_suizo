---
tipo: paquete
sprint: "[[Sprint 0 - Preparacion]]"
developer: Dev 3
agente: php-senior-developer
estado: terminado
tags: [sprint, paquete, dev3]
---
# Sprint 0 · Dev 3

Volver a [[Paquetes MOC]] · Sprint: [[Sprint 0 - Preparacion]] (02/11 – 13/11/2026) · Otros paquetes: [[Sprint 0 - Dev 1]] · [[Sprint 0 - Dev 2]]

## Objetivo del sprint
> El equipo puede construir, probar automáticamente y demostrar una versión mínima de la plataforma en el entorno de demostración (Laravel 13 + Filament 5 en `app-colegio/`, pruebas en verde, CI y panel `/admin` con `colegio:demo`).

**Foco de este paquete:** Idioma, entorno local, correo, colas y entorno de demostración (TEC-07, TEC-02, TEC-08, TEC-09). Sin staging ni SMTP real (alcance piloto).

## Antes de empezar
1. Lee el detalle de cada tarea en [[Sprint 0 - Preparacion#Tareas técnicas]] y las historias enlazadas.
2. Lee [[ADR-005 Stack PHP Laravel y Filament]], [[Stack tecnologico]], [[Roles y permisos RBAC]], [[Flujo de autenticacion]] y la [[Definicion de Terminado]].

## Tareas en orden de ejecución
| # | ID | Tarea | Espera a |
|---|---|---|---|
| 1 | T-0-09 | Entorno local con SQLite y `composer dev` | T-0-01 (Dev 1) |
| 2 | T-0-04 | Localización `lang/es` | T-0-01 (Dev 1) |
| 3 | T-0-10 | Correo y colas (driver `log`, Mailpit opcional) | T-0-09 |
| 4 | T-0-11 | Entorno de demostración: `colegio:demo` y guía | T-0-03 (Dev 1), T-0-09 |

## Archivos de este paquete
Solo tú modificas estos archivos en este sprint (rutas bajo `app-colegio/`, salvo `.github/` y el vault):
- `.env.example` (después de T-0-01), `README.md` de `app-colegio/`
- `lang/es/auth.php`, `passwords.php`, `validation.php`, `pagination.php`, `mail.php`, `demo.php`
- `resources/views/vendor/mail/**`, `routes/console.php`
- `app/Console/Commands/SendTestMail.php`, `app/Console/Commands/PrepareDemo.php`, `app/Notifications/TestMailNotification.php`
- `tests/Feature/Infra/*`, `tests/Feature/Localization/*`, `tests/Feature/Commands/PrepareDemoTest.php`

Si necesitas cambiar un archivo de otro paquete, **no lo edites**: repórtalo como impedimento o coordínalo con su dueño.

## Dependencias con otros paquetes
- Todas tus tareas esperan T-0-01 (Dev 1).
- T-0-11 usa la cuenta de demostración que crea Dev 1 en T-0-03 (`DatabaseSeeder`).
- Solo datos ficticios `@colegio-piloto.test`; ningún correo sale a personas reales.

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
- [ ] Todas las tareas cumplen su "Terminado/Pruebas" de [[Sprint 0 - Preparacion#Tareas técnicas]].
- [ ] Cada escenario de las historias del paquete tiene una prueba Pest con su nombre; prueba con rol sin acceso cuando aplica.
- [ ] `pint --test`, `phpstan analyse` y `pest` en verde en local y en CI (SQLite).
- [ ] Solo datos ficticios (`@colegio-piloto.test`); lo nuevo se puede mostrar con `php artisan colegio:demo`.
- [ ] Sin contraseñas, tokens ni secretos en logs ni en `audit_events`; acciones sensibles auditadas.
- [ ] Textos de UI en `lang/es`, en español claro.
- [ ] Tareas marcadas en la nota del sprint y decisiones técnicas anotadas.
- [ ] Reporte final: tareas hechas, pruebas ejecutadas y resultado, impedimentos y deuda técnica. Sin commits ni push (los hace quien invoca).

## Cierre (13/11/2026)
Todas las tareas hechas (T-0-09, T-0-04, T-0-10, T-0-11). Se agregó `lang/es/demo.php` (textos de `colegio:demo`), aceptado dentro del paquete. El SM verificó el arranque desde cero con el README en una copia limpia: funciona; `composer dev` requiere `npm install`, como indica el README. Detalle en [[Sprint 0 - Preparacion#Cierre del sprint (13/11/2026)]] y [[2026-11-13 Retrospectiva - Sprint 0]].
