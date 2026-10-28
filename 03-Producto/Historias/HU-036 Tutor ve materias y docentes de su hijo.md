---
tipo: historia
id: HU-036
epica: "[[EP-09 Acceso de tutores]]"
sprint: ""
puntos: 3
estado: backlog
prioridad: media
orden: 32
tags: [historia, fase4, tutores]
---
# HU-036 · El tutor ve las materias y docentes de su hijo

Épica: [[EP-09 Acceso de tutores]]

## Historia
> **Como** tutor con cuenta activa
> **quiero** ver el aula, las materias y los docentes de cada hijo que tengo a cargo
> **para** acompañar su estudio y saber a quién dirigirme.

## Criterios de aceptación (alto nivel)
```gherkin
Escenario: Varios hijos
  Dado que tengo a cargo dos estudiantes matriculados
  Cuando ingreso
  Entonces elijo a cuál ver y veo su aula, sus materias y sus docentes

Escenario: Solo mis hijos
  Cuando intento ver datos de un estudiante que no tengo a cargo
  Entonces se deniega el acceso y el intento queda registrado

Escenario: Matrícula no vigente
  Dado que mi hijo fue retirado
  Entonces veo que su matrícula no está vigente y a quién consultar
```
