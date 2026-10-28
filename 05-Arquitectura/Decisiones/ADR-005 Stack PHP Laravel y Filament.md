---
tipo: adr
id: ADR-005
estado: aceptada
fecha: 2026-10-28
tags: [adr, arquitectura, stack, php, laravel, filament]
aliases: [Decision de stack, ADR stack]
---
# ADR-005 · Stack tecnológico: PHP 8.3 + Laravel 13 + Filament 5

Volver a [[Vision de arquitectura]] · Resumen práctico: [[Stack tecnologico]] · Sprint: [[Sprint 0 - Preparacion]]

> Facilitado por el [[Scrum Master]] con los [[Developers]]. Las versiones se verificaron en Packagist y en el entorno local el **2026-10-28**. Los puntos marcados como **(spike)** se confirman con una prueba técnica corta antes de implementar la historia correspondiente.

## Contexto
- El colegio decidió que el **backend y el frontend del portal del personal** se construyan en **PHP con Filament** (paneles de administración sobre Laravel).
- La Fase 1 ([[EP-01 Login plantel administrativo y docentes]], [[EP-02 Gestion de usuarios y roles]], [[EP-08 Seguridad y auditoria]]) es casi toda identidad y seguridad: login con correo institucional, MFA TOTP, bloqueo, sesiones, RBAC y auditoría ([[ADR-002 Autenticacion con correo institucional y MFA]], [[ADR-004 Control de acceso basado en roles]]).
- Requisitos no funcionales relevantes: interfaz en español, redes lentas (3G), WCAG 2.1 AA, trazabilidad de 1 año ([[Requisitos no funcionales]]).
- Entorno verificado: PHP **8.3.6** con `pdo_pgsql`, `pdo_mysql`, `pdo_sqlite`, `intl`, `mbstring`, `zip`, `gd`, `sodium`, `redis`; Argon2id disponible; Composer instalado; **sin** `pcov`/`xdebug` (la cobertura se mide en CI).

### Versiones verificadas (Packagist, 2026-10-28)
| Paquete | Versión estable | Requiere PHP | Nota |
|---|---|---|---|
| `laravel/framework` | 13.39.0 | ^8.3 | Fija el mínimo de PHP del proyecto |
| `filament/filament` | 5.11.0 | ^8.2 | Trae Livewire ^4.4, `pragmarx/google2fa`, `chillerlan/php-qrcode` |
| `spatie/laravel-permission` | 8.3.2 | ^8.3 | Compatible con Laravel 12/13 |
| `bezhansalleh/filament-shield` | 4.3.1 | ^8.2 | Compatible con Filament 4/5 (evaluado, **no** adoptado) |
| `pestphp/pest` | 4.7.8 (la 5.x exige PHP ^8.4) | ^8.3 | Usamos **Pest 4** mientras el servidor sea PHP 8.3 |
| `pestphp/pest-plugin-laravel` / `-livewire` | 4.1.0 / 4.1.0 | ^8.3 | Pruebas de páginas Filament (Livewire) |
| `larastan/larastan` | 3.13.2 (PHPStan 2.x) | ^8.2 | Compatible con Laravel 13 |
| `laravel/pint` | 1.32.1 | ^8.3 | Formato de código |
| `owen-it/laravel-auditing` | 14.0.6 | ^8.2 | Evaluado, **no** adoptado |
| `spatie/laravel-activitylog` | 5.1.3 | **^8.4** | Descartado: incompatible con PHP 8.3 |
| `laravel/sanctum` | 4.3.3 | ^8.2 | Reservado para la API de la Fase 4 si se elige |

## Decisión

### 1. Lenguaje, framework y versiones
- **PHP 8.3** como mínimo (`"php": "^8.3"`), en desarrollo, CI y servidores. Migrar a PHP 8.4 es una mejora planificada (permite Pest 5), no un requisito de la Fase 1.
- **Laravel 13** (`laravel/framework:^13.39`).
- **Filament 5** (`filament/filament:^5.11`) para el portal del personal, que incluye:
  - **Livewire 4** (componentes del lado del servidor; sin SPA propia ni API para el portal).
  - **Alpine.js** (interactividad ligera, incluida por Livewire).
  - **Tailwind CSS 4** (tema propio del colegio vía Vite, solo si hace falta personalizar; por defecto el tema de Filament).
  - Heroicons y componentes accesibles de formularios, tablas, acciones y notificaciones.
- Zona horaria `America/La_Paz`, `APP_LOCALE=es`, `APP_FALLBACK_LOCALE=en`.

