---
tipo: historia
id: HU-022
epica: "[[EP-05 Asignacion de cursos y materias]]"
sprint: ""
puntos: 3
estado: backlog
orden: 21
tags: [historia, fase3]
---
# HU-022 · Docente ve sus aulas asignadas

Épica: [[EP-05 Asignacion de cursos y materias]]

## Historia
> **Como** docente
> **quiero** ver al ingresar la lista de aulas y materias que tengo asignadas
> **para** ir directo a mi trabajo.

## Criterios de aceptación
```gherkin
Escenario: Mis aulas
  Dado que tengo asignaciones en la gestión activa
  Cuando inicio sesión
  Entonces mi panel muestra tarjetas aula + materia

Escenario: Sin asignaciones
  Entonces veo "Aún no tienes materias asignadas" y a quién consultar
```

## Notas
Completa el panel docente iniciado en [[HU-007 Panel segun rol]].
