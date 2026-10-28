---
tipo: historia
id: HU-018
epica: "[[EP-04 Aulas virtuales]]"
sprint: ""
puntos: 5
estado: backlog
orden: 18
tags: [historia, fase2]
---
# HU-018 · Crear aulas virtuales por paralelo

Épica: [[EP-04 Aulas virtuales]]

## Historia
> **Como** coordinación académica
> **quiero** generar automáticamente un aula virtual por cada paralelo de la gestión
> **para** que cada curso tenga su espacio virtual sin crearlo a mano.

## Criterios de aceptación
```gherkin
Escenario: Generación
  Dado que la estructura de la gestión está configurada
  Cuando ejecuto "Generar aulas virtuales"
  Entonces se crea un aula por paralelo con nombre "1.º Secundaria A — 2027"
  Y las aulas ya existentes no se duplican
```

## Notas
Pregunta abierta: ¿LMS propio o integrado? Ver [[EP-04 Aulas virtuales]].