### 2. Base de datos
- **PostgreSQL 16 o superior** en staging y producción.
  - Motivo principal: la bitácora de auditoría debe ser **inmutable** ([[HU-013 Registro de auditoria de accesos]]). PostgreSQL permite reforzarlo en la base de datos con un *trigger* que rechaza `UPDATE`/`DELETE` y con permisos por rol de base de datos, además de tipos `jsonb` (contexto del evento) e `inet` (IP) indexables.
  - DDL transaccional (migraciones que fallan no dejan el esquema a medias), índices parciales (p. ej. usuarios activos), buen soporte de UUID.
  - Libre, sin licencias, disponible en cualquier VPS o servicio administrado.
- **SQLite en memoria** para la suite de pruebas local (rápida). En CI se ejecuta además la suite completa contra **PostgreSQL** (servicio de GitHub Actions) para detectar diferencias de dialecto y probar el *trigger* de auditoría.
- MySQL 8 queda como alternativa aceptable si el hosting lo impusiera; el código no usará SQL específico salvo en migraciones aisladas (el *trigger*).
- Identificadores: **UUID** (`HasUuids` de Eloquent, ordenables por tiempo) para `users` y entidades de dominio, como pide el [[Modelo de dominio]]. Implica usar `foreignUuid('user_id')` en la tabla `sessions` y configurar `spatie/laravel-permission` con clave morfológica UUID.

### 3. Paneles Filament
| Panel | Ruta | Para quién | MFA |
|---|---|---|---|
| `admin` | `/admin` | Dirección, Secretaría académica, Coordinación pedagógica, Soporte TI, Oficina de información | **Obligatorio** |
| `docente` | `/docente` | Docentes | Opcional en Fase 1 ([[ADR-002 Autenticacion con correo institucional y MFA]]) |
| `estudiante` | — | Fase 4, ver §9 | — |

- Ambos paneles usan el **mismo guard `web`** y la **misma sesión**: iniciar sesión una vez da acceso a todos los paneles que el usuario puede usar.
- **Un solo login** del personal (página de login personalizada, §4). El panel `admin` es el panel por defecto; `docente` reutiliza la misma página de login.
- **Acceso al panel**: el modelo `User` implementa `FilamentUser::canAccessPanel(Panel $panel)`:
  - `admin` → el usuario tiene al menos un rol administrativo **y** su cuenta está activa.
  - `docente` → el usuario tiene el rol Docente **y** su cuenta está activa.
  - Si devuelve `false`, Filament responde **403**; la vista 403 se personaliza con "No tienes permiso para ver esta página" y el intento se registra en auditoría mediante el manejador de excepciones (`withExceptions` en `bootstrap/app.php`).
- **Rol principal y cambio de rol ([[HU-007 Panel segun rol]])**:
  - Columna `users.primary_role` (nombre de rol). Si está vacía, prioridad por defecto: rol administrativo de mayor jerarquía, luego Docente.
  - Tras el login, una implementación propia del contrato `LoginResponse` de Filament redirige al panel del rol principal.
  - Un elemento del **menú de usuario** ("Cambiar a panel docente" / "Cambiar a panel administrativo") aparece solo si `canAccessPanel()` es verdadero para el otro panel. Como la sesión es compartida, el cambio no pide volver a iniciar sesión.
  - Dentro del panel `admin`, cada rol administrativo ve solo los *Resources*/páginas que sus permisos autorizan (§5). No se crea un panel por rol administrativo: cinco paneles casi iguales multiplicarían mantenimiento sin aportar seguridad (la seguridad está en las *Policies*).
- El panel `docente` muestra en la Fase 1 un *dashboard* vacío con mensaje explicativo; sus Resources llegan en la Fase 3 ([[EP-05 Asignacion de cursos y materias]]).

