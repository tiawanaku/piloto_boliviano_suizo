---
tipo: historia
id: HU-019
epica: "[[EP-04 Aulas virtuales]]"
sprint: ""
puntos: 3
estado: backlog
prioridad: media
orden: 24
tags: [historia, fase3]
---
# HU-019 · Panel del aula virtual (materias y docentes)

Épica: [[EP-04 Aulas virtuales]]

> **Dividida** en la revisión del PO del 2026-10-28 ([[2026-10-28 Revision del Product Owner]]): la lista de estudiantes pasó a [[HU-031 Lista de estudiantes del aula]] y los anuncios a [[HU-032 Anuncios del aula]]. Estimación anterior: 8 pts.

## Historia
> **Como** docente
> **quiero** entrar a un aula virtual y ver su ficha con las materias y el docente de cada una
> **para** saber con quién comparto el curso y tener un punto de partida para mi trabajo.

## Criterios de aceptación
```gherkin
Escenario: Docente asignado
  Dado que soy docente de Matemática en "1.º Secundaria A — 2027"
  Cuando entro a esa aula desde "Mis aulas" (HU-022)
  Entonces veo el nombre del aula, la gestión y la lista de materias con su docente
  Y mis materias aparecen destacadas

Escenario: Coordinación o Dirección
  Dado que soy Coordinación pedagógica o Dirección
  Cuando abro cualquier aula de la gestión
  Entonces veo la misma ficha, en modo consulta

Escenario: Materia sin docente
  Dado que una materia del aula no tiene docente asignado
  Entonces aparece como "Docente por asignar"

Escenario: Aula sin materias
  Dado que el aula aún no tiene materias (HU-020)
  Entonces veo "Esta aula aún no tiene materias asignadas"

Escenario: Aula ajena
  Dado que soy docente sin asignación en "1.º Secundaria B — 2027"
  Cuando intento abrir esa aula, incluso por URL directa
  Entonces veo "No tienes permiso para ver esta aula"
  Y el intento queda registrado

Escenario: Aula de una gestión cerrada
  Cuando abro un aula de una gestión cerrada en la que tuve asignación
  Entonces la veo en solo lectura con la etiqueta "Gestión cerrada"
```

## Notas
- Depende de [[HU-018 Crear aulas virtuales por paralelo]], [[HU-020 Asignar materias al aula]] y [[HU-021 Asignar docente a materia]].
- Relacionadas: [[HU-031 Lista de estudiantes del aula]] · [[HU-032 Anuncios del aula]].
