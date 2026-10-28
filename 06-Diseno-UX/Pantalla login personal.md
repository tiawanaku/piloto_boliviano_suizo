---
tipo: diseno
tags: [ux, fase1, autenticacion]
---
# Pantalla de login del personal

Volver a [[Inicio]] · Historias: [[HU-001 Iniciar sesion con correo institucional]] · [[HU-003 Recuperar contrasena]] · [[HU-005 MFA para personal administrativo]]

## Wireframe — escritorio / móvil
```
┌──────────────────────────────────────┐
│          [Logo del colegio]          │
│        Colegio Virtual · Personal    │
│                                      │
│  Correo institucional                │
│  ┌────────────────────────────────┐  │
│  │ nombre@colegio-piloto.test          │  │
│  └────────────────────────────────┘  │
│  Contraseña                          │
│  ┌──────────────────────────┐ ┌───┐  │
│  │ ••••••••••               │ │ 👁 │  │
│  └──────────────────────────┘ └───┘  │
│                                      │
│  ┌────────────────────────────────┐  │
│  │           Ingresar             │  │
│  └────────────────────────────────┘  │
│        ¿Olvidaste tu contraseña?     │
│                                      │
│  ¿Eres estudiante? Usa la app  →     │
│  ¿Necesitas ayuda? Oficina de info.  │
└──────────────────────────────────────┘
```

## Paso MFA
```
┌──────────────────────────────────────┐
│   Verificación en dos pasos          │
│   Ingresa el código de 6 dígitos     │
│   de tu app autenticadora            │
│   ┌──┬──┬──┬──┬──┬──┐                │
│   │  │  │  │  │  │  │                │
│   └──┴──┴──┴──┴──┴──┘                │
│   [ Verificar ]                      │
│   Usar un código de respaldo         │
└──────────────────────────────────────┘
```

## Reglas de UX
- Campo de correo con `type=email` y autocompletado.
- Botón mostrar/ocultar contraseña.
- Errores junto al campo y anunciados a lectores de pantalla.
- Enlace visible a la app de estudiantes para evitar confusión ([[ADR-003 Separar acceso de personal y estudiantes]]).
- Sin imágenes pesadas: página < 200 KB ([[Requisitos no funcionales]]).
