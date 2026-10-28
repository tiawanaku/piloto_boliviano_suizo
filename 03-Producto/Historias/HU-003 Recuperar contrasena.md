---
tipo: historia
id: HU-003
epica: "[[EP-01 Login plantel administrativo y docentes]]"
sprint: "[[Sprint 2 - Seguridad del login]]"
puntos: 5
estado: refinada
prioridad: alta
orden: 6
roles: [administrativo, docente]
tags: [historia, fase1, autenticacion]
---
# HU-003 · Recuperar contraseña

> **Como** docente que olvidó su contraseña
> **quiero** restablecerla desde un enlace enviado a mi correo institucional
> **para** volver a ingresar sin tener que ir a la oficina ni llamar a soporte.

## Criterios de aceptación
```gherkin
Escenario: Solicitar recuperación
  Dado que estoy en la pantalla de login
  Cuando elijo "¿Olvidaste tu contraseña?" e ingreso mi correo institucional
  Entonces veo "Si el correo está registrado, recibirás un enlace en unos minutos"
  Y recibo un correo con un enlace de un solo uso válido por 30 minutos

Escenario: Restablecer con enlace válido
  Dado que abro el enlace dentro de su vigencia
  Cuando defino una nueva contraseña que cumple la política
  Entonces mi contraseña se actualiza
  Y todas mis sesiones abiertas se cierran
  Y recibo un correo de confirmación del cambio

Escenario: Enlace vencido o ya usado
  Cuando abro un enlace vencido o usado
  Entonces veo "Este enlace ya no es válido" y la opción de solicitar uno nuevo
```

## Notas
- Respuesta idéntica exista o no el correo (evita enumeración de cuentas).
- Límite de solicitudes por correo/IP (p. ej. 3 por hora).
- Dependencia: servicio de correo saliente del dominio institucional (preparado en [[Sprint 0 - Preparacion]]).
- Política de contraseñas: ver [[Seguridad y proteccion de datos#Política de contraseñas]].
