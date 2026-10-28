---
tipo: arquitectura
tags: [arquitectura, seguridad, privacidad]
---
# Seguridad y protección de datos

Volver a [[Vision de arquitectura]]

## Por qué es crítico
Un colegio virtual concentra **datos de menores de edad** y toda su operación ocurre en línea: una cuenta comprometida equivale a "entrar al colegio".

## Política de contraseñas
- Mínimo **10 caracteres**; se permiten frases de contraseña.
- Rechazar contraseñas comunes o filtradas conocidas.
- Sin reglas de composición forzada ni expiración periódica arbitraria (enfoque NIST SP 800-63B); cambio obligatorio ante sospecha de compromiso.
- Hash con Argon2id (o bcrypt) y sal única.

## Controles de la Fase 1
| Control | Historia |
|---|---|
| Mensajes genéricos de error | [[HU-001 Iniciar sesion con correo institucional]] |
| Expiración de sesión | [[HU-002 Cerrar sesion]] |
| Recuperación segura con token de un uso | [[HU-003 Recuperar contrasena]] |
| Bloqueo por fuerza bruta | [[HU-004 Bloqueo por intentos fallidos]] |
| MFA para administrativos | [[HU-005 MFA para personal administrativo]] |
| Contraseña temporal obligatoria de cambiar | [[HU-006 Cambio de contrasena en primer ingreso]] |
| Autorización en servidor | [[HU-007 Panel segun rol]] |
| Control de sesiones | [[HU-008 Gestion de sesiones activas]] |
| Auditoría | [[HU-013 Registro de auditoria de accesos]] |

## Buenas prácticas generales
- HTTPS en todo; cabeceras de seguridad (HSTS, CSP).
- Protección CSRF; validación de entradas; consultas parametrizadas.
- Secretos fuera del código (variables de entorno / gestor de secretos).
- Dependencias revisadas automáticamente.
- Referencia: OWASP Top 10 y OWASP ASVS (nivel 2).

## Privacidad
- Recolectar el **mínimo** de datos necesarios.
- Acceso a datos de estudiantes solo por roles con necesidad ([[Roles y permisos RBAC]]).
- Informar a familias qué datos se guardan y para qué.
- Revisar obligaciones legales vigentes en Bolivia ([[Marco normativo Bolivia]]).
