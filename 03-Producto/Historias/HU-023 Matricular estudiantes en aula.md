---
tipo: historia
id: HU-023
epica: "[[EP-05 Asignacion de cursos y materias]]"
sprint: ""
puntos: 5
estado: backlog
orden: 23
tags: [historia, fase3]
---
# HU-023 · Matricular estudiantes en aula

Épica: [[EP-05 Asignacion de cursos y materias]]

## Historia
> **Como** secretaria académica
> **quiero** matricular a cada estudiante en su aula virtual de la gestión
> **para** que tenga acceso a sus materias en la app.

## Criterios de aceptación
```gherkin
Escenario: Matricular
  Cuando registro a un estudiante (datos y tutor) y lo matriculo en 1.º Secundaria A
  Entonces queda vinculado al aula y sus materias
  Y se generan sus credenciales para la app (EP-06)

Escenario: Matrícula única
  Cuando intento matricularlo en una segunda aula de la misma gestión
  Entonces debo hacerlo como "cambio de paralelo" 
```

## Notas
Datos de menores: mínimo necesario ([[Seguridad y proteccion de datos]]).
