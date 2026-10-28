---
tipo: reunion
tipo_reunion: planificacion-tecnica
fecha: 2026-10-28
sprint: "[[Sprint 0 - Preparacion]]"
tags: [reunion, sprint-planning, arquitectura, tecnico]
---
# 2026-10-28 · Sprint Planning técnico (Scrum Master)

Volver a [[Reuniones MOC]] · Backlog: [[Backlog del producto]] · Técnico: [[Backlog tecnico]] · Paquetes: [[Paquetes MOC]]

**Participantes:** Scrum Master (preparación previa al [[Sprint 0 - Preparacion]]). Se valida con los Developers y el PO en la [[Sprint Planning]] de cada sprint.
**Entradas:** [[2026-10-28 Revision del Product Owner]] (34 historias, Fase 1 = S1 17 · S2 19 · S3 18 pts) y las decisiones de la dirección del colegio comunicadas el mismo día.

> Esta es una **preparación**, no una Sprint Planning de Scrum: la Sprint Planning real la hace todo el equipo al inicio de cada sprint. Aquí se deja una propuesta de tareas y paquetes para que esa reunión sea corta.

## 1. Decisiones de stack
Registradas en [[ADR-005 Stack PHP Laravel y Filament]] (aceptada) y detalladas en [[Stack tecnologico]]:
- **PHP 8.3 + Laravel 13.39 + Filament 5.11** (Livewire 4, Alpine.js, Tailwind 4); código en `app-colegio/`, separado del vault.
- **PostgreSQL 16+** (auditoría inmutable con *trigger*, `jsonb`); SQLite en memoria para pruebas; CI contra ambos.
- Paneles **`admin`** y **`docente`** con sesión compartida, rol principal y cambio de panel (HU-007).
- Login de Filament personalizado, **MFA TOTP nativo de Filament solo para roles administrativos**, bloqueo propio (`AccountLockout`), sesiones en base de datos.
- **spatie/laravel-permission + Policies** (sin Filament Shield); **auditoría con tabla propia** `audit_events`.
- **Pest 4** (Pest 5 exige PHP 8.4), **Larastan nivel 6**, **Pint**, **GitHub Actions**; colas y caché `database`.
- App de estudiantes (Fase 4): decisión abierta; se recomienda un *spike* entre un panel Filament como PWA y una PWA Livewire liviana, con una API Sanctum como alternativa.

## 2. Decisiones de la dirección del colegio (2026-10-28) y su efecto técnico
| Decisión | Efecto técnico / en sprints |
|---|---|
| La plataforma arranca con la **Gestión 2027** | Riesgo de calendario (ver §5). Sin cambios en S0–S3. |
| Plantel **administrativo 1–15**, **docente 1–50** | Escala pequeña (≤ 65 cuentas): un servidor, colas y caché en base de datos bastan; sin optimizaciones especiales. Los datos de prueba y `DemoStaffSeeder` (T-3-17) usan esa escala. HU-012 (carga masiva) tiene poco valor con ≤ 65 personas: se lo señalo al PO como dato para su priorización. |
| **MFA de docentes fuera de la Fase 1** | Solo los roles administrativos tienen MFA obligatorio. No se planifica activación opcional para docentes (T-2-13 ajustada). El *spike* T-1-20 se limita a administrativos. ADR-005 actualizado. |
| **Aula virtual con sistema propio** (sin LMS) | Las Fases 2–4 se construyen como módulos del mismo proyecto Laravel/Filament. El contenido del aula necesitará un ADR propio (archivos, tamaños para 3G). |
| **Tutores con acceso propio** (épica futura) | No entra en S0–S3. El modelo lo permite: una sola tabla `users` con perfiles, roles de spatie y paneles separados → futuro rol `guardian` y panel/perfil `tutor`. Anotado como consecuencia en ADR-005. |
| RUDE obligatorio; credenciales de estudiantes sin definir; cupo por paralelo y carga horaria máxima por docente | Fases 2–4. Los valores serán **configurables** (`config/colegio.php` o una tabla de parámetros), no fijos en el código. |

## 3. Duración de los sprints (pendiente que dejó el PO)
- Se mantienen **sprints de 2 semanas** ([[Equipo Scrum del proyecto]]).
- **Sprint 0:** 02/11 – 13/11/2026. El 02/11 es feriado (Día de los Difuntos) → 9 días hábiles.
- **Sprint 1:** 16/11 – 27/11/2026 · **Sprint 2:** 30/11 – 11/12/2026 (sin feriados nacionales).
- **Sprint 3: 14/12 – 24/12/2026.** El 25/12 es feriado: la Review y la Retrospectiva se adelantan al jueves 24/12 por la mañana. Capacidad ~25,5 días (−12 %).
- **Pausa de fin de año: 28/12/2026 – 01/01/2027** (sin sprint). La **Fase 2 empieza el 04/01/2027** (Sprint 4).
- Actualizados: [[Sprints MOC]], [[Fases y roadmap]] y [[Sprint 3 - Gestion de personal]].

