---
tipo: historia
id: HU-027
epica: "[[EP-07 Oficina de informacion]]"
sprint: ""
puntos: 5
estado: idea
prioridad: baja
orden: 33
tags: [historia, fase5]
---
# HU-027 · Consulta rápida para oficina de información

Épica: [[EP-07 Oficina de informacion]]

## Historia
> **Como** persona de la oficina de información
> **quiero** buscar a un estudiante o docente y ver datos básicos (aula, estado de matrícula, contacto institucional)
> **para** responder consultas presenciales de familias.

## Criterios de aceptación
```gherkin
Escenario: Búsqueda
  Cuando busco por nombre o CI
  Entonces veo solo datos básicos permitidos a mi rol
```

## Notas
Permisos mínimos de lectura ([[Roles y permisos RBAC]]).
