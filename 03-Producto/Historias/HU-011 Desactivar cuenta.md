---
tipo: historia
id: HU-011
epica: "[[EP-02 Gestion de usuarios y roles]]"
sprint: "[[Sprint 3 - Gestion de personal]]"
puntos: 2
estado: refinada
orden: 12
tags: [historia, fase1]
---
# HU-011 · Desactivar cuenta del personal

Épica: [[EP-02 Gestion de usuarios y roles]] · Sprint: [[Sprint 3 - Gestion de personal]]

## Historia
> **Como** secretaria académica
> **quiero** desactivar la cuenta de una persona que dejó el colegio
> **para** que ya no pueda acceder a la información de estudiantes.

## Criterios de aceptación
```gherkin
Escenario: Desactivar
  Cuando desactivo una cuenta indicando el motivo
  Entonces sus sesiones se cierran de inmediato
  Y no puede volver a iniciar sesión (ver HU-001, cuenta desactivada)
  Y su historial (asignaciones, auditoría) se conserva

Escenario: Reactivar
  Cuando reactivo la cuenta
  Entonces la persona puede ingresar nuevamente
```

## Notas
Nunca se borra físicamente una cuenta: se desactiva (trazabilidad).
