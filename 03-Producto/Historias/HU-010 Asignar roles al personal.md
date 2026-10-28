---
tipo: historia
id: HU-010
epica: "[[EP-02 Gestion de usuarios y roles]]"
sprint: "[[Sprint 3 - Gestion de personal]]"
puntos: 3
estado: refinada
prioridad: alta
orden: 12
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

Escenario: Quitar rol
  Dado que una persona tiene los roles Docente y Coordinación pedagógica
  Cuando le quito el rol Coordinación pedagógica
  Entonces pierde esos permisos desde su siguiente acción, aunque tenga una sesión abierta

Escenario: Cuenta sin roles
  Cuando intento quitar el único rol de una cuenta
  Entonces veo "La cuenta debe tener al menos un rol; si la persona dejó el colegio, desactívala"

Escenario: Auditoría
  Cuando se agrega o quita un rol
  Entonces queda registrado quién, a quién, qué rol y cuándo
```

## Notas
Matriz de permisos en [[Roles y permisos RBAC]].
