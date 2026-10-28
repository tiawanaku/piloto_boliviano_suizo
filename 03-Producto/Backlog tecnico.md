---
tipo: backlog
tags: [producto, backlog, tecnico]
aliases: [Backlog técnico, Habilitadores técnicos, TEC]
---
# 🛠️ Backlog técnico (habilitadores)

Volver a [[Backlog del producto]] · Stack: [[ADR-005 Stack PHP Laravel y Filament]] · [[Stack tecnologico]] · Paquetes: [[Paquetes MOC]]

> Elementos **técnicos habilitadores** que no son historias de usuario pero que las historias necesitan para poder cumplir la [[Definicion de Terminado]]. Los propone el [[Scrum Master]] con los [[Developers]]. **No cambian el orden ni el alcance** del [[Backlog del producto]] del [[Product Owner]]: se planifican en el mismo sprint que la primera historia que los necesita y se descomponen en tareas `T-<sprint>-<nn>` en cada nota de sprint.

## Lista
| ID | Elemento | Descripción | Habilita | Sprint | Dev | Estado |
|---|---|---|---|---|---|---|
| TEC-01 | Proyecto Laravel 13 base | `app-colegio/` creado con Laravel 13, Filament 5, Pest 4, Larastan y Pint como dependencias; idioma `es`, zona `America/La_Paz`, `config/colegio.php` | Todas | [[Sprint 0 - Preparacion\|S0]] | Dev 1 | por hacer |
| TEC-02 | Entorno local reproducible | `compose.yaml` con PostgreSQL 16 y Mailpit; `.env.example` completo | Todas | S0 | Dev 3 | por hacer |
| TEC-03 | Herramientas de calidad | `phpunit.xml` (SQLite en memoria), `tests/Pest.php`, `phpstan.neon` (nivel 6), `pint.json`, `composer quality` | DoD de todas | S0 | Dev 2 | por hacer |
| TEC-04 | Integración continua | GitHub Actions: Pint, PHPStan, Pest (SQLite y PostgreSQL), cobertura ≥ 80 %, `composer audit`; plantilla de PR con la DoD | DoD de todas | S0 | Dev 2 | por hacer |
| TEC-05 | Paneles Filament | Paneles `admin` (`/admin`) y `docente` (`/docente`) con login de Filament por defecto y marca del colegio | [[HU-001 Iniciar sesion con correo institucional\|HU-001]], [[HU-007 Panel segun rol\|HU-007]] | S0 | Dev 1 | por hacer |
| TEC-06 | Identidad base | `User` con UUID, estado de cuenta (`AccountStatus`), hash Argon2id, sesiones en base de datos con `user_id` UUID | HU-001, [[HU-002 Cerrar sesion\|HU-002]], [[HU-008 Gestion de sesiones activas\|HU-008]] | S0 | Dev 1 | por hacer |
| TEC-07 | Localización al español | `lang/es` (`auth`, `passwords`, `validation`, `pagination`), traducción `es` de Filament | Todas (DoD: mensajes en español claro) | S0 | Dev 1 | por hacer |
| TEC-08 | Correo y colas | Cola y caché `database`, Mailpit en desarrollo, plantilla de correo en español, comando de correo de prueba | [[HU-003 Recuperar contrasena\|HU-003]], [[HU-004 Bloqueo por intentos fallidos\|HU-004]], [[HU-009 Invitar personal\|HU-009]], [[HU-029 Mi cuenta datos y cambio de contrasena\|HU-029]] | S0 | Dev 3 | por hacer |
| TEC-09 | Staging con despliegue automático | Servidor Nginx + PHP-FPM 8.3 + PostgreSQL 16 con HTTPS, worker de colas, *cron*; despliegue al integrar en `main`; SMTP institucional | DoD (desplegado en staging) | S0 | Dev 3 | por hacer |
| TEC-10 | Roles y permisos | `spatie/laravel-permission` con UUID, enums `StaffRole` y `Permission`, *seeder* de la matriz [[Roles y permisos RBAC]] | HU-007, [[HU-010 Asignar roles al personal\|HU-010]], [[HU-014 Consultar bitacora de auditoria\|HU-014]] | [[Sprint 1 - Login base\|S1]] | Dev 2 | por hacer |
| TEC-11 | Cuentas semilla y datos de prueba | *Factories* por estado y rol, comando `colegio:crear-cuenta` (contraseña temporal), *helpers* de Pest `actingAsStaff()` | HU-001, [[HU-006 Cambio de contrasena en primer ingreso\|HU-006]], HU-007 (temporal hasta HU-009) | S1 | Dev 2 | por hacer |
| TEC-12 | Auditoría base | Tabla `audit_events`, modelo inmutable, servicio `AuditLogger`, *trigger* PostgreSQL anti `UPDATE`/`DELETE` | [[HU-013 Registro de auditoria de accesos\|HU-013]] y toda acción sensible (DoD) | S1 | Dev 3 | por hacer |
| TEC-13 | Cabeceras de seguridad | HSTS, `X-Frame-Options`, `X-Content-Type-Options`, `Referrer-Policy`, CSP (primero en modo informe), `Cache-Control: no-store` en paneles | HU-002, [[Seguridad y proteccion de datos]] | S1 | Dev 1 | por hacer |
| TEC-14 | Spike: peso del login en 3G | Medir `/admin/login` (meta < 200 KB, < 10 s en 3G) y proponer optimizaciones | HU-001, [[Requisitos no funcionales]] | S1 | Dev 3 | por hacer |
| TEC-15 | Spike: MFA por rol en Filament 5 | Confirmar cómo exigir MFA por rol (no solo por panel), 10 códigos de recuperación y conteo de códigos fallidos para el bloqueo | [[HU-005 MFA para personal administrativo\|HU-005]] | S1 | Dev 3 | por hacer |
| TEC-16 | Respaldos y monitoreo de staging | Respaldo diario de PostgreSQL con restauración probada, rotación de logs y alerta de errores | [[Requisitos no funcionales]] (respaldo) | [[Sprint 2 - Seguridad del login\|S2]] | Dev 2 | por hacer |
| TEC-17 | Tareas programadas y retención | *Scheduler*: limpieza de tokens de restablecimiento e invitaciones vencidas, sesiones expiradas y retención de auditoría a 1 año | HU-003, HU-009, HU-013, HU-014 | [[Sprint 3 - Gestion de personal\|S3]] | Dev 3 | por hacer |

**Total:** 17 elementos (S0: 9 · S1: 6 · S2: 1 · S3: 1).

## Propuestas al Product Owner (no aplicadas)
- **HU-008 sin "ubicación aproximada" en la Fase 1:** mostrar IP y navegador; la geolocalización por IP requiere un servicio externo y tratamiento adicional de datos personales.
- **Sprint 3 con capacidad reducida** (9 días hábiles por el feriado del 25/12): mantener la previsión de 18 pts con [[HU-014 Consultar bitacora de auditoria]] como primera en salir, tal como ya decidió el PO. Ver [[2026-10-28 Sprint Planning tecnico - Scrum Master]].

## Relacionado
- Tareas por sprint: [[Sprint 0 - Preparacion#Tareas técnicas]] · [[Sprint 1 - Login base#Tareas técnicas]] · [[Sprint 2 - Seguridad del login#Tareas técnicas]] · [[Sprint 3 - Gestion de personal#Tareas técnicas]]
