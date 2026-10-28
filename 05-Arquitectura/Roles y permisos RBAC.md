---
tipo: arquitectura
tags: [arquitectura, seguridad, rbac]
aliases: [RBAC, Matriz de permisos, Roles]
---
# Roles y permisos (RBAC)

Volver a [[Vision de arquitectura]] · Decisión: [[ADR-004 Control de acceso basado en roles]]

> Borrador para validar con dirección en el [[Sprint 0 - Preparacion]].

## Roles
| Rol | Grupo | Descripción | MFA |
|---|---|---|---|
| Dirección | Administrativo | Máxima autoridad académica y administrativa | Obligatorio |
| Secretaría académica | Administrativo | Personal, matrícula, estructura | Obligatorio |
| Coordinación pedagógica | Administrativo | Materias, asignaciones docentes, seguimiento | Obligatorio |
| Soporte TI | Administrativo | Cuentas, seguridad, auditoría | Obligatorio |
| Oficina de información | Administrativo | Consulta básica y atención al público | Obligatorio |
| Docente | Docente | Sus aulas y materias asignadas | No en Fase 1 (pendiente) |
| Estudiante | Estudiante | Su aula y materias (solo vía app) | No aplica (Fase 4) |
| Tutor | Tutor | Consulta de sus hijos ([[EP-09 Acceso de tutores]]) | Por definir (Fase 4) |

Una persona puede tener **varios roles** (p. ej. Docente + Coordinación).

## Matriz de permisos (Fase 1–3)
| Permiso | Dir. | Secr. | Coord. | TI | Ofic. | Doc. |
|---|:-:|:-:|:-:|:-:|:-:|:-:|
| Iniciar sesión en portal del personal | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ |
| Invitar personal | ✅ | ✅ | — | ✅ | — | — |
| Asignar roles administrativos altos (Dir./TI) | ✅ | — | — | ✅ | — | — |
| Asignar roles Docente/Coord./Ofic. | ✅ | ✅ | — | ✅ | — | — |
| Desactivar cuentas | ✅ | ✅ | — | ✅ | — | — |
| Desbloquear cuenta / restablecer MFA | — | — | — | ✅ | — | — |
| Ver bitácora de auditoría | ✅ | — | — | ✅ | — | — |
| Gestionar gestión/niveles/grados/paralelos | ✅ | ✅ | ✅ | — | — | — |
| Catálogo de materias | ✅ | — | ✅ | — | — | — |
| Crear aulas virtuales | ✅ | — | ✅ | — | — | — |
| Asignar materias y docentes a aulas | ✅ | — | ✅ | — | — | — |
| Ver y corregir la ficha del personal (correo institucional: solo TI) | ✅ | ✅ | — | ✅ | — | — |
| Registrar estudiantes y tutores | ✅ | ✅ | — | — | — | — |
| Matricular estudiantes | ✅ | ✅ | — | — | — | — |
| Generar / restablecer credenciales de estudiantes | ✅ | ✅ | — | — | — | — |
| Ver datos básicos de estudiantes/docentes | ✅ | ✅ | ✅ | — | ✅ | — |
| Ver sus aulas y estudiantes asignados (sin datos del tutor, salvo decisión de dirección) | — | — | — | — | — | ✅ |
| Gestionar sus propias sesiones / contraseña | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ |

## Principios
- **Mínimo privilegio** y **denegar por defecto**.
- Verificación en el servidor en cada solicitud ([[HU-007 Panel segun rol]]).
- Separación de funciones: quien asigna roles altos no debería ser el único que audita.
- Todo cambio de rol se audita ([[HU-010 Asignar roles al personal]]).
