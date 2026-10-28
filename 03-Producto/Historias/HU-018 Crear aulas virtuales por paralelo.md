---
tipo: historia
id: HU-018
epica: "[[EP-04 Aulas virtuales]]"
sprint: ""
puntos: 5
estado: backlog
prioridad: alta
orden: 18
tags: [historia, fase2, mvp-2027]
---
# HU-018 · Crear aulas virtuales por paralelo

Épica: [[EP-04 Aulas virtuales]]

## Historia
> **Como** coordinadora pedagógica
> **quiero** generar automáticamente un aula virtual por cada paralelo de la gestión
> **para** que cada curso tenga su espacio virtual sin crearlo a mano.

## Criterios de aceptación
```gherkin
Escenario: Generación
  Dado que la estructura de la Gestión 2027 está configurada (HU-016)
  Cuando ejecuto "Generar aulas virtuales"
  Entonces se crea un aula por paralelo activo con el nombre "1.º Secundaria A — 2027"
  Y veo un resumen "Se crearon N aulas"

Escenario: Sin duplicados
  Dado que algunas aulas de la gestión ya existen
  Cuando vuelvo a ejecutar "Generar aulas virtuales" después de agregar un paralelo
  Entonces solo se crean las aulas que faltan
  Y el resumen indica cuántas ya existían

Escenario: Estructura vacía
  Dado que la gestión no tiene paralelos configurados
  Cuando ejecuto "Generar aulas virtuales"
  Entonces veo "Primero configura los niveles, grados y paralelos de la gestión"

Escenario: Paralelo desactivado
  Dado que un paralelo con aula fue desactivado (HU-016)
  Entonces su aula queda "archivada": no se borra, no admite nuevas asignaciones y conserva su historial

Escenario: Gestión cerrada o sin permiso
  Cuando intento generar aulas en una gestión cerrada, o sin ser Coordinación pedagógica o Dirección
  Entonces la acción no está permitida
```

## Notas
- Aquí el aula es el **contenedor** (paralelo + gestión). El contenido pedagógico (recursos, tareas, clases) se construirá en el **sistema propio** del colegio, sin LMS externo (ver [[EP-04 Aulas virtuales]]).
- La generación queda en auditoría.
