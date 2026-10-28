---
tipo: historia
id: HU-021
epica: "[[EP-05 Asignacion de cursos y materias]]"
sprint: ""
puntos: 5
estado: backlog
prioridad: media
orden: 22
tags: [historia, fase3]
---
# HU-021 · Asignar docente a materia del aula

Épica: [[EP-05 Asignacion de cursos y materias]]

## Historia
> **Como** coordinadora pedagógica
> **quiero** asignar un docente titular a cada materia de cada aula
> **para** que cada docente tenga claros sus cursos y los estudiantes sepan quién les enseña.

## Criterios de aceptación
```gherkin
Escenario: Asignar titular
  Cuando asigno a "Docente X" como titular de Matemática en "1.º Secundaria A — 2027"
  Entonces la asignación queda registrada para esa gestión
  Y el docente la ve en su panel (HU-022)

Escenario: Docente no elegible
  Dado que una persona no tiene el rol Docente o su cuenta no está activa
  Entonces no aparece en la lista de docentes para asignar

Escenario: Reemplazar titular
  Dado que Matemática de 1.º A ya tiene titular
  Cuando asigno a otro docente como titular desde una fecha
  Entonces el anterior deja de ver esa materia desde esa fecha
  Y el cambio queda en el historial de la asignación

Escenario: Suplente
  Cuando asigno a "Docente Z" como suplente de Matemática en 1.º A
  Entonces ambos ven la materia y el suplente aparece marcado como tal

Escenario: Materias sin docente
  Cuando consulto el tablero de asignaciones de la gestión
  Entonces veo resaltadas las materias sin docente y su cantidad total

Escenario: Carga horaria
  Cuando una asignación hace que el docente supere la carga horaria semanal máxima definida por el colegio
  Entonces veo una advertencia, pero puedo guardar

Escenario: Gestión cerrada o sin permiso
  Cuando intento asignar en una gestión cerrada, o sin ser Coordinación pedagógica o Dirección
  Entonces la acción no está permitida
```

## Notas
- Toda asignación, reemplazo o retiro queda en auditoría.
- El tablero de "materias sin docente" sirve para medir la meta de la visión: 100 % de aulas con docentes al inicio de la gestión ([[Vision del producto]]).
- Si se desactiva la cuenta de un docente con asignaciones vigentes ([[HU-011 Desactivar cuenta]]), sus materias pasan a "sin docente".
