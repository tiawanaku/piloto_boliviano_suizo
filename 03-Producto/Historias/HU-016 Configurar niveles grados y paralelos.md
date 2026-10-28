---
tipo: historia
id: HU-016
epica: "[[EP-03 Estructura academica]]"
sprint: ""
puntos: 5
estado: backlog
orden: 16
tags: [historia, fase2]
---
# HU-016 · Configurar niveles, grados y paralelos

Épica: [[EP-03 Estructura academica]]

## Historia
> **Como** coordinación académica
> **quiero** definir los niveles, grados y paralelos que se ofrecen en la gestión
> **para** contar con la estructura sobre la que se crearán las aulas virtuales.

## Criterios de aceptación
```gherkin
Escenario: Estructura
  Cuando defino Secundaria > 1.º > paralelos A y B para la Gestión 2027
  Entonces la estructura queda disponible para crear aulas (HU-018)

Escenario: Copiar de la gestión anterior
  Cuando elijo "copiar estructura de la gestión anterior"
  Entonces se replica la estructura y puedo ajustarla
```

## Notas
Configurable para adaptarse a la normativa ([[Marco normativo Bolivia]]).
