---
tipo: epica
id: EP-01
tags: [epica, fase1, autenticacion]
estado: lista
fase: 1
prioridad: alta
---
# EP-01 · Login del plantel administrativo y docentes

Volver a [[Backlog del producto]] · Fase: [[Fases y roadmap#Fase 1 — Acceso del personal (en curso)|Fase 1]]

## Descripción
Como colegio 100 % virtual, la **puerta de entrada** es el login. El personal (administrativo y docente) debe poder ingresar de forma **segura, simple y confiable** a un portal web que lo lleve a su panel según su rol. Es la base de todo lo demás: sin identidad no hay aulas, asignaciones ni app de estudiantes.

## Hipótesis de valor
> Si el personal puede ingresar por sí mismo de forma segura, se reduce la dependencia de soporte TI y se protege la información de estudiantes desde el primer día.

## Alcance
**Incluye**
- Login con correo institucional + contraseña.
- Cierre de sesión y expiración por inactividad.
- Cambio obligatorio de contraseña temporal.
- Redirección al panel según rol.
- Recuperación de contraseña por correo.
- Bloqueo temporal por intentos fallidos.
- MFA (TOTP) obligatorio para roles administrativos.
- Ver y cerrar sesiones activas.
- Ver mis datos de cuenta y cambiar mi contraseña.

**No incluye**
- Login de estudiantes → [[EP-06 App de estudiantes]] ([[ADR-003 Separar acceso de personal y estudiantes]]).
- Creación de cuentas por administradores → [[EP-02 Gestion de usuarios y roles]].
- SSO con proveedores externos → idea en el parking lot.

## Historias
| ID | Historia | Pts | Sprint |
|---|---|---|---|
| [[HU-001 Iniciar sesion con correo institucional]] | Login con correo | 5 | S1 |
| [[HU-002 Cerrar sesion]] | Logout + expiración | 1 | S1 |
| [[HU-006 Cambio de contrasena en primer ingreso]] | Contraseña temporal | 3 | S1 |
| [[HU-007 Panel segun rol]] | Panel por rol | 5 | S1 |
| [[HU-003 Recuperar contrasena]] | Recuperación | 5 | S2 |
| [[HU-004 Bloqueo por intentos fallidos]] | Bloqueo | 3 | S2 |
| [[HU-005 MFA para personal administrativo]] | MFA | 8 | S2 |
| [[HU-029 Mi cuenta datos y cambio de contrasena]] | Mi cuenta y cambio de contraseña | 3 | S2 |
| [[HU-008 Gestion de sesiones activas]] | Sesiones | 5 | — (primera tras la Fase 1) |
| **Total** | | **38** | 33 en S1–S2 |

## Diseño y técnica
- Pantalla: [[Pantalla login personal]] · [[Panel por rol]]
- Flujo: [[Flujo de autenticacion]]
- Decisión: [[ADR-002 Autenticacion con correo institucional y MFA]]
- Permisos: [[Roles y permisos RBAC]]

## Criterio de éxito de la épica
- ≥ 90 % del personal piloto ingresa sin ayuda en su primer intento.
- 0 cuentas administrativas sin MFA activado al cierre de la Fase 1.

> Revisión del PO 2026-10-28: se agrega HU-029 y HU-008 sale del Sprint 2 por capacidad ([[2026-10-28 Revision del Product Owner]]).
