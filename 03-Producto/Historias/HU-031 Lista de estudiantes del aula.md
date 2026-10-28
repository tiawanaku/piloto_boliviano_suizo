---
tipo: historia
id: HU-031
epica: "[[EP-04 Aulas virtuales]]"
sprint: ""
puntos: 2
estado: backlog
prioridad: media
orden: 27
tags: [historia, fase3]
---
# HU-031 · Lista de estudiantes del aula

Épica: [[EP-04 Aulas virtuales]]

> Surge de la división de [[HU-019 Panel del aula virtual]] en la [[2026-10-28 Revision del Product Owner]]. Estimación provisional del PO.

## Historia
> **Como** docente asignado a un aula
> **quiero** ver la lista de estudiantes matriculados en ella
> **para** conocer a mi curso y saber a quién estoy enseñando.

## Criterios de aceptación
```gherkin
Escenario: Ver lista
  Dado que soy docente con al menos una materia en "1.º Secundaria A — 2027"
  Cuando abro la pestaña "Estudiantes" del aula
  Entonces veo a los estudiantes con matrícula vigente, ordenados por apellido
  Y solo veo nombre completo y estado de matrícula (sin CI, fecha de nacimiento ni datos del tutor)

Escenario: Cambios de matrícula
  Dado que un estudiante fue retirado o cambió de paralelo (HU-023)
  Entonces ya no aparece en la lista vigente del aula de origen

Escenario: Aula sin estudiantes
  Dado que el aula aún no tiene matrículas
  Entonces veo "Aún no hay estudiantes matriculados en esta aula"

Escenario: Aula ajena
  Dado que no tengo asignación en el aula
  Cuando intento ver su lista de estudiantes, incluso por URL directa
  Entonces se deniega el acceso y el intento queda registrado
```

## Notas
- Datos de menores: mínimo necesario ([[Seguridad y proteccion de datos]]).
- **Decisión pendiente** de la dirección: ¿el docente puede ver el contacto del tutor?
- Depende de [[HU-023 Matricular estudiantes en aula]].
