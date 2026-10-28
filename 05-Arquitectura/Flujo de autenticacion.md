---
tipo: arquitectura
tags: [arquitectura, autenticacion]
---
# Flujo de autenticación del personal

Volver a [[Vision de arquitectura]] · Épica: [[EP-01 Login plantel administrativo y docentes]]

## Secuencia
```mermaid
sequenceDiagram
    actor U as Personal
    participant W as Portal web
    participant A as API / Identidad
    participant DB as Base de datos
    participant AU as Auditoría

    U->>W: correo + contraseña
    W->>A: POST /auth/login
    A->>DB: buscar usuario por correo
    alt cuenta no existe / contraseña incorrecta
        A->>AU: intento fallido
        A->>DB: incrementar contador (HU-004)
        A-->>W: 401 "Correo o contraseña incorrectos"
    else cuenta bloqueada o desactivada
        A->>AU: intento sobre cuenta inactiva
        A-->>W: 403 mensaje correspondiente
    else credenciales válidas
        alt contraseña temporal (HU-006)
            A-->>W: exigir cambio de contraseña
        else MFA requerido (HU-005)
            A-->>W: pedir código TOTP
            U->>W: código 6 dígitos
            W->>A: POST /auth/mfa
        end
        A->>DB: crear sesión
        A->>AU: inicio de sesión exitoso
        A-->>W: cookie de sesión segura + roles
        W-->>U: redirigir a panel según rol (HU-007)
    end
```

## Estados de la cuenta
```mermaid
stateDiagram-v2
    [*] --> Pendiente: invitación (HU-009)
    Pendiente --> Activa: activa cuenta
    Activa --> Bloqueada: 5 intentos fallidos (HU-004)
    Bloqueada --> Activa: 15 min / TI / recuperar contraseña
    Activa --> Desactivada: secretaría (HU-011)
    Desactivada --> Activa: reactivar
```

## Decisiones clave
- Sesión con cookie `HttpOnly`, `Secure`, `SameSite`; expiración por inactividad 30 min ([[HU-002 Cerrar sesion]]).
- Mensajes de error genéricos para no revelar existencia de cuentas.
- Ver [[ADR-002 Autenticacion con correo institucional y MFA]].
