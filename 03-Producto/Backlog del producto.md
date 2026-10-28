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

| # | ID | Historia | Épica | Pts | Estado | Sprint |
|---|---|---|---|---|---|---|
| 1 | [[HU-001 Iniciar sesion con correo institucional\|HU-001]] | Iniciar sesión con correo institucional | EP-01 | 5 | lista | [[Sprint 1 - Login base\|S1]] |
| 2 | [[HU-007 Panel segun rol\|HU-007]] | Redirección al panel según rol | EP-01 | 5 | lista | S1 |
| 3 | [[HU-002 Cerrar sesion\|HU-002]] | Cerrar sesión | EP-01 | 1 | lista | S1 |
| 4 | [[HU-006 Cambio de contrasena en primer ingreso\|HU-006]] | Cambio de contraseña en primer ingreso | EP-01 | 3 | lista | S1 |
| 5 | [[HU-013 Registro de auditoria de accesos\|HU-013]] | Registro de auditoría de accesos | EP-08 | 3 | lista | S1 |
| 6 | [[HU-003 Recuperar contrasena\|HU-003]] | Recuperar contraseña | EP-01 | 5 | refinada | [[Sprint 2 - Seguridad del login\|S2]] |
| 7 | [[HU-004 Bloqueo por intentos fallidos\|HU-004]] | Bloqueo por intentos fallidos | EP-01 | 3 | refinada | S2 |
| 8 | [[HU-005 MFA para personal administrativo\|HU-005]] | MFA para personal administrativo | EP-01 | 8 | refinada | S2 |
| 9 | [[HU-008 Gestion de sesiones activas\|HU-008]] | Gestión de sesiones activas | EP-01 | 5 | refinada | S2 |
| 10 | [[HU-009 Invitar personal\|HU-009]] | Invitar a un miembro del personal | EP-02 | 5 | refinada | [[Sprint 3 - Gestion de personal\|S3]] |
| 11 | [[HU-010 Asignar roles al personal\|HU-010]] | Asignar roles al personal | EP-02 | 3 | refinada | S3 |
| 12 | [[HU-011 Desactivar cuenta\|HU-011]] | Desactivar cuenta | EP-02 | 2 | refinada | S3 |
| 13 | [[HU-014 Consultar bitacora de auditoria\|HU-014]] | Consultar bitácora de auditoría | EP-08 | 5 | refinada | S3 |
| 14 | [[HU-012 Carga masiva de personal\|HU-012]] | Carga masiva de personal (CSV) | EP-02 | 8 | backlog | — |
| 15 | [[HU-015 Registrar gestion academica\|HU-015]] | Registrar gestión académica | EP-03 | 3 | backlog | — |
| 16 | [[HU-016 Configurar niveles grados y paralelos\|HU-016]] | Configurar niveles, grados y paralelos | EP-03 | 5 | backlog | — |
| 17 | [[HU-017 Catalogo de materias\|HU-017]] | Catálogo de materias | EP-03 | 3 | backlog | — |
| 18 | [[HU-018 Crear aulas virtuales por paralelo\|HU-018]] | Crear aulas virtuales por paralelo | EP-04 | 5 | backlog | — |
| 19 | [[HU-020 Asignar materias al aula\|HU-020]] | Asignar materias a un aula virtual | EP-05 | 3 | backlog | — |
| 20 | [[HU-021 Asignar docente a materia\|HU-021]] | Asignar docente a materia del aula | EP-05 | 5 | backlog | — |
| 21 | [[HU-022 Docente ve sus aulas asignadas\|HU-022]] | Docente ve sus aulas asignadas | EP-05 | 3 | backlog | — |
| 22 | [[HU-019 Panel del aula virtual\|HU-019]] | Panel del aula virtual | EP-04 | 8 | backlog | — |
| 23 | [[HU-023 Matricular estudiantes en aula\|HU-023]] | Matricular estudiantes en aula | EP-05 | 5 | backlog | — |
| 24 | [[HU-024 Login de estudiante en la app\|HU-024]] | Login de estudiante en la app | EP-06 | 8 | backlog | — |
| 25 | [[HU-025 Estudiante ve sus materias\|HU-025]] | Estudiante ve sus materias | EP-06 | 5 | backlog | — |
| 26 | [[HU-026 Modo bajo consumo de datos\|HU-026]] | Modo bajo consumo de datos | EP-06 | 8 | idea | — |
| 27 | [[HU-027 Consulta rapida para oficina de informacion\|HU-027]] | Consulta rápida para oficina de información | EP-07 | 5 | idea | — |
| 28 | [[HU-028 Registro de atenciones\|HU-028]] | Registro de atenciones en oficina | EP-07 | 3 | idea | — |

## Épicas
- [[EP-01 Login plantel administrativo y docentes]] — Fase 1
- [[EP-02 Gestion de usuarios y roles]] — Fase 1
- [[EP-08 Seguridad y auditoria]] — transversal
- [[EP-03 Estructura academica]] — Fase 2
- [[EP-04 Aulas virtuales]] — Fase 2
- [[EP-05 Asignacion de cursos y materias]] — Fase 3
- [[EP-06 App de estudiantes]] — Fase 4
- [[EP-07 Oficina de informacion]] — Fase 5

## 💡 Ideas sin refinar (parking lot)
- Acceso de consulta para padres/tutores.
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
