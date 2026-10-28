---
tipo: backlog
tags: [producto, backlog]
aliases: [Product Backlog del proyecto, Backlog]
---
# 📋 Backlog del producto — Colegio Virtual

Volver a [[Inicio]] · Concepto: [[Product Backlog]] · Dueño: [[Product Owner]]

**Objetivo del producto:** que cada miembro del colegio acceda de forma segura a su espacio virtual y encuentre allí, organizado, todo lo que necesita. → [[Vision del producto]]

> El **orden** de esta lista es la prioridad. Lo de arriba está refinado; lo de abajo es más grueso (ver iceberg en [[Product Backlog]]).

## Orden actual

> Revisado por el PO el 2026-10-28 ([[2026-10-28 Revision del Product Owner]]) y reordenado tras las [[2026-10-28 Decisiones de la direccion]]. 🆕 = historia nueva. Las estimaciones de las historias nuevas son provisionales hasta el refinamiento con los Developers.

| # | ID | Historia | Épica | Pts | Estado | Sprint / meta |
|---|---|---|---|---|---|---|
| | | **Fase 1 · Sprint 1 — Login base (17 pts, aceptado con condición)** | | | | |
| 1 | [[HU-001 Iniciar sesion con correo institucional\|HU-001]] | Iniciar sesión con correo institucional | EP-01 | 5 | aceptada-condicional | [[Sprint 1 - Login base\|S1]] |
| 2 | [[HU-007 Panel segun rol\|HU-007]] | Redirección al panel según rol | EP-01 | 5 | aceptada-condicional | S1 |
| 3 | [[HU-002 Cerrar sesion\|HU-002]] | Cerrar sesión | EP-01 | 1 | aceptada-condicional | S1 |
| 4 | [[HU-006 Cambio de contrasena en primer ingreso\|HU-006]] | Cambio de contraseña en primer ingreso | EP-01 | 3 | aceptada-condicional | S1 |
| 5 | [[HU-013 Registro de auditoria de accesos\|HU-013]] | Registro de auditoría de accesos | EP-08 | 3 | aceptada-condicional | S1 |
| | | **Fase 1 · Sprint 2 — Seguridad del login (19 pts)** | | | | |
| 6 | [[HU-003 Recuperar contrasena\|HU-003]] | Recuperar contraseña | EP-01 | 5 | refinada | [[Sprint 2 - Seguridad del login\|S2]] |
| 7 | [[HU-004 Bloqueo por intentos fallidos\|HU-004]] | Bloqueo por intentos fallidos | EP-01 | 3 | refinada | S2 |
| 8 | [[HU-005 MFA para personal administrativo\|HU-005]] | MFA para personal administrativo | EP-01 | 8 | refinada | S2 |
| 9 | [[HU-029 Mi cuenta datos y cambio de contrasena\|HU-029]] | Mi cuenta: ver mis datos y cambiar mi contraseña | EP-01 | 3 | refinada | S2 |
| | | **Fase 1 · Sprint 3 — Gestión de personal (18 pts)** | | | | |
| 10 | [[HU-009 Invitar personal\|HU-009]] | Invitar a un miembro del personal | EP-02 | 5 | refinada | [[Sprint 3 - Gestion de personal\|S3]] |
| 11 | [[HU-030 Listado y ficha del personal\|HU-030]] | Listado y ficha del personal | EP-02 | 3 | refinada | S3 |
| 12 | [[HU-010 Asignar roles al personal\|HU-010]] | Asignar roles al personal | EP-02 | 3 | refinada | S3 |
| 13 | [[HU-011 Desactivar cuenta\|HU-011]] | Desactivar cuenta | EP-02 | 2 | refinada | S3 |
| 14 | [[HU-014 Consultar bitacora de auditoria\|HU-014]] | Consultar bitácora de auditoría | EP-08 | 5 | refinada | S3 |
| | | **🎯 MVP del piloto (escenario: inicio de clases 2027) — Fases 2–3 (39 pts)** | | | | |
| 15 | [[HU-015 Registrar gestion academica\|HU-015]] | Registrar gestión académica | EP-03 | 3 | backlog | MVP |
| 16 | [[HU-016 Configurar niveles grados y paralelos\|HU-016]] | Configurar niveles, grados y paralelos (con cupo) | EP-03 | 5 | backlog | MVP |
| 17 | [[HU-017 Catalogo de materias\|HU-017]] | Catálogo de materias | EP-03 | 3 | backlog | MVP |
| 18 | [[HU-018 Crear aulas virtuales por paralelo\|HU-018]] | Crear aulas virtuales por paralelo | EP-04 | 5 | backlog | MVP |
| 19 | [[HU-020 Asignar materias al aula\|HU-020]] | Asignar materias a las aulas (por grado y por aula) | EP-05 | 3 | backlog | MVP |
| 20 | [[HU-021 Asignar docente a materia\|HU-021]] | Asignar docente a materia (con carga horaria máxima) | EP-05 | 5 | backlog | MVP |
| 21 | [[HU-022 Docente ve sus aulas asignadas\|HU-022]] | Docente ve sus aulas asignadas | EP-05 | 3 | backlog | MVP |
| 22 | [[HU-033 Registrar estudiante y tutor\|HU-033]] | Registrar estudiante (RUDE) y su tutor | EP-05 | 5 | backlog | MVP |
| 23 | [[HU-023 Matricular estudiantes en aula\|HU-023]] | Matricular estudiantes en aula (con cupo) | EP-05 | 5 | backlog | MVP |
| 24 | [[HU-031 Lista de estudiantes del aula\|HU-031]] | Lista de estudiantes del aula | EP-04 | 2 | backlog | MVP |
| | | **Después del MVP: completar Fases 1–3** | | | | |
| 25 | [[HU-019 Panel del aula virtual\|HU-019]] | Panel del aula virtual: materias y docentes | EP-04 | 3 | backlog | — |
| 26 | [[HU-008 Gestion de sesiones activas\|HU-008]] | Gestión de sesiones activas | EP-01 | 5 | refinada | — |
| | | **Fase 4 · App de estudiantes y aula** | | | | |
| 27 | [[HU-034 Credenciales del estudiante para el tutor\|HU-034]] | Credenciales del estudiante para su tutor | EP-06 | 5 | backlog | — |
| 28 | [[HU-024 Login de estudiante en la app\|HU-024]] | Login de estudiante en la app | EP-06 | 8 | backlog | — |
| 29 | [[HU-025 Estudiante ve sus materias\|HU-025]] | Estudiante ve sus materias | EP-06 | 5 | backlog | — |
| 30 | [[HU-032 Anuncios del aula\|HU-032]] | Anuncios del aula | EP-04 | 5 | backlog | — |
| | | **Fase 4 · Acceso de tutores (EP-09)** | | | | |
| 31 | [[HU-035 Activar cuenta del tutor\|HU-035]] | Activar la cuenta del tutor 🆕 | EP-09 | 5 | backlog | — |
| 32 | [[HU-036 Tutor ve materias y docentes de su hijo\|HU-036]] | El tutor ve materias y docentes de su hijo 🆕 | EP-09 | 3 | backlog | — |
| 33 | [[HU-037 Tutor solicita restablecer acceso del estudiante\|HU-037]] | El tutor pide un nuevo acceso para el estudiante 🆕 | EP-09 | 3 | backlog | — |
| 34 | [[HU-038 Consentimiento en linea del tutor\|HU-038]] | Consentimiento en línea del tutor 🆕 | EP-09 | 5 | idea | — |
| | | **Prioridad baja e ideas** | | | | |
| 35 | [[HU-012 Carga masiva de personal\|HU-012]] | Carga masiva de personal (CSV) | EP-02 | 8 | backlog | — |
| 36 | [[HU-026 Modo bajo consumo de datos\|HU-026]] | Modo bajo consumo de datos | EP-06 | 8 | idea | — |
| 37 | [[HU-027 Consulta rapida para oficina de informacion\|HU-027]] | Consulta rápida para oficina de información | EP-07 | 5 | idea | — |
| 38 | [[HU-028 Registro de atenciones\|HU-028]] | Registro de atenciones en oficina | EP-07 | 3 | idea | — |

