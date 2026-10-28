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
**Opción B.** MFA **obligatorio** para roles administrativos y **opcional** para docentes en la Fase 1. Evaluar SSO (opción C) como mejora futura.

## Consecuencias
- Requiere correos institucionales para todo el personal (supuesto en [[Riesgos y supuestos]]).
- Flujo de restablecimiento de MFA por Soporte TI ([[HU-005 MFA para personal administrativo]]).
- Revisar en la review del Sprint 2 si MFA pasa a ser obligatorio para docentes.