## 4. Capacidad y trabajo planificado
| Sprint | Capacidad (días) | Historias (pts) | TEC | Tareas | Paquetes |
|---|---|---|---|---|---|
| [[Sprint 0 - Preparacion\|S0]] | 27 (incluye talleres) | — | TEC-01…09 | 13 | [[Sprint 0 - Dev 1\|Dev 1]] · [[Sprint 0 - Dev 2\|Dev 2]] · [[Sprint 0 - Dev 3\|Dev 3]] |
| [[Sprint 1 - Login base\|S1]] | 29 | 17 | TEC-10…15 | 21 | [[Sprint 1 - Dev 1\|Dev 1]] · [[Sprint 1 - Dev 2\|Dev 2]] · [[Sprint 1 - Dev 3\|Dev 3]] |
| [[Sprint 2 - Seguridad del login\|S2]] | 30 | 19 | TEC-16 | 16 | [[Sprint 2 - Dev 1\|Dev 1]] · [[Sprint 2 - Dev 2\|Dev 2]] · [[Sprint 2 - Dev 3\|Dev 3]] |
| [[Sprint 3 - Gestion de personal\|S3]] | 25,5 | 18 | TEC-17 | 17 | [[Sprint 3 - Dev 1\|Dev 1]] · [[Sprint 3 - Dev 2\|Dev 2]] · [[Sprint 3 - Dev 3\|Dev 3]] |

- **17 elementos TEC** y **67 tareas** de ≤ 1 día.
- Los paquetes se diseñaron con **un único dueño por archivo y sprint**. En cada sprint hay una tarea "primero" que desbloquea a los demás (T-0-01, T-1-01, T-2-01, T-3-01) y una o dos "tempranas" (T-1-08, T-1-15, T-2-07).
- La [[Definicion de Terminado]] ahora incluye los comandos del stack (Pint, Larastan, Pest, cobertura, `composer audit`) y el CI en verde. No se relajó ningún criterio.

## 5. Riesgos técnicos
| Riesgo | Prob. | Impacto | Mitigación |
|---|---|---|---|
| **Calendario Gestión 2027:** con el roadmap actual, la Fase 2 ocupa enero de 2027 y la Fase 3 llega hacia fines de febrero, después del inicio habitual de clases. La app de estudiantes (Fase 4) llega hacia mayo | Alta | Alto | **Propuesta al PO:** definir qué mínimo de Fases 2–3 se necesita para el inicio de clases (p. ej. estructura, aulas y asignación docente, dejando la ficha del aula para después) y si los estudiantes empiezan sin app. El orden del backlog lo decide el PO. |
| Sin servidor de staging, dominio o SMTP institucional al inicio del S0 | Media | Alto | T-0-11 y T-0-13 empiezan el día 1; si faltan, se registran como impedimento y se escala a dirección. |
| Personalizar el login y el MFA de Filament 5 es más difícil de lo previsto | Media | Medio | *Spikes* T-1-19 y T-1-20 en el S1; *pairing*; HU-029 es la primera en salir del S2 (decisión del PO). |
| Peso de Filament/Livewire en 3G (> 200 KB en el login) | Media | Medio | *Spike* T-1-19; compresión y caché en Nginx. |
| Sprint 3 con capacidad reducida (18 pts con −12 % de días) | Media | Medio | Si la velocidad real de S1–S2 no alcanza, sale HU-014 (decisión del PO); el paquete de Dev 3 se ordenó para que TEC-17 y la regresión se hagan igual. |
| Conflictos de *merge* en archivos compartidos (`User.php`, *providers*) | Media | Bajo | Dueño único por archivo y sprint, *traits*, PR pequeños. |
| La matriz RBAC cambia en el taller del 03/11 | Media | Bajo | El *seeder* (T-1-09) se escribe después del taller; los permisos son datos. |
| PHP 8.3 limita versiones (Pest 5, spatie/activitylog 5) | Baja | Bajo | Revisar el paso a PHP 8.4 en la retrospectiva de la Fase 1. |

## 6. Propuestas al Product Owner (no aplicadas)
1. HU-008: mostrar IP y navegador, sin "ubicación aproximada", en su primera versión.
2. Con un plantel de ≤ 65 personas, revisar el valor de HU-012 (carga masiva) frente a las Fases 2–3 para llegar a la Gestión 2027.
3. Definir el mínimo de las Fases 2–3 para el inicio de clases de 2027 (ver riesgo de calendario).

## Acciones
| Acción | Responsable | Fecha |
|---|---|---|
| Validar tareas y paquetes con los Developers | Scrum Master | Sprint Planning del S0 (03/11/2026) |
| Gestionar el servidor de staging, el dominio y el SMTP institucional | Scrum Master + TI del colegio | 02–04/11/2026 |
| Responder las propuestas 1–3 | Product Owner | Refinamiento del S0 |
| Actualizar ADR-005 con los resultados de los *spikes* | Dev 3 + Scrum Master | Fin del S1 |
