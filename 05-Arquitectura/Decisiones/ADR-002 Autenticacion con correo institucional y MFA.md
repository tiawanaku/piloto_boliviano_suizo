---
tipo: adr
id: ADR-002
estado: propuesta
fecha: 2026-10-28
tags: [adr, autenticacion, seguridad]
---
# ADR-002 · Autenticación del personal con correo institucional y MFA

Volver a [[Vision de arquitectura]] · Épica: [[EP-01 Login plantel administrativo y docentes]]

## Contexto
El personal necesita acceder a datos sensibles (estudiantes menores). No debe existir auto-registro. Se requiere un identificador único y confiable.

## Opciones consideradas
| Opción | Pros | Contras |
|---|---|---|
| A. Usuario + contraseña propios | Simple | Identificadores inconsistentes |
| **B. Correo institucional + contraseña + MFA (TOTP) para administrativos** | Identificador único, recuperación vía correo, seguridad alta donde importa | Requiere dominio y correos institucionales |
| C. SSO con el proveedor de correo institucional | Sin contraseñas propias | Dependencia de proveedor; más complejo para la Fase 1 |

## Decisión (propuesta)
**Opción B.** MFA **obligatorio** para roles administrativos. Para docentes, **sin MFA en la Fase 1**: si se exige, se decide más adelante (pendiente de la dirección, [[2026-10-28 Decisiones de la direccion]]). Evaluar SSO (opción C) como mejora futura.

## Consecuencias
- Requiere correos institucionales para todo el personal (supuesto en [[Riesgos y supuestos]]).
- Flujo de restablecimiento de MFA por Soporte TI ([[HU-005 MFA para personal administrativo]]).
- MFA para docentes: decisión pendiente de la dirección, fuera de la Fase 1.
