---
tipo: historia
id: HU-037
epica: "[[EP-09 Acceso de tutores]]"
sprint: ""
puntos: 3
estado: backlog
prioridad: media
orden: 33
tags: [historia, fase4, tutores]
---
# HU-037 · El tutor solicita restablecer el acceso del estudiante

Épica: [[EP-09 Acceso de tutores]]

## Historia
> **Como** tutor con cuenta activa
> **quiero** pedir desde mi cuenta un nuevo acceso para mi hijo cuando olvida su contraseña
> **para** que pueda volver a sus clases el mismo día, sin ir a la oficina.

## Criterios de aceptación (alto nivel)
```gherkin
Escenario: Solicitar
  Cuando elijo "Nuevo acceso" para uno de mis hijos
  Entonces recibo una nueva contraseña temporal para él, la anterior deja de funcionar y se cierran sus sesiones abiertas
  Y la acción queda en auditoría

Escenario: Abuso
  Cuando pido más de 3 restablecimientos en un día
  Entonces veo que debo comunicarme con secretaría
```

## Notas
Depende de la definición de credenciales de estudiantes ([[HU-034 Credenciales del estudiante para el tutor]]), pendiente para la Fase 4.
