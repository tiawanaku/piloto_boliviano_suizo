---
tipo: historia
id: HU-008
epica: "[[EP-01 Login plantel administrativo y docentes]]"
sprint: "[[Sprint 2 - Seguridad del login]]"
puntos: 5
estado: refinada
prioridad: media
orden: 9
roles: [administrativo, docente]
tags: [historia, fase1, seguridad]
---
# HU-008 · Ver y cerrar sesiones activas

> **Como** docente que inició sesión en una cabina de internet
> **quiero** ver mis sesiones abiertas y cerrarlas a distancia
> **para** proteger mi cuenta si olvidé cerrar sesión en otro dispositivo.

## Criterios de aceptación
```gherkin
Escenario: Listar sesiones
  Cuando abro "Mi cuenta > Sesiones"
  Entonces veo cada sesión activa con dispositivo/navegador, ubicación aproximada y último uso
  Y la sesión actual aparece marcada

Escenario: Cerrar otra sesión
  Cuando elijo "Cerrar" en una sesión que no es la actual
  Entonces esa sesión queda invalidada de inmediato

Escenario: Cerrar todas
  Cuando elijo "Cerrar todas las demás sesiones"
  Entonces solo queda activa la sesión actual
```
