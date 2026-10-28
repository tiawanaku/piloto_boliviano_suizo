---
tipo: arquitectura
tags: [arquitectura, stack, php, laravel, filament]
aliases: [Stack, Stack tecnico, Convenciones de codigo]
---
# Stack tecnológico

Volver a [[Vision de arquitectura]] · Decisión: [[ADR-005 Stack PHP Laravel y Filament]]

> Guía práctica para los [[Developers]]. El *por qué* de cada elección está en el ADR-005; aquí está el *qué* y el *cómo*.

## Componentes y versiones
| Capa | Componente | Versión | Notas |
|---|---|---|---|
| Lenguaje | PHP | 8.3+ (local 8.3.6) | Extensiones: `pdo_pgsql`, `pdo_sqlite`, `intl`, `mbstring`, `zip`, `sodium` |
| Framework | Laravel | 13.x (13.39.0) | Proyecto en `app-colegio/` |
| UI del personal | Filament | 5.x (5.11.0) | Paneles `admin` y `docente` |
| Componentes | Livewire / Alpine.js | 4.x / incluido | Vienen con Filament |
| Estilos | Tailwind CSS | 4.x | Solo para tema propio (Vite) |
| Base de datos | PostgreSQL | 16+ | Staging y producción |
| Base de datos (tests) | SQLite en memoria | — | Local; en CI también PostgreSQL |
| Sesiones / caché / colas | Driver `database` | — | Redis como mejora futura |
| Correo | SMTP institucional | — | `log` o Mailpit en desarrollo |
| Servidor | Nginx + PHP-FPM | 8.3 | Worker de colas + *cron* del *scheduler* |
| CI | GitHub Actions | — | `.github/workflows/app-colegio.yml` |

## Paquetes Composer
| Paquete | Restricción | Tipo | Para qué |
|---|---|---|---|
| `laravel/framework` | `^13.39` | prod | Framework |
| `filament/filament` | `^5.11` | prod | Paneles, formularios, tablas, MFA TOTP (`pragmarx/google2fa`, `chillerlan/php-qrcode`) |
| `spatie/laravel-permission` | `^8.3` | prod | Roles y permisos como datos |
| `pestphp/pest` | `^4.7` | dev | Pruebas (Pest 5 exige PHP 8.4) |
| `pestphp/pest-plugin-laravel` | `^4.1` | dev | Helpers de Laravel |
| `pestphp/pest-plugin-livewire` | `^4.1` | dev | Pruebas de páginas Filament |
| `larastan/larastan` | `^3.13` | dev | PHPStan 2 para Laravel |
| `laravel/pint` | `^1.32` | dev | Formato |
| `laravel/sanctum` | `^4.3` | — | Solo si la Fase 4 elige API (ver §9 de [[ADR-005 Stack PHP Laravel y Filament]]) |

Descartados (ver ADR): `bezhansalleh/filament-shield`, `spatie/laravel-activitylog` (PHP 8.4), `owen-it/laravel-auditing`.

## Comandos de calidad
Ejecutar desde `app-colegio/`. Todos deben pasar antes de abrir un PR ([[Definicion de Terminado]]).

```bash
vendor/bin/pint --test                      # formato (sin modificar); usar `vendor/bin/pint` para corregir
vendor/bin/phpstan analyse                  # Larastan nivel 6 (phpstan.neon)
vendor/bin/pest                             # suite completa (SQLite en memoria)
vendor/bin/pest --coverage --min=80         # cobertura (requiere pcov/xdebug; se mide en CI)
composer audit                              # vulnerabilidades en dependencias
```

Atajo sugerido en `composer.json`: `"scripts": { "quality": ["@php vendor/bin/pint --test", "@php vendor/bin/phpstan analyse", "@php vendor/bin/pest"] }` → `composer quality`.

## Convenciones de código

### Idioma
- **Código en inglés** (clases, métodos, tablas, columnas, rutas, permisos, nombres de pruebas técnicas): es el idioma de Laravel, Filament y su documentación, evita mezclar `getEstudiantes()` con `hasMany()` y facilita usar ejemplos y paquetes.
- **Textos de UI en español** siempre vía traducciones: `lang/es/*.php` con claves (`__('auth.account_inactive')`). Filament ya trae su traducción `es`. Nada de textos en español "quemados" en clases.
- Descripciones de pruebas Pest en español, copiando el escenario Gherkin: `it('muestra "Correo o contraseña incorrectos" sin revelar si el correo existe')`.
- Commits y PR en español; mensajes de commit en imperativo.

