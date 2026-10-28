---
tipo: diseno
tags: [ux, fase1]
---
# Panel por rol

Volver a [[Inicio]] · Historia: [[HU-007 Panel segun rol]] · Permisos: [[Roles y permisos RBAC]]

| Rol | Contenido del panel (Fase 1) | Crece en |
|---|---|---|
| Dirección | Accesos a personal ([[HU-030 Listado y ficha del personal]]) y bitácora ([[HU-014 Consultar bitacora de auditoria]]) | Resumen de indicadores: idea en el parking lot del backlog |
| Secretaría académica | Personal (listado, invitar, desactivar) | Fase 3: estudiantes, tutores y matrícula |
| Coordinación pedagógica | Mensaje "estructura académica disponible próximamente" | Fase 2–3: estructura, aulas, asignaciones |
| Soporte TI | Cuentas bloqueadas, restablecer MFA, auditoría | — |
| Oficina de información | Bienvenida y datos de contacto institucional (sin búsqueda) | Fase 5: búsqueda básica ([[HU-027 Consulta rapida para oficina de informacion]]) |
| Docente | "Mis aulas" (vacío con mensaje hasta Fase 3) | [[HU-022 Docente ve sus aulas asignadas]] |

## Elementos comunes
- Barra superior: nombre, rol actual, **selector de rol** (si tiene varios), menú "Mi cuenta" (datos y contraseña — [[HU-029 Mi cuenta datos y cambio de contrasena]]; MFA; sesiones — [[HU-008 Gestion de sesiones activas]]), "Cerrar sesión".
- Menú lateral generado según permisos del rol activo.
