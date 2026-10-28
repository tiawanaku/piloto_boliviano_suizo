---
tipo: epica
id: EP-05
tags: [epica, fase3, asignaciones]
estado: backlog
fase: 3
prioridad: media
---
# EP-05 · Asignación de cursos y materias a las aulas virtuales

Volver a [[Backlog del producto]]

## Descripción
Coordinación académica asigna a cada aula virtual sus **materias** y a cada materia su **docente**; secretaría matricula a los **estudiantes** en su aula. Al ingresar, cada docente ve solo sus aulas y materias.

```mermaid
flowchart LR
    A[Aula virtual 1.º Sec. A] --> M1[Matemática]
    A --> M2[Lenguaje]
    M1 --> D1((Docente X))
    M2 --> D2((Docente Y))
    A --> E[[Estudiantes matriculados]]
```

## Historias
| ID | Historia | Pts |
|---|---|---|
| [[HU-020 Asignar materias al aula]] | Materias por grado y aula | 3 |
| [[HU-021 Asignar docente a materia]] | Docente titular / suplente por materia | 5 |
| [[HU-022 Docente ve sus aulas asignadas]] | Mis aulas (docente) | 3 |
| [[HU-033 Registrar estudiante y tutor]] | Estudiante + tutor + consentimiento | 5 |
| [[HU-023 Matricular estudiantes en aula]] | Matrícula, cambio de paralelo, retiro | 5 |
| **Total** | | **21** |

## Reglas de negocio
- Un docente puede tener varias materias en varias aulas.
- Una materia de un aula tiene un docente titular (y opcionalmente un suplente).
- Un estudiante está matriculado en una sola aula por gestión.
- Las asignaciones pertenecen a una gestión; al cerrar la gestión quedan como histórico.
- Todo estudiante tiene **RUDE** y al menos un tutor registrado con consentimiento antes de matricularse.
- Cada paralelo tiene un **cupo** configurable y cada docente una **carga horaria semanal máxima** configurable; ambos se aplican.
- HU-020, HU-021, HU-022, HU-033, HU-023 forman parte del **MVP del piloto** ([[Backlog del producto]]).
- Las credenciales de la app se generan en [[HU-034 Credenciales del estudiante para el tutor]] (EP-06).

## Relacionado
[[Modelo de dominio]] · [[Roles y permisos RBAC]]
