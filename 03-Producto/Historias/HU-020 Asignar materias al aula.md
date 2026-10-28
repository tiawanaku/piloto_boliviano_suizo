---
tipo: historia
id: HU-020
epica: "[[EP-05 Asignacion de cursos y materias]]"
sprint: ""
puntos: 3
estado: backlog
prioridad: alta
orden: 19
tags: [historia, fase3, mvp-2027]
---
# HU-020 · Asignar materias a las aulas virtuales

Épica: [[EP-05 Asignacion de cursos y materias]]

## Historia
> **Como** coordinadora pedagógica
> **quiero** definir las materias de cada grado y aplicarlas a todas sus aulas virtuales, con ajustes por aula
> **para** que cada aula refleje el plan de estudios de su grado sin cargarlo aula por aula.

## Criterios de aceptación
```gherkin
Escenario: Aplicar materias del grado
  Dado que las aulas de 1.º de Secundaria de la Gestión 2027 existen (HU-018)
  Cuando elijo del catálogo las materias de "1.º Secundaria" y las aplico
  Entonces cada aula de ese grado recibe esas materias

Escenario: Volver a aplicar sin duplicar
  Cuando vuelvo a aplicar las materias del grado tras agregar una materia
  Entonces cada aula recibe solo la materia nueva, sin duplicar las existentes

Escenario: Ajuste individual
  Cuando agrego o quito una materia de un aula específica
  Entonces el cambio afecta solo a esa aula

Escenario: Quitar materia con docente asignado
  Dado que la materia ya tiene docente en esa aula (HU-021)
  Cuando intento quitarla
  Entonces veo una advertencia que nombra al docente afectado
  Y si confirmo, la asignación termina y queda en el historial

Escenario: Materia no disponible
  Dado que una materia está desactivada o no corresponde al nivel del grado
  Entonces no aparece en la lista de materias a aplicar

Escenario: Sin aulas o gestión cerrada
  Cuando el grado no tiene aulas generadas o la gestión está cerrada
  Entonces no puedo aplicar materias y veo el motivo
```

## Notas
- Permisos: Coordinación pedagógica y Dirección ([[Roles y permisos RBAC]]).
- Los cambios quedan en auditoría.
- **Re-estimar** en refinamiento: el alcance ahora incluye explícitamente el plan de estudios por grado.
