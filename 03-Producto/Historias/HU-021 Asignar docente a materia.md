---
tipo: historia
id: HU-021
epica: "[[EP-05 Asignacion de cursos y materias]]"
sprint: ""
puntos: 5
estado: backlog
orden: 20
tags: [historia, fase3]
---
# HU-021 · Asignar docente a materia del aula

Épica: [[EP-05 Asignacion de cursos y materias]]

## Historia
> **Como** coordinación académica
> **quiero** asignar un docente titular a cada materia de cada aula
> **para** que cada docente tenga claros sus cursos y los estudiantes sepan quién les enseña.

## Criterios de aceptación
```gherkin
Escenario: Asignar
  Cuando asigno a "Docente X" a Matemática de 1.º Secundaria A
  Entonces la asignación queda registrada para la gestión activa
  Y el docente la ve en su panel (HU-022)

Escenario: Materias sin docente
  Cuando consulto el tablero de asignaciones
  Entonces veo resaltadas las materias sin docente

Escenario: Carga horaria
  Cuando una asignación supera la carga horaria máxima del docente
  Entonces veo una advertencia (no bloquea)
```

## Notas
Solo docentes con cuenta activa y rol Docente.