**Total del backlog:** 38 historias · 164 pts. Fase 1 en sprints (S1–S3): 54 pts. MVP del piloto: 39 pts (Sprints 4–5 previstos, desde el 04/01/2027; fechas referenciales).

### MVP del piloto (escenario simulado: inicio de clases de la Gestión 2027)
🧪 Es el **mínimo para demostrar el piloto** con datos ficticios, no una fecha de salida real. Lo imprescindible para simular el primer día de clases: el colegio tiene la gestión, la estructura, las aulas, las materias y los docentes asignados; los estudiantes están registrados con su tutor y matriculados; y cada docente ve sus aulas y sus estudiantes. La ficha del aula (HU-019), las sesiones activas (HU-008) y todo el acceso de estudiantes y tutores (Fase 4) quedan **después** del MVP. Ver [[2026-10-28 Decisiones de la direccion]].

> El orden sigue valor y dependencias, no la numeración de épicas.

## Trabajo técnico
- [[Backlog tecnico]] — habilitadores técnicos (`TEC-nn`) que el Scrum Master planifica junto a las historias que los necesitan, sin cambiar este orden.

## Épicas
- [[EP-01 Login plantel administrativo y docentes]] — Fase 1
- [[EP-02 Gestion de usuarios y roles]] — Fase 1
- [[EP-08 Seguridad y auditoria]] — transversal
- [[EP-03 Estructura academica]] — Fase 2
- [[EP-04 Aulas virtuales]] — Fase 2
- [[EP-05 Asignacion de cursos y materias]] — Fase 3
- [[EP-06 App de estudiantes]] — Fase 4
- [[EP-09 Acceso de tutores]] — Fase 4
- [[EP-07 Oficina de informacion]] — Fase 5

## 💡 Ideas sin refinar (parking lot)
- Carga masiva de estudiantes, tutores y matrículas (CSV) para el inicio de gestión — priorizar cuando se conozca el número de estudiantes.
- MFA para docentes (pendiente de la dirección, fuera de la Fase 1).
- Tablero de preparación del inicio de gestión (aulas sin materias, materias sin docente, aulas sin estudiantes).
- Resumen de indicadores para Dirección en su panel.
- Integración con videollamadas para clases sincrónicas.
- Calificaciones y boletines digitales.
- Notificaciones push en la app de estudiantes.
- Inicio de sesión único (SSO) con proveedor de correo institucional.
- Uso de Scrum por estudiantes en proyectos ([[Scrum en proyectos educativos]]).

## Vista automática (requiere plugin Dataview)
```dataview
TABLE epica AS "Épica", puntos AS "Pts", estado AS "Estado", sprint AS "Sprint"
FROM "03-Producto/Historias"
SORT orden ASC
```