### 4. Autenticación
| Necesidad | Solución | Historia |
|---|---|---|
| Login con correo institucional | Página `App\Filament\Pages\Auth\Login` que extiende el login de Filament: validación de dominio (`config('colegio.dominio_institucional')`), mensajes en español, mensaje genérico ante credenciales incorrectas, verificación de estado de cuenta (`pending`/`active`/`locked`/`deactivated`), mostrar/ocultar contraseña | [[HU-001 Iniciar sesion con correo institucional]] |
| Hash de contraseñas | `HASH_DRIVER=argon2id` (verificado disponible en el PHP local) | HU-001 |
| Política de contraseñas | `Password::min(10)->uncompromised()` + lista local de contraseñas comunes como respaldo si no hay red; sin reglas de composición ([[Seguridad y proteccion de datos#Política de contraseñas]]) | [[HU-006 Cambio de contrasena en primer ingreso]] |
| Contraseña temporal | Columnas `must_change_password` y `temporary_password_expires_at` (72 h); *middleware* de panel que redirige a una página Filament "Cambiar contraseña" antes de cualquier otra | HU-006 |
| Cierre de sesión e inactividad | Logout de Filament (invalida y regenera la sesión). `SESSION_DRIVER=database`, `SESSION_LIFETIME=30` (inactividad, configurable por TI vía configuración), cookies `HttpOnly`, `Secure`, `SameSite=Lax`; *middleware* `Cache-Control: no-store` en los paneles para que "atrás" no muestre datos | [[HU-002 Cerrar sesion]] |
| Recuperación de contraseña | `->passwordReset()` de Filament con el *password broker* de Laravel: token de un uso, `expire = 30` min, respuesta idéntica exista o no el correo, límite 3 solicitudes/hora por correo e IP (`RateLimiter`). Al restablecer: se borran las demás sesiones del usuario, se desbloquea la cuenta y se envía correo de confirmación | [[HU-003 Recuperar contrasena]] |
| Bloqueo por intentos fallidos | Filament ya limita intentos por IP en el formulario; además un servicio propio `AccountLockout` con columnas `failed_login_attempts`, `last_failed_login_at`, `locked_until` (5 fallos en 15 min → 15 min de bloqueo, umbrales en `config/colegio.php`), notificación por correo al titular y acción "Desbloquear" para Soporte TI | [[HU-004 Bloqueo por intentos fallidos]] |
| MFA (TOTP) | **MFA nativo de Filament** con app autenticadora (`pragmarx/google2fa` + QR con `chillerlan/php-qrcode`), con **códigos de recuperación** (configurar 10). Obligatorio para usuarios con rol administrativo, opcional para Docente. Acción "Restablecer MFA" para Soporte TI (borra secreto y códigos; queda auditada). **(spike)**: confirmar en Sprint 2 cómo exigir MFA por rol y no solo por panel, y la cantidad de códigos | [[HU-005 MFA para personal administrativo]] |
| Sesiones activas | Tabla `sessions` de Laravel (`user_id`, `ip_address`, `user_agent`, `last_activity`) mostrada en una página Filament "Mi cuenta > Sesiones"; cerrar una o todas las demás = borrar filas. La "ubicación aproximada" requiere GeoIP: se propone al PO mostrar solo IP y navegador en Fase 1 | [[HU-008 Gestion de sesiones activas]] |

- La pantalla de login debe cumplir el presupuesto de < 200 KB ([[Requisitos no funcionales]]). **(spike)** medir el peso real del login de Filament en Sprint 1 y aplicar compresión/caché de recursos si se excede.
- No hay auto-registro (no se habilita `->registration()`).

### 5. Autorización
**Decisión: `spatie/laravel-permission` + *Policies* de Laravel escritas a mano. No se adopta `bezhansalleh/filament-shield`.**

- Roles y permisos como **datos** (tablas de spatie), cargados por un *seeder* que replica la matriz de [[Roles y permisos RBAC]], cumpliendo [[ADR-004 Control de acceso basado en roles]].
- Permisos **funcionales** en español de negocio pero con nombres técnicos en inglés y estilo `recurso.accion` (p. ej. `staff.invite`, `roles.assign_high`, `accounts.deactivate`, `accounts.unlock`, `mfa.reset`, `audit.view`).
- Cada Resource de Filament tiene su *Policy* (`UserPolicy`, `AuditEventPolicy`…); Filament la aplica automáticamente a listar/ver/crear/editar/borrar. Las acciones especiales (desbloquear, restablecer MFA, desactivar) llaman a métodos de la *Policy* (`unlock`, `resetMfa`, `deactivate`).
- Reglas de pertenencia ("docente solo ve *sus* aulas") se resuelven en la *Policy* y en el *query* del Resource (`modifyQueryUsing`/`getEloquentQuery`), nunca solo ocultando menús.
- **Por qué no Shield:** genera permisos CRUD por Resource (`view_any_user`, `update_user`…) que no coinciden con la matriz funcional del colegio; su UI de roles no resuelve la restricción de [[HU-010 Asignar roles al personal]] (Secretaría no puede asignar Dirección/TI); añade Policies generadas y una dependencia más que debe seguir el ritmo de versiones de Filament. Si en el futuro se necesita editar permisos desde la UI, se reevalúa.
- Prueba obligatoria por historia: un rol **sin** acceso recibe 403 (ver [[Definicion de Terminado]]).

### 6. Auditoría
**Decisión: tabla propia `audit_events` (append-only) + servicio `AuditLogger`. No se adopta un paquete.**

- Los eventos de la Fase 1 son mayoritariamente de **autenticación** (login exitoso/fallido, bloqueo, logout, MFA, acceso denegado), no cambios de modelos; los paquetes evaluados están orientados a diferencias de modelos Eloquent.
  - `spatie/laravel-activitylog` 5 exige PHP 8.4 → descartado.
  - `owen-it/laravel-auditing` 14 encaja para cambios de modelos, pero su esquema no cubre bien intentos fallidos sin usuario ni la inmutabilidad requerida.
- Columnas: `id` (UUID), `occurred_at`, `event_type`, `actor_id` (nullable), `subject_type`/`subject_id` (nullable), `email_attempted` (nullable), `result`, `ip_address`, `user_agent`, `context` (`jsonb`, **sin** contraseñas, tokens ni secretos).
- Fuentes: *listeners* de eventos de Laravel (`Login`, `Failed`, `Logout`, `Lockout`, `PasswordReset`), eventos propios de dominio (`RoleAssigned`, `AccountDeactivated`, `MfaReset`, `AccountUnlocked`…) y el manejador de 403.
- **Inmutabilidad** en tres capas: el modelo `AuditEvent` lanza excepción en `updating`/`deleting`; la *Policy* niega `update`/`delete`; en PostgreSQL un *trigger* rechaza `UPDATE`/`DELETE`. Retención 1 año mediante un comando programado que solo puede ejecutar el usuario de mantenimiento de base de datos.
- Consulta ([[HU-014 Consultar bitacora de auditoria]]): `AuditEventResource` de solo lectura con filtros (usuario, tipo, rango de fechas), orden descendente y acción de exportación a CSV por *streaming* que a su vez registra un evento `audit.exported`.
- Si en fases futuras se necesitan diffs de cambios de modelos académicos, se reevaluará `owen-it/laravel-auditing` en un ADR nuevo.

### 7. Calidad y CI
- **Pest 4** + `pest-plugin-laravel` + `pest-plugin-livewire` (pruebas de páginas, formularios y acciones de Filament). Los escenarios Gherkin de cada historia se traducen 1:1 a pruebas `it('...')` en español.
- **Larastan 3 (PHPStan 2) nivel 6** desde el primer commit, sin *baseline*. Meta: nivel 8 al cierre de la Fase 2 (acuerdo en retrospectiva).
- **Laravel Pint** con el *preset* `laravel`.
- `composer audit` sin vulnerabilidades altas/críticas.
- **GitHub Actions** (`.github/workflows/app-colegio.yml` en la raíz del repositorio, `working-directory: app-colegio`): trabajos `pint --test`, `phpstan analyse`, `pest` con SQLite y con PostgreSQL de servicio, cobertura con `pcov` (`--coverage --min=80`) y `composer audit`. El PR no se integra si algún trabajo falla.
- La [[Definicion de Terminado]] la ajusta el PO con estos comandos (propuesta del Scrum Master).

### 8. Colas, correo y tareas programadas
- **Colas con driver `database`** al inicio (sin Redis); todas las notificaciones por correo implementan `ShouldQueue`. Worker con `php artisan queue:work` supervisado (systemd/Supervisor). Redis (la extensión ya está disponible) queda como optimización si la carga lo exige.
- **Caché `database`** al inicio; misma nota sobre Redis.
- **Correo:** SMTP del dominio institucional en staging/producción; `MAIL_MAILER=log` (o Mailpit) en desarrollo. Plantillas Markdown de Laravel en español.
- *Scheduler* de Laravel (`routes/console.php`) para limpieza de tokens, sesiones vencidas y retención de auditoría.

### 9. App de estudiantes (Fase 4) — recomendación, decisión abierta
| Opción | Pros | Contras |
|---|---|---|
| **A. Panel Filament `estudiante` como PWA** (ruta/subdominio propio, guard `student`, login por usuario asignado) | Un solo stack y equipo; reutiliza modelos, *Policies* y auditoría; instalación como PWA sin tiendas | Livewire necesita conexión (no hay modo sin conexión real); peso de Filament en 3G por medir; la UI de Filament está pensada para administración |
| B. API REST con **Sanctum** + app móvil (Flutter / React Native / Kotlin) | Mejor experiencia móvil, soporte sin conexión, control fino de consumo de datos ([[HU-026 Modo bajo consumo de datos]]) | Segundo stack y segunda base de código; requiere habilidades móviles; publicación en tiendas |
| C. Laravel + Blade/Livewire liviano (sin Filament) como PWA | Mismo backend, HTML muy liviano y controlado | UI construida desde cero |

**Recomendación:** empezar la Fase 4 con un **spike comparando A y C** sobre peso de página y uso en 3G, manteniendo la lógica de negocio en clases *Actions*/servicios independientes de Filament para poder exponer una API Sanctum (opción B) sin reescribir el dominio. **La decisión final queda abierta** y se tomará en un ADR al inicio de la Fase 4 ([[EP-06 App de estudiantes]]). En cualquier caso se respeta [[ADR-003 Separar acceso de personal y estudiantes]]: guard distinto y un estudiante nunca puede acceder a `admin` ni `docente`.

### 10. Estructura del repositorio
```text
piloto_boliviano_suizo/          ← raíz del repositorio = vault de Obsidian
├── 00-Inicio/ … 09-Recursos/    ← documentación (vault)
├── .github/workflows/           ← CI (apunta a app-colegio/)
└── app-colegio/                 ← proyecto Laravel 13 + Filament 5
    ├── app/  bootstrap/  config/  database/  lang/es/  resources/  routes/  tests/
    ├── composer.json  phpstan.neon  pint.json  phpunit.xml
    └── .env.example             ← nunca se versiona .env
```
- El código vive separado del vault. Se recomienda excluir `app-colegio/` en Obsidian (*Settings → Files and links → Excluded files*) para que `vendor/` y `node_modules/` no se indexen.
- `.gitignore` de `app-colegio/` (el de Laravel) excluye `vendor/`, `node_modules/`, `.env`, `storage/*.key`.

## Opciones consideradas (resumen)
| Tema | Elegida | Alternativas descartadas |
|---|---|---|
| Framework | Laravel 13 + Filament 5 | Laravel 12 + Filament 4 (soporte más corto); Symfony + EasyAdmin (menos productivo para el equipo y sin MFA nativo) |
| Base de datos | PostgreSQL | MySQL 8 (válido; menor apoyo a inmutabilidad y `jsonb`); SQLite en producción (no apto para concurrencia) |
| Paneles | `admin` + `docente` | Un panel único (mezcla UX docente y administrativa); un panel por rol (duplicación) |
| Autorización | spatie/laravel-permission + Policies | Filament Shield (permisos CRUD genéricos); roles propios (reinventar caché y API probadas) |
| Auditoría | Tabla propia | spatie/activitylog (PHP 8.4); owen-it/laravel-auditing (orientado a modelos) |
| Pruebas | Pest 4 | Pest 5 (PHP 8.4); PHPUnit puro (menos legible para criterios de aceptación) |

## Consecuencias
- ✅ Un solo lenguaje y framework para todo el portal; productividad alta en CRUD (personal, roles, auditoría).
- ✅ MFA TOTP, recuperación de contraseña, perfil y *rate limiting* básicos vienen de Filament: menos código de seguridad propio.
- ✅ Seguridad del lado del servidor por diseño (Livewire + Policies), alineada con [[HU-007 Panel segun rol]].
- ✅ Auditoría inmutable reforzada en la base de datos.
- ⚠️ Dependencia fuerte de Filament: las actualizaciones mayores (5 → 6) requieren planificar un *spike* y tiempo en el sprint.
- ⚠️ Personalizar el login y el flujo de MFA por rol exige conocer los internos de Filament → *spikes* en Sprint 1 y Sprint 2.
- ⚠️ Livewire es más "conversador" que HTML estático: vigilar peso y latencia en 3G ([[Accesibilidad y conectividad]]).
- ⚠️ PHP 8.3 impide usar Pest 5 y spatie/activitylog 5; revisar la subida a PHP 8.4 en la retrospectiva de la Fase 1.
- ⚠️ Se necesita un servidor con PHP-FPM 8.3, PostgreSQL 16+, worker de colas y *cron* para el *scheduler* (supuesto a validar en [[Riesgos y supuestos]]).

## Revisión
- Fin del Sprint 2: confirmar MFA por rol y peso del login (resultados de los *spikes*).
- Inicio de la Fase 4: ADR de la app de estudiantes (§9).
