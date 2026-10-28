---
tipo: historia
id: HU-016
epica: "[[EP-03 Estructura academica]]"
sprint: ""
puntos: 5
estado: backlog
prioridad: alta
orden: 16
tags: [historia, fase2, mvp-2027]
---
# HU-016 · Configurar niveles, grados y paralelos

Épica: [[EP-03 Estructura academica]]

## Historia
> **Como** coordinadora pedagógica
> **quiero** definir los niveles, grados y paralelos que el colegio ofrece en una gestión
> **para** contar con la estructura sobre la que se crearán las aulas virtuales.

## Criterios de aceptación
```gherkin
Escenario: Definir estructura
  Dado que la "Gestión 2027" está planificada o activa
  Cuando defino Secundaria > 1.º > paralelos A y B
  Entonces la estructura queda disponible para generar aulas (HU-018)

Escenario: Paralelo duplicado
  Dado que 1.º de Secundaria ya tiene el paralelo "A" en la Gestión 2027
  Cuando intento crear otro paralelo "A" en ese grado y gestión
  Entonces veo "Ese paralelo ya existe en este grado"

Escenario: Copiar de la gestión anterior
  Dado que existe una gestión anterior con estructura
  Cuando elijo "Copiar estructura de la gestión anterior"
  Entonces se replican niveles, grados y paralelos en la gestión nueva
  Y puedo ajustarlos antes de generar las aulas

Escenario: Sin gestión anterior
  Dado que es la primera gestión registrada
  Entonces la opción "Copiar estructura" no está disponible y se explica por qué

Escenario: Cupo por paralelo
  Dado que el colegio configuró un cupo por defecto por paralelo
  Cuando creo un paralelo
  Entonces toma el cupo por defecto
  Y puedo cambiarlo para ese paralelo a un número entero mayor a 0

Escenario: Bajar el cupo por debajo de los matriculados
  Dado que 1.º A tiene 30 estudiantes matriculados
  Cuando intento fijar su cupo en 25
  Entonces veo "El cupo no puede ser menor que los 30 estudiantes matriculados"

Escenario: Quitar un paralelo en uso
  Dado que el paralelo "B" ya tiene aula virtual con materias o estudiantes
  Cuando intento eliminarlo
  Entonces no se elimina
  Y veo qué lo está usando y que solo puedo desactivarlo

Escenario: Gestión cerrada
  Dado que la gestión está cerrada
  Cuando intento modificar su estructura
  Entonces la acción no está permitida (ver HU-015)
```

## Notas
- Niveles y grados cambian poco (catálogo normativo); los **paralelos** pertenecen a cada gestión.
- Configurable para adaptarse a la normativa ([[Marco normativo Bolivia]]).
- **Cupo por paralelo:** la dirección decidió aplicarlo; el valor por defecto es configurable y aún no está definido ([[2026-10-28 Decisiones de la direccion]]). Re-estimar en refinamiento.
- Permisos: Dirección, Secretaría académica y Coordinación pedagógica ([[Roles y permisos RBAC]]).
