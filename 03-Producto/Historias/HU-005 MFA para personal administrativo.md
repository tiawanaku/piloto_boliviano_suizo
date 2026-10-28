---
tipo: historia
id: HU-005
epica: "[[EP-01 Login plantel administrativo y docentes]]"
sprint: "[[Sprint 2 - Seguridad del login]]"
puntos: 8
estado: refinada
prioridad: alta
orden: 8
roles: [administrativo]
tags: [historia, fase1, seguridad, mfa]
---
# HU-005 · Autenticación multifactor (MFA) para personal administrativo

> **Como** directora del colegio
> **quiero** que las cuentas administrativas exijan un segundo factor (código de app autenticadora)
> **para** que una contraseña robada no permita acceder a datos de todo el colegio.

## Criterios de aceptación
```gherkin
Escenario: Activación obligatoria en el primer ingreso
  Dado que tengo un rol administrativo y no tengo MFA configurado
  Cuando inicio sesión correctamente
  Entonces se me muestra un código QR para vincular mi app autenticadora
  Y debo confirmar un código de 6 dígitos para continuar
  Y recibo 10 códigos de respaldo de un solo uso para guardar

Escenario: Ingreso con MFA
  Dado que tengo MFA activo
  Cuando ingreso correo y contraseña correctos
  Entonces se me pide el código de 6 dígitos
  Y solo accedo si el código es válido

Escenario: Uso de código de respaldo
  Dado que perdí mi celular
  Cuando ingreso un código de respaldo válido
  Entonces accedo y ese código queda invalidado

Escenario: Restablecer MFA
  Dado que soy Soporte TI
  Cuando restablezco el MFA de un usuario tras verificar su identidad
  Entonces el usuario deberá configurarlo de nuevo en su próximo ingreso
  Y la acción queda en auditoría
```

## Notas
- Estándar TOTP (RFC 6238), compatible con Google Authenticator, Microsoft Authenticator, Aegis, etc.
- Para docentes: MFA **opcional** en Fase 1, decisión revisable ([[ADR-002 Autenticacion con correo institucional y MFA]]).
- Estimación alta (8) por incertidumbre en UX de la activación → considerar dividir si en refinamiento sube.
