---
tipo: historia
id: HU-002
epica: "[[EP-01 Login plantel administrativo y docentes]]"
sprint: "[[Sprint 1 - Login base]]"
puntos: 1
estado: aceptada-condicional
prioridad: alta
orden: 3
roles: [administrativo, docente]
tags: [historia, fase1, autenticacion]
---
# HU-002 · Cerrar sesión (y expiración por inactividad)

> ✅ **Aceptada con condición** en la [[2026-11-27 Sprint Review - Sprint 1]]: falta que una persona revise y fusione el PR #1 y que el usuario verifique la experiencia en un navegador real.

> **Como** miembro del personal que a veces usa un dispositivo compartido en casa
> **quiero** cerrar mi sesión y que expire sola si la dejo abierta
> **para** que nadie más acceda a datos de estudiantes con mi cuenta.

## Criterios de aceptación
```gherkin
Escenario: Cerrar sesión manualmente
  Dado que tengo una sesión iniciada
  Cuando elijo "Cerrar sesión" en el menú de usuario
  Entonces mi sesión se invalida en el servidor
  Y vuelvo a la pantalla de inicio de sesión
  Y al usar "atrás" en el navegador no veo información protegida

Escenario: Expiración por inactividad
  Dado que tengo una sesión iniciada
  Cuando pasan 30 minutos sin actividad
  Entonces la sesión expira y se me pide iniciar sesión de nuevo
```

## Notas
- **Historia de referencia = 1 punto** ([[Estimacion y Planning Poker]]).
- Tiempo de inactividad configurable por TI (por defecto 30 min).
