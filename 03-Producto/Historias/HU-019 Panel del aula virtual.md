---
tipo: historia
id: HU-019
epica: "[[EP-04 Aulas virtuales]]"
sprint: ""
puntos: 8
estado: backlog
orden: 22
tags: [historia, fase2]
---
# HU-019 · Panel del aula virtual

Épica: [[EP-04 Aulas virtuales]]

## Historia
> **Como** docente
> **quiero** ver un panel de cada aula virtual con sus materias, estudiantes y anuncios
> **para** tener en un solo lugar lo necesario para mi clase.

## Criterios de aceptación
```gherkin
Escenario: Ver aula
  Dado que soy docente asignado al aula
  Cuando entro al aula
  Entonces veo materias, lista de estudiantes y anuncios

Escenario: Aula ajena
  Cuando intento entrar a un aula donde no tengo asignación
  Entonces se deniega el acceso
```

## Notas
Demasiado grande: dividir en el refinamiento.
