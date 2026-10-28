---
tipo: historia
id: HU-010
epica: "[[EP-02 Gestion de usuarios y roles]]"
sprint: "[[Sprint 3 - Gestion de personal]]"
puntos: 3
estado: refinada
orden: 11
tags: [historia, fase1]
---
# HU-010 · Asignar roles al personal

Épica: [[EP-02 Gestion de usuarios y roles]] · Sprint: [[Sprint 3 - Gestion de personal]]

## Historia
> **Como** directora o soporte TI
> **quiero** asignar y quitar roles a una cuenta del personal
> **para** que cada persona tenga exactamente los permisos que su función requiere.

## Criterios de aceptación
```gherkin
Escenario: Asignar rol
  Dado que soy Dirección o Soporte TI
  Cuando agrego el rol "Coordinación pedagógica" a un docente
  Entonces en su próximo ingreso puede cambiar a ese rol (HU-007)

Escenario: Restricción
  Dado que soy Secretaría académica
  Cuando intento asignar el rol "Dirección" o "Soporte TI"
  Entonces la acción no está permitida

Escenario: Auditoría
  Cuando se agrega o quita un rol
  Entonces queda registrado quién, a quién, qué rol y cuándo
```

## Notas
Matriz de permisos en [[Roles y permisos RBAC]].
