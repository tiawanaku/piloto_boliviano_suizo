---
tipo: historia
id: HU-020
epica: "[[EP-05 Asignacion de cursos y materias]]"
sprint: ""
puntos: 3
estado: backlog
orden: 19
tags: [historia, fase3]
---
# HU-020 · Asignar materias a un aula virtual

Épica: [[EP-05 Asignacion de cursos y materias]]

## Historia
> **Como** coordinación académica
> **quiero** asignar a cada aula virtual las materias de su plan de estudios
> **para** que el aula refleje la malla curricular del grado.

## Criterios de aceptación
```gherkin
Escenario: Asignación por plan
  Cuando aplico la malla de "1.º Secundaria" a las aulas de ese grado
  Entonces cada aula recibe las materias correspondientes

Escenario: Ajuste individual
  Cuando agrego o quito una materia de un aula específica
  Entonces el cambio afecta solo a esa aula
```
