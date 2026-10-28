---
tipo: historia
id: HU-038
epica: "[[EP-09 Acceso de tutores]]"
sprint: ""
puntos: 5
estado: idea
prioridad: baja
orden: 34
tags: [historia, fase4, tutores, menores]
---
# HU-038 · Consentimiento en línea del tutor

Épica: [[EP-09 Acceso de tutores]]

> **Pregunta abierta de la dirección:** el mecanismo de consentimiento aún no está definido. Esta historia solo aplica si se decide que el tutor puede darlo en línea. Ver [[2026-10-28 Decisiones de la direccion]].

## Historia
> **Como** tutor
> **quiero** leer y aceptar en línea la política de tratamiento de datos de mi hijo
> **para** no tener que firmar en persona en la oficina de información.

## Criterios de aceptación (alto nivel)
```gherkin
Escenario: Aceptar
  Dado que activo mi cuenta y el colegio no tiene registrado mi consentimiento
  Cuando leo la política y la acepto
  Entonces queda registrado con fecha, hora, versión del texto y medio "en línea"

Escenario: No aceptar
  Cuando no acepto la política
  Entonces no accedo a los datos de mi hijo y veo cómo comunicarme con el colegio

Escenario: Nueva versión de la política
  Cuando el colegio publica una nueva versión del texto
  Entonces debo aceptarla de nuevo en mi siguiente ingreso
```

## Notas
- Validar el texto y su validez legal con asesoría ([[Marco normativo Bolivia]], Ley N.º 548).
