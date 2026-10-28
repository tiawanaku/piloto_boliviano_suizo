---
tipo: historia
id: HU-006
epica: "[[EP-01 Login plantel administrativo y docentes]]"
sprint: "[[Sprint 1 - Login base]]"
puntos: 3
estado: lista
prioridad: alta
orden: 4
roles: [administrativo, docente]
tags: [historia, fase1, autenticacion]
---
# HU-006 · Cambio de contraseña en el primer ingreso

> **Como** miembro del personal que recibió una contraseña temporal
> **quiero** que el sistema me obligue a definir mi propia contraseña al primer ingreso
> **para** que solo yo conozca mi contraseña.

## Criterios de aceptación
```gherkin
Escenario: Contraseña temporal
  Dado que mi cuenta tiene una contraseña temporal
  Cuando inicio sesión con ella
  Entonces debo definir una nueva contraseña antes de acceder a cualquier otra pantalla

Escenario: Política de contraseña
  Cuando defino una contraseña de menos de 10 caracteres o que aparece en listas de contraseñas comunes
  Entonces veo qué requisito no se cumple, en lenguaje claro

Escenario: Contraseña temporal vencida
  Dado que la contraseña temporal tiene más de 72 horas
  Cuando intento usarla
  Entonces veo que debo solicitar una nueva a secretaría
```

## Notas
Ver [[Seguridad y proteccion de datos#Política de contraseñas]]. Indicador visual de fortaleza.
