---
tipo: adr
id: ADR-004
estado: aceptada
fecha: 2026-10-28
tags: [adr, autorizacion]
---
# ADR-004 · Control de acceso basado en roles (RBAC)

Volver a [[Vision de arquitectura]]

## Contexto
El colegio tiene funciones claras (dirección, secretaría, coordinación, TI, oficina, docentes) y una persona puede ejercer varias.

## Decisión
Usar **RBAC**: permisos agrupados en roles; usuarios con uno o varios roles. Para restricciones por recurso (p. ej. "docente solo ve *sus* aulas") se añade una verificación de **pertenencia** sobre las asignaciones ([[EP-05 Asignacion de cursos y materias]]).

## Consecuencias
- Matriz documentada en [[Roles y permisos RBAC]].
- Roles y permisos como datos (configurables), no como código fijo.
