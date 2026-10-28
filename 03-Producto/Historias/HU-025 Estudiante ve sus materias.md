---
tipo: historia
id: HU-025
epica: "[[EP-06 App de estudiantes]]"
sprint: ""
puntos: 5
estado: backlog
prioridad: media
orden: 29
tags: [historia, fase4]
---
# HU-025 · Estudiante ve sus materias

Épica: [[EP-06 App de estudiantes]]

## Historia
> **Como** estudiante
> **quiero** ver mis materias y docentes
> **para** saber dónde y con quién tengo que trabajar.

## Criterios de aceptación
```gherkin
Escenario: Mis materias
  Dado que estoy matriculado en "1.º Secundaria A — 2027"
  Cuando abro la app
  Entonces veo el nombre de mi aula y mis materias, cada una con su docente

Escenario: Materia sin docente
  Dado que una de mis materias aún no tiene docente
  Entonces aparece como "Docente por asignar"

Escenario: Cambio de paralelo
  Dado que secretaría me cambió a 1.º B (HU-023)
  Cuando vuelvo a abrir la app
  Entonces veo las materias de mi nueva aula

Escenario: Solo lo mío
  Cuando intento ver materias o datos de otra aula
  Entonces se deniega el acceso
```

## Notas
- Pantalla liviana: ver [[Accesibilidad y conectividad]].
