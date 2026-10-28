---
tipo: diseno
tags: [ux, fase1]
---
# Panel por rol

Volver a [[Inicio]] · Historia: [[HU-007 Panel segun rol]] · Permisos: [[Roles y permisos RBAC]]

| Rol | Contenido del panel (Fase 1) | Crece en |
|---|---|---|
| Dirección | Resumen: personal activo, accesos recientes, alertas de seguridad | Fase 2–3: indicadores académicos |
| Secretaría académica | Personal (invitar, desactivar) | Fase 3: matrícula |
| Coordinación pedagógica | Mensaje "estructura académica disponible próximamente" | Fase 2–3: estructura, aulas, asignaciones |
| Soporte TI | Cuentas bloqueadas, restablecer MFA, auditoría | — |
| Oficina de información | Búsqueda básica | Fase 5 |
| Docente | "Mis aulas" (vacío con mensaje hasta Fase 3) | [[HU-022 Docente ve sus aulas asignadas]] |

## Elementos comunes
- Barra superior: nombre, rol actual, **selector de rol** (si tiene varios), menú "Mi cuenta" (contraseña, MFA, sesiones), "Cerrar sesión".
- Menú lateral generado según permisos del rol activo.
