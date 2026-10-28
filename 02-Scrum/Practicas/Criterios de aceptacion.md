---
tipo: concepto
tags: [scrum/practica]
aliases: [Acceptance criteria, Gherkin]
---
# Criterios de aceptación

Volver a [[Historias de usuario]]

Condiciones **específicas de una historia** que deben cumplirse para que el [[Product Owner]] la acepte. Complementan (no reemplazan) la [[Definicion de Terminado]].

## Formato Gherkin (Dado / Cuando / Entonces)
```gherkin
Escenario: Inicio de sesión exitoso de un docente
  Dado que soy un docente con una cuenta activa
  Y estoy en la pantalla de inicio de sesión del personal
  Cuando ingreso mi correo institucional y mi contraseña correcta
  Entonces accedo al panel docente
  Y veo mi nombre en la parte superior
```

## Consejos
- Uno por comportamiento; incluir camino feliz **y** errores.
- Evitar detalles de implementación ("usar JWT") salvo que sean requisitos.
- Deben poder convertirse en pruebas automatizadas.
