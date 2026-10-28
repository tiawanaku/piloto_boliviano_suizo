---
tipo: historia
id: HU-008
epica: "[[EP-01 Login plantel administrativo y docentes]]"
sprint: ""
puntos: 5
estado: refinada
prioridad: media
orden: 26
roles: [administrativo, docente]
tags: [historia, fase1, seguridad]
---
# HU-008 · Ver y cerrar sesiones activas

> **Reordenada** en la [[2026-10-28 Revision del Product Owner]]: sale del Sprint 2. Tras las [[2026-10-28 Decisiones de la direccion]] queda **después del MVP del piloto**. El riesgo principal ya lo cubren la expiración por inactividad ([[HU-002 Cerrar sesion]]), el cierre de todas las sesiones al cambiar o recuperar la contraseña ([[HU-003 Recuperar contrasena]], [[HU-029 Mi cuenta datos y cambio de contrasena]]) y la desactivación ([[HU-011 Desactivar cuenta]]).

> **Como** docente que inició sesión en una cabina de internet
> **quiero** ver mis sesiones abiertas y cerrarlas a distancia
> **para** proteger mi cuenta si olvidé cerrar sesión en otro dispositivo.

## Criterios de aceptación
```gherkin
Escenario: Listar sesiones
  Cuando abro "Mi cuenta > Sesiones"
  Entonces veo cada sesión activa con navegador y sistema operativo, dirección IP y último uso
  Y la sesión actual aparece marcada

Escenario: Cerrar otra sesión
  Cuando elijo "Cerrar" en una sesión que no es la actual
  Entonces esa sesión queda invalidada de inmediato

Escenario: Cerrar todas
  Cuando elijo "Cerrar todas las demás sesiones"
  Entonces solo queda activa la sesión actual

Escenario: Sesión cerrada a distancia
  Dado que cerré a distancia la sesión de otro dispositivo
  Cuando alguien intenta seguir usándola en ese dispositivo
  Entonces se le pide iniciar sesión de nuevo
```

## Notas
- Sin "ubicación aproximada" en esta versión: requiere geolocalizar la IP, aporta poco y añade riesgo de privacidad (propuesta del Scrum Master aceptada en [[2026-10-28 Decisiones de la direccion]]).
