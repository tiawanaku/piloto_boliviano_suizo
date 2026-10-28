---
tipo: historia
id: HU-004
epica: "[[EP-01 Login plantel administrativo y docentes]]"
sprint: "[[Sprint 2 - Seguridad del login]]"
puntos: 3
estado: refinada
prioridad: alta
orden: 7
roles: [administrativo, docente]
tags: [historia, fase1, seguridad]
---
# HU-004 · Bloqueo temporal por intentos fallidos

> **Como** responsable de soporte TI
> **quiero** que una cuenta se bloquee temporalmente tras varios intentos fallidos
> **para** evitar que alguien adivine contraseñas del personal.

## Criterios de aceptación
```gherkin
Escenario: Bloqueo tras 5 intentos
  Dado una cuenta activa
  Cuando se ingresan 5 contraseñas incorrectas en 15 minutos
  Entonces la cuenta se bloquea 15 minutos
  Y se muestra "Demasiados intentos. Intenta de nuevo en 15 minutos o recupera tu contraseña"
  Y el titular recibe un correo de aviso

Escenario: Muchos intentos desde una misma IP
  Dado que desde una misma dirección IP se hicieron 20 intentos fallidos en un minuto, con cualquier correo
  Cuando se hace otro intento desde esa IP
  Entonces se rechaza sin evaluar las credenciales
  Y se muestra "Demasiados intentos. Espera un minuto e inténtalo de nuevo"
  Y los ingresos correctos no cuentan para este límite

Escenario: Desbloqueo por tiempo
  Dado que la cuenta está bloqueada
  Cuando pasan 15 minutos
  Entonces puedo intentar iniciar sesión de nuevo

Escenario: Desbloqueo manual por TI
  Dado que soy Soporte TI
  Cuando desbloqueo la cuenta desde la administración
  Entonces el titular puede ingresar inmediatamente
  Y la acción queda en auditoría
```

## Notas
Umbrales configurables. Recuperar contraseña ([[HU-003 Recuperar contrasena]]) desbloquea la cuenta.

Límite por IP (20 intentos fallidos/min, configurable) aceptado en la [[2026-11-27 Sprint Review - Sprint 1]] (DEF-02): frena los ataques que prueban muchos correos distintos, que el bloqueo por cuenta no detecta.
