---
tipo: historia
id: HU-024
epica: "[[EP-06 App de estudiantes]]"
sprint: ""
puntos: 8
estado: backlog
orden: 24
tags: [historia, fase4]
---
# HU-024 · Login de estudiante en la app

Épica: [[EP-06 App de estudiantes]]

## Historia
> **Como** estudiante
> **quiero** ingresar a la app con el usuario y contraseña que me dio el colegio
> **para** entrar a mis clases virtuales.

## Criterios de aceptación
```gherkin
Escenario: Ingreso
  Cuando ingreso mi usuario de estudiante y contraseña
  Entonces veo mi aula virtual

Escenario: Restablecer
  Cuando olvido mi contraseña
  Entonces la app me indica que mi tutor puede solicitar el restablecimiento a secretaría
```

## Notas
Separado del login del personal: [[ADR-003 Separar acceso de personal y estudiantes]].
