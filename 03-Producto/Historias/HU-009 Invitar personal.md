---
tipo: historia
id: HU-009
epica: "[[EP-02 Gestion de usuarios y roles]]"
sprint: "[[Sprint 3 - Gestion de personal]]"
puntos: 5
estado: refinada
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
```

## Notas
Reemplaza la creación por script del Sprint 1. Relacionada con [[HU-006 Cambio de contrasena en primer ingreso]].
