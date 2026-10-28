---
tipo: historia
id: HU-009
epica: "[[EP-02 Gestion de usuarios y roles]]"
sprint: "[[Sprint 3 - Gestion de personal]]"
puntos: 5
estado: refinada
prioridad: alta
orden: 10
tags: [historia, fase1]
---
# HU-009 · Invitar a un miembro del personal

Épica: [[EP-02 Gestion de usuarios y roles]] · Sprint: [[Sprint 3 - Gestion de personal]]

## Historia
> **Como** secretaria académica
> **quiero** registrar a un nuevo docente o administrativo y enviarle una invitación a su correo institucional
> **para** que pueda activar su cuenta sin que yo conozca su contraseña.

## Criterios de aceptación
```gherkin
Escenario: Invitación enviada
  Dado que soy Secretaría académica o Soporte TI
  Cuando registro nombres, apellidos, CI, correo institucional y rol(es) de una persona
  Entonces se crea la cuenta en estado "pendiente"
  Y la persona recibe un enlace de activación válido por 72 horas

Escenario: Correo duplicado
  Cuando registro un correo que ya existe
  Entonces veo "Ya existe una cuenta con este correo" y el enlace a esa cuenta

Escenario: Activación
  Dado que recibí la invitación
  Cuando abro el enlace y defino mi contraseña
  Entonces mi cuenta pasa a "activa" y puedo iniciar sesión (HU-001)

Escenario: Correo fuera del dominio o CI duplicado
  Cuando registro un correo que no es del dominio institucional o un CI que ya existe
  Entonces veo el error junto al campo y no se crea la cuenta

Escenario: Invitación vencida
  Dado que pasaron más de 72 horas sin activar la cuenta
  Cuando la persona abre el enlace
  Entonces ve "Esta invitación venció. Pide a secretaría que te la reenvíe"
  Y desde la ficha de la persona (HU-030) puedo reenviar la invitación, invalidando la anterior

Escenario: Sin permiso
  Dado que soy Docente, Coordinación pedagógica u Oficina de información
  Cuando intento invitar personal
  Entonces la acción no está permitida
```

## Notas
- Reemplaza la creación por script del Sprint 1.
- Con la invitación la persona define su contraseña desde el enlace; la contraseña temporal de [[HU-006 Cambio de contrasena en primer ingreso]] queda para las cuentas semilla del Sprint 1 y para casos en que TI entregue una contraseña temporal.
- La invitación y la activación quedan en auditoría.
