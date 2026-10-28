---
tipo: reunion
tipo_reunion: review
fecha: 2026-11-13
sprint: "[[Sprint 0 - Preparacion]]"
tags: [reunion, review]
---
# Sprint Review · Sprint 0

Volver a [[Reuniones MOC]] · Sprint: [[Sprint 0 - Preparacion]] · Retro: [[2026-11-13 Retrospectiva - Sprint 0]] · Plantilla: [[Plantilla Sprint Review]]

**Asistentes:** Product Owner, Scrum Master, Developers (Dev 1, Dev 2, Dev 3). La dirección del colegio fue invitada.
**Alcance:** 🧪 piloto con datos ficticios ([[2026-10-28 Decisiones de la direccion]]).

## Objetivo del sprint
"El equipo puede construir, probar automáticamente y demostrar una versión mínima de la plataforma en el entorno de demostración." → ✅ **logrado, aceptado con observaciones**

### Inspección del PO (13/11/2026, sobre `app-colegio/`, sin modificar código)
| Verificación | Resultado |
|---|---|
| `vendor/bin/pest` | ✅ 43/43 pruebas, 109 aserciones |
| `php artisan colegio:demo --force` | ✅ regenera la base y muestra las URL de `/admin` y `/docente` y la cuenta ficticia `demo@colegio-piloto.test`; avisa que solo hay datos ficticios y que los correos no salen |
| `/admin/login` · `/docente/login` | ✅ 200, formulario en español ("Correo electrónico", "Contraseña", "Entrar") |
| `/admin` sin sesión | ✅ 302 al login |
| Datos ficticios | ✅ `config/colegio.php` con el dominio `colegio-piloto.test`; no hay dominios reales en `app/`, `database/` ni `lang/` |
| README | ✅ arranque desde cero y guía de demostración en español (verificado por el SM en una copia limpia) |
| CI en GitHub | ⚠️ workflow y plantilla de PR en `.github/`, pero **todavía no se ejecutaron** |
| Protección de `main` | ❌ falta (impedimento: necesita administrador del repositorio) |

### Decisión del PO
Acepto el objetivo. El Sprint 0 no tenía historias: su valor es la base técnica, y esa base se puede **construir** (README), **probar automáticamente** (Pest, Pint y Larastan, que corren con un comando) y **demostrar** (`colegio:demo`) con datos ficticios, como pide la [[Definicion de Terminado]] en su alcance piloto.

Hay dos criterios de la DoD que no se demostraron: *PR revisado por otra persona* y *CI de GitHub en verde*. No los acepto como terminados. Pasan como condición al Sprint 1: **ninguna historia del S1 se acepta sin entrar por PR con el CI de GitHub en verde** (T-1-23 / TEC-19). La protección de `main` (TEC-20) queda como impedimento del SM.

## Terminado (cumple DoD)
| Elemento | Demo realizada por | Feedback |
|---|---|---|
| Proyecto Laravel 13 + Filament 5, paneles `admin` y `docente` (T-0-01 a T-0-03) | Dev 1 | Paneles y login en español. El login de Filament es la base de [[HU-001 Iniciar sesion con correo institucional]]. |
| Calidad: Pest, Larastan, Pint y pruebas de humo (T-0-05, T-0-08) | Dev 2 | Bien. Las pruebas con el nombre del criterio en español facilitan la aceptación. |
| Idioma, correo capturado y `colegio:demo` (T-0-04, T-0-09 a T-0-11) | Dev 3 | Muy útil para las demostraciones. Que se niegue a correr en `production` y repita que los datos son ficticios refuerza el alcance piloto. |

## No terminado (vuelve al backlog)
- T-0-06: el CI está escrito pero no se ejecutó en GitHub → primera ejecución en el S1 (T-1-23).
- T-0-07: falta la protección de `main` → impedimento abierto (TEC-20).
- Una cuenta ficticia por rol: llega con los roles (S1) y `DemoStaffSeeder` (S2).

## Feedback de stakeholders
- La dirección no asistió. El PO le enviará un resumen con la forma de ejecutar `colegio:demo` para que pruebe el login.
- El [[2026-11-03 Taller - Roles y permisos]] no tiene decisiones registradas. **Responsabilidad del PO:** confirmar con la dirección, antes del 18/11, la matriz de [[Roles y permisos RBAC]] que usará T-1-09. Mientras tanto vale la matriz vigente.

## Cambios al Product Backlog
- **Sin cambios de orden.** Las historias del Sprint 1 (HU-001, HU-007, HU-002, HU-006, HU-013; 17 pts) siguen siendo las de mayor valor: son la puerta de entrada y todo lo demás depende de ellas.
- **Objetivo del Sprint 1 confirmado**, con una precisión de alcance piloto: cuentas ficticias y demostrable con `colegio:demo` (ver [[Sprint 1 - Login base]]).
- **DoD:** el PO confirma los dos ajustes del SM, que adaptan la DoD al alcance piloto sin relajar la calidad:
  1. CI **solo con SQLite**: el piloto no tiene producción ni PostgreSQL obligatorio, y SQLite es la base del entorno de demostración.
  2. **"Demostrable en el entorno de demostración"** en lugar de "desplegado en staging": no hay staging en el piloto.
  Ambos quedan registrados en la [[Definicion de Terminado]].

## Proyección / roadmap
- Sin cambios: S1 del 16/11 al 27/11/2026 (17 pts), luego S2 (19) y S3 (18). Después, el MVP del piloto (39 pts) desde el 04/01/2027 ([[Fases y roadmap]]).
- Riesgo a vigilar en el S1: personalizar el login de Filament y aplicar el MFA por rol (spikes T-1-19 y T-1-20). Si el S2 se aprieta, la primera historia en salir es HU-029.

## Acciones
| Acción | Responsable | Fecha |
|---|---|---|
| Confirmar con la dirección la matriz RBAC (decisiones del taller) | Product Owner | 18/11/2026 |
| Primera ejecución del CI en GitHub; todo entra por PR con CI en verde | Dev 2 / Scrum Master | Inicio del S1 |
| Gestionar la protección de `main` con el dueño del repositorio | Scrum Master | S1 |
| Enviar a la dirección el resumen y la guía de demostración | Product Owner | 16/11/2026 |
