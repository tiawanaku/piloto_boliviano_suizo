---
tipo: historia
id: HU-017
epica: "[[EP-03 Estructura academica]]"
sprint: ""
puntos: 3
estado: backlog
prioridad: alta
orden: 17
tags: [historia, fase2, mvp-2027]
---
# HU-017 · Catálogo de materias

Épica: [[EP-03 Estructura academica]]

## Historia
> **Como** coordinadora pedagógica
> **quiero** mantener el catálogo de materias/áreas por nivel
> **para** asignarlas luego a los grados y aulas virtuales.

## Criterios de aceptación
```gherkin
Escenario: Registrar materia
  Dado que soy Coordinación pedagógica o Dirección
  Cuando registro "Matemática" con código "MAT", nivel(es) y carga horaria semanal
  Entonces aparece activa en el catálogo

Escenario: Datos inválidos
  Cuando dejo vacío el nombre o el código, no elijo ningún nivel, o la carga horaria no es mayor a 0
  Entonces veo el error junto a cada campo y la materia no se guarda

Escenario: Código duplicado
  Cuando registro una materia con un código que ya existe
  Entonces veo "Ya existe una materia con ese código"

Escenario: Editar materia
  Cuando corrijo el nombre o la carga horaria de una materia
  Entonces el cambio se refleja en las aulas de la gestión no cerrada que la usan
  Y las gestiones cerradas conservan el dato histórico

Escenario: Materia en uso
  Dado que una materia ya está asignada a un aula
  Cuando intento eliminarla
  Entonces solo puedo desactivarla
  Y una materia desactivada no se ofrece en nuevas asignaciones (HU-020)
```

## Notas
- El **plan de estudios por grado** (qué materias lleva cada grado) se define en [[HU-020 Asignar materias al aula]].
- Áreas y cargas horarias: validar con la normativa vigente ([[Marco normativo Bolivia]]).
