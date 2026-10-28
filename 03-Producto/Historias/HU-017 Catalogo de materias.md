---
tipo: historia
id: HU-017
epica: "[[EP-03 Estructura academica]]"
sprint: ""
puntos: 3
estado: backlog
orden: 17
tags: [historia, fase2]
---
# HU-017 · Catálogo de materias

Épica: [[EP-03 Estructura academica]]

## Historia
> **Como** coordinación académica
> **quiero** mantener el catálogo de materias/áreas por nivel
> **para** asignarlas luego a las aulas virtuales.

## Criterios de aceptación
```gherkin
Escenario: Registrar materia
  Cuando registro "Matemática" con código, nivel(es) y carga horaria semanal
  Entonces aparece en el catálogo

Escenario: Materia en uso
  Dado que una materia ya está asignada a un aula
  Cuando intento eliminarla
  Entonces solo puedo desactivarla
```
