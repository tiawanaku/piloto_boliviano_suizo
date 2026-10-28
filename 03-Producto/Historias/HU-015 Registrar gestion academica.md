---
tipo: historia
id: HU-015
epica: "[[EP-03 Estructura academica]]"
sprint: ""
puntos: 3
estado: backlog
orden: 15
tags: [historia, fase2]
---
# HU-015 · Registrar gestión académica

Épica: [[EP-03 Estructura academica]]

## Historia
> **Como** secretaria académica
> **quiero** crear la gestión escolar (año) con sus fechas y periodos de evaluación
> **para** que todo lo académico quede organizado por año.

## Criterios de aceptación
```gherkin
Escenario: Crear gestión
  Cuando registro "Gestión 2027" con fecha de inicio, fin y sus periodos (p. ej. 3 trimestres)
  Entonces queda en estado "planificada"

Escenario: Gestión activa única
  Cuando activo una gestión
  Entonces cualquier otra gestión activa pasa a "cerrada" previa confirmación
```

## Notas
Ver [[Modelo de dominio]].
