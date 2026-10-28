---
tipo: historia
id: HU-035
epica: "[[EP-09 Acceso de tutores]]"
sprint: ""
puntos: 5
estado: backlog
prioridad: media
orden: 31
tags: [historia, fase4, tutores]
---
# HU-035 · Activar la cuenta del tutor

Épica: [[EP-09 Acceso de tutores]]

## Historia
> **Como** madre, padre o tutor legal de un estudiante
> **quiero** activar mi propia cuenta en la plataforma del colegio
> **para** acompañar a mi hijo sin tener que ir a la oficina de información.

## Criterios de aceptación (alto nivel)
```gherkin
Escenario: Invitación al tutor
  Dado que soy tutor registrado (HU-033) de un estudiante con matrícula vigente
  Cuando secretaría me envía la invitación al celular o correo registrado
  Entonces puedo activar mi cuenta definiendo mi contraseña con un enlace de un solo uso

Escenario: Invitación vencida o usada
  Cuando abro un enlace vencido o ya usado
  Entonces veo que debo pedir una nueva invitación a secretaría

Escenario: Acceso separado
  Cuando intento usar mi cuenta de tutor en el portal del personal
  Entonces el acceso se rechaza
```

## Notas
- Si se decide el consentimiento en línea, se pide aquí ([[HU-038 Consentimiento en linea del tutor]]).
- Canal (app o web) y política de contraseñas: pendientes de refinamiento.