### Glosario dominio → código
| Dominio (vault) | Código |
|---|---|
| Usuario | `User` |
| Personal | `StaffMember` (perfil de `User`) |
| Estudiante | `Student` |
| Rol / Permiso | `Role` / `Permission` (spatie) |
| Sesión | tabla `sessions` |
| Evento de auditoría | `AuditEvent` |
| Gestión | `AcademicYear` |
| Periodo | `Term` |
| Nivel / Grado / Paralelo | `Level` / `Grade` / `Section` |
| Materia | `Subject` |
| Aula virtual | `VirtualClassroom` |
| Asignación docente | `TeacherAssignment` |
| Matrícula | `Enrollment` |

Roles (nombres técnicos): `director`, `academic_secretary`, `pedagogical_coordinator`, `it_support`, `information_office`, `teacher`, `student`. Etiquetas en español en `lang/es/roles.php`.

### Estructura y nombres
| Elemento | Convención | Ejemplo |
|---|---|---|
| Paneles | `app/Providers/Filament/{Admin,Docente}PanelProvider.php` | `AdminPanelProvider` |
| Resources | `app/Filament/{Admin,Docente}/Resources/<Modelos>/<Model>Resource.php` con subcarpetas `Pages/`, `Schemas/`, `Tables/`, `Actions/` (estructura de Filament 5) | `Admin/Resources/Users/UserResource.php`, `Users/Tables/UsersTable.php` |
| Páginas propias | `app/Filament/Pages/...` (compartidas) o `app/Filament/<Panel>/Pages` | `Pages/Auth/Login`, `Pages/ChangePassword`, `Pages/ActiveSessions` |
| Policies | `app/Policies/<Model>Policy` | `UserPolicy`, `AuditEventPolicy` |
| Lógica de negocio | `app/Actions/<Contexto>/<Verbo><Objeto>` (una acción = una clase invocable) | `Actions/Staff/InviteStaffMember` |
| Servicios | `app/Services/<Nombre>` | `Services/AccountLockout`, `Services/AuditLogger` |
| Eventos / Listeners | `app/Events`, `app/Listeners` | `RoleAssigned`, `RecordLoginAttempt` |
| Enums | `app/Enums` (backed enums) | `AccountStatus`, `AuditEventType` |
| Configuración propia | `config/colegio.php` | dominio institucional, umbrales de bloqueo, minutos de inactividad |
| Migraciones | `snake_case`, tablas en plural inglés, una migración por cambio; nunca editar una migración ya integrada en `main` | `2026_11_02_000001_add_lockout_columns_to_users_table.php` |
| Pruebas | `tests/Feature/<HU-xxx>/...Test.php` por historia, `tests/Unit/...` para servicios | `tests/Feature/HU001/LoginTest.php` |
| Ramas | `hu-001-login-correo`, `t-1-03-...` | — |

Reglas:
- Los Resources de Filament **no** contienen lógica de negocio: llaman a *Actions*. Así la lógica se reutiliza en una futura API (Fase 4) y se prueba sin UI.
- `declare(strict_types=1);` en todos los archivos PHP nuevos.
- Autorización siempre por *Policy* o `Gate`; nunca `if ($user->hasRole(...))` dispersos en vistas.
- Nada sensible en logs: contraseñas, tokens, secretos TOTP y códigos de recuperación se excluyen (`$hidden`, `context` de auditoría filtrado).

## Mapeo de historias de la Fase 1 a componentes
Incluye HU-001..HU-014 y las historias de Fase 1 que el PO añadió en la [[2026-10-28 Revision del Product Owner]]. El orden y el sprint de cada historia los define el PO en el [[Backlog del producto]].

