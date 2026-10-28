---
tipo: reunion
tipo_reunion: retro
fecha: 2026-11-27
sprint: "[[Sprint 1 - Login base]]"
tags: [reunion, retro]
---
# Retrospectiva · Sprint 1

Volver a [[Reuniones MOC]] · Sprint: [[Sprint 1 - Login base]] · Facilita: [[Scrum Master]] · Plantilla: [[Plantilla Retrospectiva]] · Anterior: [[2026-11-13 Retrospectiva - Sprint 0]]

**Participantes:** Developers (Dev 1, Dev 2, Dev 3), Scrum Master. El Product Owner fue invitado.
Dinámica usada: Start / Stop / Continue, más una evaluación del método de oleadas.

**Datos del sprint:**
- 17 pts terminados en código, pruebas y CI; la aceptación está pendiente de la verificación manual de experiencia.
- 23 tareas: 22 hechas y T-1-21 parcial.
- `pest` 397/397, `phpstan` 0 errores, `pint` OK, `composer audit` limpio; CI de GitHub en verde en cada *push* del PR #1.
- Dos *spikes* concluyentes: el MFA por rol es viable y el login **no** cumple 200 KB.
- Detalle en [[Sprint 1 - Login base#Cierre del sprint (27/11/2026)]].

## Seguimiento de acciones de la retro anterior
- [x] Quitar `notPath` de Pint y la prueba trivial el día 1 (T-1-22): hecho en la oleada 1.
- [x] Quitar el filtro `paths` y verificar el CI en GitHub (T-1-23): en verde en el PR #1. Desde entonces todo entra por PR con CI.
- [ ] Protección de `main` (TEC-20): **sigue bloqueada**. La API responde 403 a la integración y la tiene que activar el dueño del repositorio. Se escala otra vez.

## Evaluación del método de 3 oleadas con integración entre oleadas
| Aspecto | Qué pasó | Valoración |
|---|---|---|
| Conflictos de *merge* | Ninguno: dueño único por archivo, y las bases (`StaffPanel`, roles, `AuditLogger`, formato de Pint) quedaron en la oleada 1 | ✅ |
| Dependencias entre devs | Las tareas que esperaban a otro se movieron a la oleada siguiente, sin bloqueos dentro de una misma oleada: T-1-03 (estado de cuenta) esperó a la redirección de T-1-12, y T-1-14 (403 auditado) a `AuditLogger` | ✅ |
| Detección temprana de defectos | La integración entre oleadas hizo visible un defecto cruzado: Dev 1 descubrió que las etiquetas de auditoría con punto no se traducían (código de Dev 3), y se corrigió en la oleada 3 | ✅ |
| Ajustes de pruebas tras integrar | Al llegar los roles hubo que ajustar `PanelAccessTest` (las cuentas necesitan rol). Era previsible y se resolvió en la misma oleada | 🟡 |
| Tiempo de espera | Algunos devs quedaron con poco trabajo al final de una oleada mientras otro terminaba una base | 🟡 |
| Trazabilidad | Cada oleada fue un *commit* con CI verde y notas por tarea en la nota del sprint | ✅ |

**Conclusión:** el método **funciona y se mantiene**. Para el Sprint 2 se define de antemano qué entra en cada oleada (ver acción 2). Así, las bases que desbloquean a otros (T-2-01, T-2-07, T-2-12) van en la oleada 1, y el cambio transversal de mayor riesgo, activar el MFA, va solo después de preparar las pruebas (T-2-17).

## 🟢 Empezar a hacer
- **Verificación manual en navegador real en cada Sprint Review**, hecha por una persona (PO o usuario) con la lista de verificación del sprint: el entorno de los agentes no tiene navegador, y la DoD de experiencia (Chrome, Firefox, Android, 3G, contraste, Lighthouse) quedó sin demostrar.
- **Probar en una rama local los cambios transversales con la suite completa** antes de integrarlos (lección del *spike* de MFA: activarlo rompe 16 pruebas).
- **Llevar los hallazgos que afectan al producto al PO apenas aparecen** (RNF de 200 KB, tono, límite de intentos por IP), sin esperar al cierre.

## 🔴 Dejar de hacer
- Usar claves de traducción con punto para valores de enums (`login.succeeded`): `__()` las interpreta como anidación. La convención queda en `_`.
- Dar por buenas las traducciones de Filament sin revisar el tono: mezclaban "usted" y "tú".

## 🔵 Continuar haciendo
- *Spikes* con *timebox*, prototipo descartable y una propuesta concreta para el ADR: los dos del sprint permitieron decidir sin rehacer trabajo.
- Notas de decisión técnica por tarea en la nota del sprint (por ejemplo, `actor_id` sin clave foránea y el motivo).
- Pruebas con el nombre del escenario Gherkin y pruebas de rol sin acceso (403) en ambos paneles.
- CI verde en cada *push*.

## ¿La Definición de Terminado sigue siendo adecuada?
- Sí, y **no se relaja**. El hueco es de **ejecución**, no de definición: los ítems de experiencia necesitan un navegador real. Se resuelve con la verificación manual en la Review (acción 1). Mientras tanto, los 17 pts quedan **condicionados** a esa verificación.
- HU-001 incumple el RNF de peso del login: se informa al PO con una propuesta de nuevo presupuesto ([[Backlog tecnico#Propuestas al Product Owner]]). No se marca como cumplido.

## Acciones de mejora (máx. 3)
| Acción | Responsable | Se agrega al Sprint Backlog |
|---|---|---|
| Verificación manual en navegador (lista de T-1-21 y T-2-16) en la Sprint Review del S1 y de cada sprint, hecha por el PO o el usuario; si una historia falla, vuelve al backlog | Scrum Master (organiza) + PO | [x] Sprint 2 (T-2-16 prepara la lista) |
| Plan de oleadas del Sprint 2 fijado de antemano. Ver [[Sprint 2 - Seguridad del login#Plan de oleadas]]. Activar el MFA solo con T-2-17 integrada | Scrum Master | [x] Sprint 2 |
| Conseguir con el dueño del repositorio la protección de `main` (TEC-20) antes del inicio del Sprint 2 | Scrum Master | [x] Sprint 2 (impedimento) |
