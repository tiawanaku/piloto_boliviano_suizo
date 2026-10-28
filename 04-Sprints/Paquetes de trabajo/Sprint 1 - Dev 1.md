---
tipo: paquete
sprint: "[[Sprint 1 - Login base]]"
developer: Dev 1
agente: php-senior-developer
estado: terminado
tags: [sprint, paquete, dev1]
---
# Sprint 1 · Dev 1

Volver a [[Paquetes MOC]] · Sprint: [[Sprint 1 - Login base]] (16/11 – 27/11/2026) · Otros paquetes: [[Sprint 1 - Dev 2]] · [[Sprint 1 - Dev 3]]

## Objetivo del sprint
> El personal administrativo y docente puede iniciar sesión con su correo institucional, definir su propia contraseña y llegar a su panel según su rol; cada acceso queda registrado.

**Foco de este paquete:** Login, cierre de sesión, contraseña temporal y cabeceras (HU-001, HU-002, HU-006, TEC-13).

## Antes de empezar
1. Lee el detalle de cada tarea en [[Sprint 1 - Login base#Tareas técnicas]] y las historias enlazadas.
2. Lee [[ADR-005 Stack PHP Laravel y Filament]], [[Stack tecnologico]], [[Roles y permisos RBAC]], [[Flujo de autenticacion]] y la [[Definicion de Terminado]].

## Tareas en orden de ejecución
| # | ID | Tarea | Espera a |
|---|---|---|---|
| 1 | T-1-01 | `StaffPanel` (configuración compartida) ⚠️ debe completarse primero (día 1) | — |
| 2 | T-1-06 | Política de contraseñas y columnas de contraseña temporal | — |
| 3 | T-1-02 | Login personalizado: validaciones y mensajes | T-1-01 |
| 4 | T-1-04 | Cierre de sesión, inactividad y "atrás" | T-1-01 |
| 5 | T-1-05 | Cabeceras de seguridad | T-1-01 |
| 6 | T-1-07 | Página "Cambiar contraseña" obligatoria | T-1-01, T-1-06 |
| 7 | T-1-03 | Login: estados de cuenta e ingreso exitoso | T-1-02, T-1-12 (Dev 2) |

## Archivos de este paquete
Solo tú modificas estos archivos en este sprint (rutas bajo `app-colegio/`, salvo `.github/` y el vault):
- `app/Filament/Support/StaffPanel.php`
- `app/Filament/Pages/Auth/Login.php`, `app/Filament/Pages/Auth/ChangeTemporaryPassword.php`
- `app/Rules/InstitutionalEmail.php`, `app/Rules/NotCommonPassword.php`, `resources/data/common-passwords.txt`
- `app/Http/Middleware/PreventBackHistory.php`, `SecurityHeaders.php`, `EnsurePasswordIsChanged.php`
- `app/Models/Concerns/HasTemporaryPassword.php` y su migración
- `app/Providers/AppServiceProvider.php`, `config/session.php`
- `lang/es/auth.php`, `lang/es/passwords.php`
- `tests/Feature/HU001/*`, `HU002/*`, `HU006/*`, `tests/Feature/Security/*`, `tests/Unit/Rules/*`

Si necesitas cambiar un archivo de otro paquete, **no lo edites**: repórtalo como impedimento o coordínalo con su dueño.

## Dependencias con otros paquetes
- Espera a que Dev 2 integre T-1-22 (formato del esqueleto, día 1) antes de editar `AppServiceProvider.php` y `config/session.php`; T-1-01 puede empezar en paralelo.
- En T-1-01 tocas una línea de cada *PanelProvider*; después son de Dev 2.
- `User` usa los atributos `#[Fillable]`/`#[Hidden]` de Laravel 13: declara las columnas nuevas ahí o en tu *trait*.
- `User.php` es de Dev 2: entregas el trait `HasTemporaryPassword` y Dev 2 agrega el `use` (T-1-10 lo necesita).
- T-1-03 espera la redirección de Dev 2 (T-1-12); mientras tanto, prueba solo la autenticación.
- Dev 3 (T-1-19) mide el login cuando tu T-1-02 esté integrada.

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
Todas las tareas hechas (T-1-01 a T-1-07) en las oleadas 1–3. Pruebas de HU-001, HU-002 y HU-006 en verde. La variable de inactividad es `COLEGIO_SESION_INACTIVIDAD_MINUTOS` (sustituye a `SESSION_LIFETIME`). Pendiente: la verificación manual en navegador (DoD de experiencia). Detalle en [[Sprint 1 - Login base#Cierre del sprint (27/11/2026)]] y [[2026-11-27 Retrospectiva - Sprint 1]].
