---
tipo: moc
tags: [moc, sprint, paquete]
aliases: [Paquetes de trabajo]
---
# 📦 Paquetes de trabajo

Volver a [[Sprints MOC]] · Habilitadores: [[Backlog tecnico]] · Stack: [[ADR-005 Stack PHP Laravel y Filament]] · Planificación: [[2026-10-28 Sprint Planning tecnico - Scrum Master]]

> 🧪 Alcance piloto: sin staging, despliegue ni respaldos; SQLite, correo `log`/Mailpit y datos ficticios con `php artisan colegio:demo`.

Un paquete por developer y sprint, para los agentes `php-senior-developer`. Cada paquete lista sus tareas `T-<sprint>-<nn>` en orden, los **archivos de los que es dueño** (nadie más los toca ese sprint), lo que debe esperar de otros paquetes, los comandos de verificación y su definición de terminado. El detalle de cada tarea está en la sección "Tareas técnicas" de la nota del sprint.

## Reglas comunes
- **Un dueño por archivo y sprint.** `composer.json`/`composer.lock`, `User.php`, los *PanelProviders*, `StaffPanel.php`, `Login.php` y `UserPolicy.php` tienen un único dueño por sprint (indicado en cada paquete). Los demás aportan *traits* o clases nuevas y el dueño las integra.
- Migraciones nuevas en archivos propios con la fecha del sprint; nunca se edita una migración ya integrada en `main`.
- Las tareas marcadas ⚠️ **primero/temprano** desbloquean a otros: se integran antes que el resto.
- Integración frecuente (PR pequeños, al menos uno por tarea) para reducir conflictos.

## Sprint 0 · Preparación (02/11 – 13/11/2026) — ✅ terminado (T-0-07 parcial; ver [[Sprint 0 - Preparacion#Cierre del sprint (13/11/2026)]])
| Paquete | Foco | Orden / dependencias |
|---|---|---|
| [[Sprint 0 - Dev 1]] | Proyecto, identidad base, paneles | **Va primero:** T-0-01 bloquea a todos |
| [[Sprint 0 - Dev 2]] | Pest, Larastan, Pint, CI | Tras T-0-01; T-0-08 espera paneles de Dev 1 |
| [[Sprint 0 - Dev 3]] | Idioma, entorno local (SQLite), correo `log`, colas, `colegio:demo` | Tras T-0-01; T-0-11 espera los paneles de Dev 1 (T-0-03) |

## Sprint 1 · Login base (16/11 – 27/11/2026) — ✅ terminado (17 pts condicionados a la verificación manual de experiencia; ver [[Sprint 1 - Login base#Cierre del sprint (27/11/2026)]])
| Paquete | Foco | Orden / dependencias |
|---|---|---|
| [[Sprint 1 - Dev 1]] | HU-001, HU-002, HU-006, TEC-13 | **T-1-01 primero** (día 1); T-1-03 espera la redirección de Dev 2 |
| [[Sprint 1 - Dev 2]] | Deuda del S0 (TEC-18, TEC-19), TEC-10, TEC-11, HU-007 | **T-1-22 primero** (día 1, formato del esqueleto); T-1-08 temprano; *PanelProviders* tras T-1-01; T-1-14 espera `AuditLogger` de Dev 3 |
| [[Sprint 1 - Dev 3]] | TEC-12, HU-013, *spikes* TEC-14/TEC-15 | **T-1-15 temprano** (lo usa Dev 2); *spikes* tras login y roles |

## Sprint 2 · Seguridad del login (30/11 – 11/12/2026) — 🔄 ajustado el 27/11 por los *spikes* del S1
| Paquete | Foco | Orden / dependencias |
|---|---|---|
| [[Sprint 2 - Dev 1]] | HU-003, HU-029, tono "tú" (DEF-01) | Espera T-2-01 de Dev 3 y `AccountLockout` de Dev 2 |
| [[Sprint 2 - Dev 2]] | HU-004 + *throttle* (DEF-02), "Restablecer MFA", *helpers* de MFA (TEC-22), datos de demostración (TEC-16) | **T-2-07 temprano**; **T-2-17 antes de que Dev 3 active el MFA**; T-2-15, T-2-17 y T-2-11 esperan T-2-12 |
| [[Sprint 2 - Dev 3]] | HU-005 (solo administrativos), fuentes del sistema (TEC-21), tipos de auditoría | **T-2-01 primero** (día 1, sin MFA); T-2-12 el día 2; T-2-13 espera T-2-17 de Dev 2 |

## Sprint 3 · Gestión de personal (14/12 – 24/12/2026)
| Paquete | Foco | Orden / dependencias |
|---|---|---|
| [[Sprint 3 - Dev 1]] | HU-030, HU-010 (dueño de `UserResource`) | **T-3-01 primero** (día 1, desbloquea a Dev 2); T-3-07 integra acciones de Dev 2 al final |
| [[Sprint 3 - Dev 2]] | HU-009, HU-011 | Tras T-3-01; T-3-09 espera `UserForm` de Dev 1 |
| [[Sprint 3 - Dev 3]] | HU-014, datos de demostración (TEC-16), regresión | HU-014 desde el día 1; T-3-13 tras T-3-01 de Dev 1 |
