---
tipo: historia
id: HU-023
epica: "[[EP-05 Asignacion de cursos y materias]]"
sprint: ""
puntos: 5
estado: backlog
prioridad: alta
orden: 23
tags: [historia, fase3, mvp-2027]
---
# HU-023 · Matricular estudiantes en aula

Épica: [[EP-05 Asignacion de cursos y materias]]

> Ajustada en la revisión del PO del 2026-10-28: el registro del estudiante y su tutor pasó a [[HU-033 Registrar estudiante y tutor]] y la generación de credenciales a [[HU-034 Credenciales del estudiante para el tutor]].

## Historia
> **Como** secretaria académica
> **quiero** matricular a cada estudiante registrado en su aula virtual de la gestión
> **para** que quede vinculado a su curso y a sus materias.

## Criterios de aceptación
```gherkin
Escenario: Matricular
  Dado que el estudiante está registrado con su tutor (HU-033)
  Y la Gestión 2027 está planificada o activa
  Cuando lo matriculo en "1.º Secundaria A — 2027"
  Entonces queda vinculado al aula y a sus materias
  Y aparece en la lista de estudiantes del aula (HU-031)

Escenario: Paralelo sin cupo
  Dado que 1.º A alcanzó su cupo (HU-016)
  Cuando intento matricular a otro estudiante allí, o cambiarlo a ese paralelo
  Entonces la matrícula no se registra
  Y veo "1.º Secundaria A alcanzó su cupo (N). Elige otro paralelo o pide a coordinación que amplíe el cupo"

Escenario: Estudiante no registrado
  Cuando busco a un estudiante que no existe
  Entonces se me ofrece registrarlo primero (HU-033)

Escenario: Matrícula única por gestión
  Dado que el estudiante ya está matriculado en 1.º A de la Gestión 2027
  Cuando intento matricularlo en otra aula de la misma gestión
  Entonces no se crea una segunda matrícula
  Y se me ofrece hacer un "cambio de paralelo"

Escenario: Cambio de paralelo
  Cuando cambio al estudiante de 1.º A a 1.º B indicando el motivo
  Entonces queda matriculado en 1.º B desde esa fecha
  Y la matrícula en 1.º A queda en el historial como "cambio de paralelo"

Escenario: Retiro
  Cuando registro el retiro del estudiante con fecha y motivo
  Entonces su matrícula pasa a "retirado"
  Y deja de aparecer en la lista vigente del aula

Escenario: Gestión cerrada o sin permiso
  Cuando intento matricular en una gestión cerrada, o sin ser Secretaría académica o Dirección
  Entonces la acción no está permitida
```

## Notas
- Toda matrícula, cambio y retiro queda en auditoría.
- Datos de menores: mínimo necesario ([[Seguridad y proteccion de datos]]).
- Cupo por paralelo: **se aplica** (decisión de la dirección, [[2026-10-28 Decisiones de la direccion]]); el valor es configurable en [[HU-016 Configurar niveles grados y paralelos]].