| Historia | Componentes Laravel / Filament |
|---|---|
| [[HU-001 Iniciar sesion con correo institucional]] | `Pages/Auth/Login` (extiende el login de Filament), regla de dominio institucional, enum `AccountStatus`, hash `argon2id`, `LoginResponse` propio, `lang/es/auth.php`, *seeder* de cuentas de prueba |
| [[HU-002 Cerrar sesion]] | Logout de Filament, `SESSION_DRIVER=database`, `SESSION_LIFETIME` desde `config/colegio.php`, *middleware* `PreventBackHistory` (`Cache-Control: no-store`) |
| [[HU-003 Recuperar contrasena]] | `->passwordReset()` de Filament, *password broker* (`expire=30`), `RateLimiter` 3/hora, notificación en cola de confirmación, borrado de sesiones y desbloqueo al restablecer |
| [[HU-004 Bloqueo por intentos fallidos]] | Servicio `AccountLockout`, columnas `failed_login_attempts`/`locked_until`, notificación `AccountLockedNotification`, acción `UnlockAccount` en `UserResource` (`UserPolicy::unlock`) |
| [[HU-005 MFA para personal administrativo]] | MFA de app autenticadora de Filament con códigos de recuperación, `User` implementa las interfaces de MFA de Filament, exigencia por rol administrativo, códigos incorrectos suman en `AccountLockout` (HU-004), acción `ResetMfa` (`UserPolicy::resetMfa`) |
| [[HU-006 Cambio de contrasena en primer ingreso]] | Columnas `must_change_password`/`temporary_password_expires_at`, *middleware* `EnsurePasswordIsChanged`, página `Pages/ChangePassword`, regla `Password::min(10)->uncompromised()` |
| [[HU-007 Panel segun rol]] | `AdminPanelProvider`, `DocentePanelProvider`, `User::canAccessPanel()`, columna `primary_role`, `LoginResponse` propio, ítem del menú de usuario "Cambiar de panel", vista 403 en español + registro en auditoría |
| [[HU-008 Gestion de sesiones activas]] (reordenada por el PO para después de la Fase 1) | Página `Pages/ActiveSessions` (tabla sobre `sessions`), acciones "Cerrar" y "Cerrar todas las demás" |
| [[HU-029 Mi cuenta datos y cambio de contrasena]] (nueva, Sprint 2) | Página de perfil de Filament (`->profile()`) personalizada: datos, roles y estado MFA; cambio de contraseña con contraseña actual, misma regla de política y cierre de las demás sesiones |
| [[HU-030 Listado y ficha del personal]] (nueva, Sprint 3) | `Admin/Resources/UserResource` (lista con búsqueda/filtros, vista y edición) + `StaffMember`; CI único; cambio de correo solo con `UserPolicy::changeEmail` (Soporte TI) y auditado |
| [[HU-009 Invitar personal]] | `Admin/Resources/UserResource` (crear), modelo `StaffMember`, *Action* `InviteStaffMember`, notificación con enlace firmado de 72 h, página pública de activación |
| [[HU-010 Asignar roles al personal]] | Campo de roles en `UserResource` (spatie), `UserPolicy::assignRole` con regla de roles altos, evento `RoleAssigned`/`RoleRevoked` → auditoría |
| [[HU-011 Desactivar cuenta]] | Acciones `DeactivateAccount`/`ReactivateAccount` con motivo, borrado de sesiones del usuario, sin borrado físico (`UserPolicy::delete` siempre `false`) |
| [[HU-012 Carga masiva de personal]] | Importador CSV (`ImportAction` de Filament o *Action* propia con vista previa), reutiliza `InviteStaffMember`, envío en cola |
| [[HU-013 Registro de auditoria de accesos]] | Tabla `audit_events`, modelo inmutable `AuditEvent`, servicio `AuditLogger`, *listeners* de `Login`/`Failed`/`Logout`/`Lockout`, *trigger* PostgreSQL anti `UPDATE`/`DELETE` |
| [[HU-014 Consultar bitacora de auditoria]] | `Admin/Resources/AuditEventResource` de solo lectura, filtros (usuario, tipo, fechas), exportación CSV por *streaming* auditada, `AuditEventPolicy` (Dirección y Soporte TI) |

## Relacionado
- [[Flujo de autenticacion]] · [[Roles y permisos RBAC]] · [[Modelo de dominio]] · [[Seguridad y proteccion de datos]]
