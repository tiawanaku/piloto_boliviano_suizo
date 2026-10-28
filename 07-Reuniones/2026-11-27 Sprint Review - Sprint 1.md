---
tipo: reunion
tipo_reunion: review
fecha: 2026-11-27
sprint: "[[Sprint 1 - Login base]]"
tags: [reunion, review]
---
# Sprint Review · Sprint 1

Volver a [[Reuniones MOC]] · Sprint: [[Sprint 1 - Login base]] · Retro: [[2026-11-27 Retrospectiva - Sprint 1]] · Anterior: [[2026-11-13 Sprint Review - Sprint 0]] · Plantilla: [[Plantilla Sprint Review]]

**Asistentes:** Product Owner, Scrum Master, Developers (Dev 1, Dev 2, Dev 3). El usuario (dirección del piloto) fue invitado a verificar la demo en su navegador.
**Alcance:** 🧪 piloto con datos ficticios ([[2026-10-28 Decisiones de la direccion]]).

## Objetivo del sprint
"El personal administrativo y docente puede iniciar sesión con su correo institucional, definir su propia contraseña y llegar a su panel según su rol; cada acceso queda registrado." → ✅ **logrado, aceptado con condición**

### Inspección del PO (27/11/2026, sin modificar código)
| Verificación | Resultado |
|---|---|
| `vendor/bin/pest` en `app-colegio/` | ✅ 397/397 pruebas, 991 aserciones |
| `colegio:demo --force` contra una base SQLite en el scratchpad (sin tocar la base del repo) | ✅ 7 cuentas ficticias: una por rol + `demo@` (Coordinación + Docente), contraseña `password` |
| Escenarios Gherkin ↔ pruebas | ✅ cada escenario de HU-001 (5), HU-002 (2), HU-006 (3), HU-007 (4) y HU-013 (2) tiene al menos una prueba Pest con su nombre, más los casos de borde (cuenta desactivada con contraseña errónea, `no-store` contra el botón "atrás", sesión regenerada, auditoría sin contraseña ni hash, *trigger* que impide editar o borrar la auditoría) |
| CI de GitHub (PR #1) | ✅ `pint`, `phpstan`, `pest` y `audit` en verde (verificado por el SM) |
| PR revisado por una persona | ⚠️ el PR #1 sigue en **borrador**, sin revisión humana ni fusión |
| Experiencia en navegador real (Chrome, Firefox, Android, 3G, Lighthouse) | ⏳ sin verificar: el entorno de los agentes no tiene navegador. El SM solo hizo un recorrido por HTTP (T-1-21) |
| Peso del login | ⚠️ ≈ 267 KB con gzip, usando fuentes del sistema: no cumplía el RNF de 200 KB → RNF ajustado (abajo) |

## Terminado (cumple DoD) — aceptación por historia
| Historia | Pts | Decisión del PO | Feedback |
|---|---|---|---|
| [[HU-001 Iniciar sesion con correo institucional]] | 5 | ✅ aceptada con condición **A + B** | Mensajes genéricos correctos. Cumple el nuevo RNF de peso. El tono mezcla "usted" y "tú" (DEF-01): se corrige en el S2, no bloquea. |
| [[HU-007 Panel segun rol]] | 5 | ✅ aceptada con condición **A + B** | Bien que el login del "otro" panel lleve al panel principal y que el 403 quede auditado. El orden de prioridad de los roles hay que confirmarlo con la dirección. |
| [[HU-002 Cerrar sesion]] | 1 | ✅ aceptada con condición **A + B** | La inactividad se configura con `COLEGIO_SESION_INACTIVIDAD_MINUTOS` (30): OK. |
| [[HU-006 Cambio de contrasena en primer ingreso]] | 3 | ✅ aceptada con condición **A + B** | Política, vencimiento a las 72 h y auditoría del cambio: OK. |
| [[HU-013 Registro de auditoria de accesos]] | 3 | ✅ aceptada con condición **A** | Inmutabilidad garantizada en la base de datos. `actor_id` sin clave foránea: justificado. |
| **Total** | **17** | **17 pts aceptados con condición** | |

**Condiciones de aceptación** (la DoD no se relaja):
- **A — PR revisado:** una persona (el usuario o quien designe) revisa y aprueba el PR #1 y lo fusiona en `main`. El CI en verde ya está.
- **B — Experiencia en navegador real:** el usuario recorre la demo con la lista de la sección [[#Para el usuario]]. Si una historia falla un punto **bloqueante** (no se puede entrar, se ve información protegida tras salir, falta un 403, la página es ilegible en el móvil), **vuelve al backlog** y la velocidad del S1 se corrige. Los defectos cosméticos se registran como defectos para el S2 sin revertir la aceptación.
- **Plazo:** antes de la Sprint Planning del S2 (30/11/2026). Si no se verifica a tiempo, las historias siguen "aceptadas con condición" y la verificación se repite en la Review del S2 junto con las del S2.

## No terminado (vuelve al backlog)
- Ninguna historia. Quedan abiertos:
  - T-1-21 (parcial): verificación en navegador → condición B.
  - TEC-20: protección de `main` → impedimento del SM, la debe activar el dueño del repositorio.

## Decisiones del PO sobre las propuestas del SM ([[Backlog tecnico#Propuestas al Product Owner]])
| # | Propuesta | Decisión | Motivo / dónde se aplica |
|---|---|---|---|
| 1 | RNF de peso: primera visita < 300 KB comprimida, siguientes < 50 KB | ✅ **Aceptada** | 200 KB no se alcanza con Filament sin duplicar el login (MFA, límites y auditoría). Se mantiene < 10 s en 3G. Actualizados [[Requisitos no funcionales]] y [[Pantalla login personal]]. Las visitas siguientes requieren caché del servidor web; en la demo con `php artisan serve` es orientativo. |
| 2 | Tratar de **"tú"** en toda la interfaz | ✅ **Aceptada** | Es lo que ya usan nuestros mensajes, y es cercano para docentes y familias. Se incorpora a la [[Definicion de Terminado]] (Experiencia de usuario). Lo corrige T-2-18 (DEF-01). |
| 3 | Límite de **20 intentos fallidos/min por IP** (los correctos no cuentan) | ✅ **Aceptada** | Complementa el bloqueo por cuenta frente a ataques que prueban muchos correos. Nuevo escenario en [[HU-004 Bloqueo por intentos fallidos]] (configurable). |
| 4 | **Contraseña temporal** al restablecer el MFA | ✅ **Aceptada** | Cierra un hueco real de seguridad y reutiliza HU-006. Escenario ampliado en [[HU-005 MFA para personal administrativo]]. Si la estimación supera 8 pts, sale HU-029 del S2. |
| 5 | No permitir MFA voluntario a docentes | ℹ️ **No la decide el PO** | La dirección dejó el MFA de docentes **pendiente y fuera de la Fase 1**. El PO solo confirma que **en la Fase 1 no se ofrece** a docentes, ni obligatorio ni voluntario (escenario en HU-005). La decisión sigue pendiente para la dirección. |

## Feedback de stakeholders
- Pendiente del usuario: la verificación en su navegador (condición B).
- Para confirmar con la dirección: el orden de prioridad de los roles (Dirección > Secretaría > Coordinación > TI > Oficina > Docente), que decide a qué panel entra quien tiene varios roles.
- Observación del PO: la contraseña `password` de las cuentas de demo no cumpliría la política. Es aceptable **solo** para la demo del piloto; no debe usarse fuera de ella.

## Cambios al Product Backlog
- HU-001, HU-002, HU-006, HU-007 y HU-013 pasan a estado **aceptada-condicional**. EP-01 y EP-08 pasan a **en-progreso**.
- HU-004: escenario de límite por IP. HU-005: contraseña temporal al restablecer el MFA y escenario de docentes sin MFA.
- Sin cambios de orden.

## Sprint 2: objetivo y alcance confirmados
- **Objetivo:** "Las cuentas del personal están protegidas contra accesos indebidos y cada persona puede recuperar su acceso por sí misma." → **se confirma**.
- **Alcance:** [[HU-003 Recuperar contrasena]] (5), [[HU-004 Bloqueo por intentos fallidos]] (3), [[HU-005 MFA para personal administrativo]] (8), [[HU-029 Mi cuenta datos y cambio de contrasena]] (3) = **19 pts**. Velocidad real del S1: 17 (condicionada).
- **Si hay que recortar, sale primero HU-029.** Ver [[Sprint 2 - Seguridad del login]].

## Proyección / roadmap
- Sin cambios: S2 del 30/11 al 11/12 (19 pts) → H1 "Personal puede ingresar". S3 del 14/12 al 24/12 (18 pts). MVP del piloto desde el 04/01/2027 ([[Fases y roadmap]]).

## Para el usuario
Cómo probar la demo en tu navegador (desde `app-colegio/`, según su README):

```bash
composer install && cp .env.example .env && php artisan key:generate   # solo la primera vez
php artisan colegio:demo --force     # regenera la base solo con datos ficticios
composer dev                         # o: php artisan serve  (y en otra terminal: php artisan queue:work)
```

Abre http://127.0.0.1:8000/admin. Todas las cuentas usan la contraseña `password`:
- `director@`, `academic.secretary@`, `pedagogical.coordinator@`, `it.support@`, `information.office@`, `teacher@` y `demo@` (las direcciones completas terminan en `colegio-piloto.test`).
- Para probar HU-006: `php artisan colegio:crear-cuenta prueba@colegio-piloto.test --rol=teacher` muestra una contraseña temporal una sola vez.

**Qué verificar** (en Chrome y Firefox de escritorio y en un Android; marca ✅ o ❌):
1. **HU-001:** entrar con `director@`. Con contraseña errónea aparece "Correo o contraseña incorrectos". Con un correo `@gmail.com` aparece "Usa tu correo institucional". Con los campos vacíos se indica qué falta. Funciona el botón mostrar/ocultar contraseña.
2. **HU-007:** `teacher@` llega a "Mis aulas" (panel docente) aunque entre por `/admin`. Abrir `/admin` siendo `teacher@` → "No tienes permiso para ver esta página". `demo@` puede cambiar de panel desde el menú.
3. **HU-002:** al salir, el botón "atrás" del navegador no muestra el panel. Con `COLEGIO_SESION_INACTIVIDAD_MINUTOS=1` en `.env` (y `php artisan config:clear`), tras 1 minuto sin actividad pide entrar de nuevo.
4. **HU-006:** con la cuenta temporal, te obliga a definir tu contraseña. Rechaza una contraseña corta o común con un mensaje claro.
5. **Experiencia:**
   - En DevTools → Network → "Slow 3G", el login carga en menos de 10 s.
   - Se navega solo con el teclado (Tab y Enter) y se ve el foco.
   - En el móvil se lee bien sin hacer zoom.
   - Lighthouse → Accesibilidad ≥ 90.
6. Anota cualquier texto en "usted" (se corregirá en el S2) y cualquier error.

Devuelve la lista al PO o al SM. Con ella se cierran las condiciones de aceptación.

## Acciones
| Acción | Responsable | Fecha |
|---|---|---|
| Verificar la demo en un navegador real (condición B) | Usuario | antes del 30/11/2026 |
| Revisar, aprobar y fusionar el PR #1 (condición A); activar la protección de `main` (TEC-20) | Usuario / dueño del repositorio | antes del 30/11/2026 |
| Confirmar con la dirección el orden de prioridad de los roles | Product Owner | 30/11/2026 |
| Re-estimar HU-005 con la contraseña temporal; si supera 8 pts, sacar HU-029 | Developers + SM | Sprint Planning del S2 |
