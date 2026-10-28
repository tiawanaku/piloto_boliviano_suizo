---
tipo: historia
id: HU-015
epica: "[[EP-03 Estructura academica]]"
sprint: ""
puntos: 3
estado: backlog
prioridad: alta
orden: 15
tags: [historia, fase2, mvp-2027]
---
# HU-015 · Registrar gestión académica

Épica: [[EP-03 Estructura academica]]

## Historia
> **Como** secretaria académica
> **quiero** registrar la gestión escolar (año) con sus fechas y periodos de evaluación
> **para** preparar el inicio de clases y que todo lo académico quede organizado y conservado por año.

## Criterios de aceptación
```gherkin
Escenario: Crear gestión planificada
  Dado que soy Secretaría académica, Coordinación pedagógica o Dirección
  Cuando registro "Gestión 2027" con fecha de inicio, fecha de fin y 3 trimestres con sus fechas
  Entonces la gestión queda en estado "planificada"
  Y ya puedo preparar sobre ella la estructura, las aulas y las asignaciones (HU-016, HU-018, HU-021)

Escenario: Fechas inválidas
  Cuando la fecha de fin es anterior a la de inicio, o un periodo se sale del rango de la gestión o se superpone con otro
  Entonces veo qué fecha debo corregir
  Y la gestión no se guarda

Escenario: Gestión duplicada
  Dado que ya existe la "Gestión 2027"
  Cuando intento registrar otra gestión para el año 2027
  Entonces veo "Ya existe una gestión para ese año"

Escenario: Activar gestión
  Dado que la "Gestión 2027" está planificada
  Cuando la activo y confirmo la advertencia
  Entonces pasa a "activa" y es la que ven por defecto docentes y estudiantes
  Y si había otra gestión activa, esa pasa a "cerrada"

Escenario: Gestión cerrada es solo lectura
  Dado que una gestión está "cerrada"
  Cuando intento modificar sus fechas, estructura, asignaciones o matrículas
  Entonces la acción no está permitida
  Y sus datos se conservan como histórico

Escenario: Sin permiso
  Dado que soy Docente u Oficina de información
  Cuando intento crear o activar una gestión
  Entonces veo "No tienes permiso para realizar esta acción"
```

## Notas
- Solo puede haber **una** gestión activa; puede coexistir una gestión **planificada** para preparar el inicio de la siguiente.
- Activar y cerrar una gestión quedan en auditoría ([[EP-08 Seguridad y auditoria]]).
- Cantidad y nombre de los periodos (trimestres, bimestres) configurables: validar con [[Marco normativo Bolivia]].
- Ver [[Modelo de dominio]].
