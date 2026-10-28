---
tipo: historia
id: HU-030
epica: "[[EP-02 Gestion de usuarios y roles]]"
sprint: "[[Sprint 3 - Gestion de personal]]"
puntos: 3
estado: refinada
prioridad: alta
orden: 11
tags: [historia, fase1]
---
# HU-030 · Listado y ficha del personal

Épica: [[EP-02 Gestion de usuarios y roles]] · Sprint: [[Sprint 3 - Gestion de personal]]

> Agregada en la [[2026-10-28 Revision del Product Owner]]: [[HU-004 Bloqueo por intentos fallidos]], [[HU-005 MFA para personal administrativo]], [[HU-010 Asignar roles al personal]] y [[HU-011 Desactivar cuenta]] suponen que existe una pantalla para encontrar a la persona y actuar sobre su cuenta, y no había forma de corregir sus datos. Estimación provisional del PO, a confirmar por los Developers.

## Historia
> **Como** secretaria académica o soporte TI
> **quiero** buscar a cualquier miembro del personal y abrir su ficha
> **para** ver y corregir sus datos, sus roles y el estado de su cuenta desde un solo lugar.

## Criterios de aceptación
```gherkin
Escenario: Buscar y filtrar
  Dado que soy Secretaría académica, Soporte TI o Dirección
  Cuando busco por nombre, CI o correo y filtro por rol o estado (pendiente, activa, bloqueada, desactivada)
  Entonces veo la lista de personas que coinciden, ordenada por apellido

Escenario: Ver ficha
  Cuando abro la ficha de una persona
  Entonces veo sus datos (nombres, apellidos, CI, correo institucional, celular, cargo), roles, estado y último acceso
  Y solo veo las acciones que mi rol permite (reenviar invitación, roles, desactivar, desbloquear, restablecer MFA)

Escenario: Corregir datos
  Cuando corrijo nombres, apellidos, CI, celular o cargo y guardo
  Entonces los datos se actualizan
  Y la auditoría registra quién cambió qué, con el valor anterior y el nuevo

Escenario: CI duplicado
  Cuando ingreso un CI que ya pertenece a otra persona
  Entonces veo "Ya existe una persona con este CI" y no se guarda

Escenario: Cambio de correo institucional
  Dado que soy Secretaría académica
  Cuando intento cambiar el correo institucional
  Entonces la acción no está permitida: solo Soporte TI puede hacerlo, y queda auditado

Escenario: Sin permiso
  Dado que soy Docente u Oficina de información
  Cuando intento abrir el listado del personal
  Entonces veo "No tienes permiso para ver esta página"
```

## Notas
- Sin listado no hay forma práctica de ejecutar las acciones de HU-004, HU-005, HU-010 y HU-011: va **antes** que ellas en el Sprint 3.
- Datos mínimos del personal: confirmar con la dirección qué campos son obligatorios.
