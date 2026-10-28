---
tipo: epica
id: EP-06
tags: [epica, fase4, app, estudiantes]
estado: backlog
fase: 4
prioridad: media
---
# EP-06 · Aplicativo de acceso para estudiantes

Volver a [[Backlog del producto]]

## Descripción
Aplicativo **separado** del portal del personal ([[ADR-003 Separar acceso de personal y estudiantes]]), optimizado para celulares y conexiones lentas, desde el que cada estudiante accede a su aula virtual y materias.

## Historias
| ID | Historia | Pts | Estado |
|---|---|---|---|
| [[HU-034 Credenciales del estudiante para el tutor]] | Credenciales entregadas al tutor | 5 | backlog |
| [[HU-024 Login de estudiante en la app]] | Login en la app | 8 | backlog |
| [[HU-025 Estudiante ve sus materias]] | Mis materias | 5 | backlog |
| [[HU-026 Modo bajo consumo de datos]] | Ahorro de datos | 8 | idea |
| **Total** | | **26** | |

## Consideraciones
- Estudiantes menores de edad: credenciales entregadas por el colegio a la familia; sin correo personal obligatorio. Formato y entrega **aún no definidos** (pendiente para la Fase 4).
- Los tutores tendrán acceso propio: [[EP-09 Acceso de tutores]].
- Recuperación de acceso a través del tutor o de secretaría ([[HU-034 Credenciales del estudiante para el tutor]]).
- Formato: PWA o app nativa Android → candidato a ADR.
- Ver [[Accesibilidad y conectividad]].
