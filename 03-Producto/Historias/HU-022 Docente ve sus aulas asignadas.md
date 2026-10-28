---
tipo: historia
id: HU-022
epica: "[[EP-05 Asignacion de cursos y materias]]"
sprint: ""
puntos: 3
estado: backlog
prioridad: media
orden: 23
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
  Cuando inicio sesión con el rol Docente
  Entonces mi panel muestra una tarjeta por aula + materia (p. ej. "Matemática · 1.º Secundaria A")
  Y al elegir una tarjeta entro al aula (HU-019)

Escenario: Sin asignaciones
  Dado que no tengo asignaciones en la gestión activa
  Entonces veo "Aún no tienes materias asignadas. Consulta con coordinación pedagógica"

Escenario: Próxima gestión
  Dado que ya tengo asignaciones en una gestión planificada
  Entonces las veo en una sección aparte "Próxima gestión"

Escenario: Asignación retirada
  Dado que coordinación me retiró una materia
  Cuando vuelvo a cargar mi panel
  Entonces esa tarjeta ya no aparece

Escenario: Varios roles
  Dado que tengo los roles Docente y Coordinación pedagógica
  Cuando cambio al rol Docente (HU-007)
  Entonces veo mis aulas asignadas
```

## Notas
Completa el panel docente iniciado en [[HU-007 Panel segun rol]].
