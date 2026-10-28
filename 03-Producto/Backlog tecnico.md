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
| TEC-01 | Proyecto Laravel 13 base | `app-colegio/` creado con Laravel 13, Filament 5, Pest 4, Larastan y Pint como dependencias; idioma `es`, zona `America/La_Paz`, `config/colegio.php` | Todas | [[Sprint 0 - Preparacion\|S0]] | Dev 1 | hecho (S0) |
| TEC-02 | Entorno local reproducible | SQLite por defecto (`database/database.sqlite`), `.env.example` completo, arranque con `composer dev`; Mailpit opcional. Sin Docker ni servidor de base de datos | Todas | S0 | Dev 3 | hecho (S0) |
| TEC-03 | Herramientas de calidad | `phpunit.xml` (SQLite en memoria), `tests/Pest.php`, `phpstan.neon` (nivel 6), `pint.json`, `composer quality` | DoD de todas | S0 | Dev 2 | hecho (S0) |
| TEC-04 | Integración continua | GitHub Actions: Pint, PHPStan, Pest (SQLite) con cobertura ≥ 80 %, `composer audit`; plantilla de PR con la DoD | DoD de todas | S0 | Dev 2 | hecho (S0) |
| TEC-05 | Paneles Filament | Paneles `admin` (`/admin`) y `docente` (`/docente`) con login de Filament por defecto y marca del colegio | [[HU-001 Iniciar sesion con correo institucional\|HU-001]], [[HU-007 Panel segun rol\|HU-007]] | S0 | Dev 1 | hecho (S0) |
| TEC-06 | Identidad base | `User` con UUID, estado de cuenta (`AccountStatus`), hash Argon2id, sesiones en base de datos con `user_id` UUID | HU-001, [[HU-002 Cerrar sesion\|HU-002]], [[HU-008 Gestion de sesiones activas\|HU-008]] | S0 | Dev 1 | hecho (S0) |
| TEC-07 | Localización al español | `lang/es` (`auth`, `passwords`, `validation`, `pagination`), traducción `es` de Filament | Todas (DoD: mensajes en español claro) | S0 | Dev 3 | hecho (S0) |
| TEC-08 | Correo y colas | Cola y caché `database`; correo con driver `log` por defecto (Mailpit opcional), sin envíos a personas reales; plantilla de correo en español; *scheduler* mínimo (`auth:clear-resets`) | [[HU-003 Recuperar contrasena\|HU-003]], [[HU-004 Bloqueo por intentos fallidos\|HU-004]], [[HU-009 Invitar personal\|HU-009]], [[HU-029 Mi cuenta datos y cambio de contrasena\|HU-029]] | S0 | Dev 3 | hecho (S0) |
| TEC-09 | Entorno de demostración | Comando `php artisan colegio:demo` (`migrate:fresh --seed` con datos ficticios y resumen de cuentas de demo) y guía de demostración. ~~Staging con despliegue automático, HTTPS y SMTP institucional~~: fuera del alcance del piloto | DoD (demostrable en el entorno de demostración) | S0 | Dev 3 | hecho (S0) |
| TEC-10 | Roles y permisos | `spatie/laravel-permission` con UUID, enums `StaffRole` y `Permission`, *seeder* de la matriz [[Roles y permisos RBAC]] | HU-007, [[HU-010 Asignar roles al personal\|HU-010]], [[HU-014 Consultar bitacora de auditoria\|HU-014]] | [[Sprint 1 - Login base\|S1]] | Dev 2 | hecho (S1) |
| TEC-11 | Cuentas semilla y datos de prueba | *Factories* por estado y rol, comando `colegio:crear-cuenta` (contraseña temporal), *helpers* de Pest `actingAsStaff()` | HU-001, [[HU-006 Cambio de contrasena en primer ingreso\|HU-006]], HU-007 (temporal hasta HU-009) | S1 | Dev 2 | hecho (S1) |
| TEC-12 | Auditoría base | Tabla `audit_events`, modelo inmutable, servicio `AuditLogger`, *trigger* anti `UPDATE`/`DELETE` (SQLite; rama `pgsql` preparada) | [[HU-013 Registro de auditoria de accesos\|HU-013]] y toda acción sensible (DoD) | S1 | Dev 3 | hecho (S1) |
| TEC-13 | Cabeceras de seguridad | HSTS, `X-Frame-Options`, `X-Content-Type-Options`, `Referrer-Policy`, CSP (primero en modo informe), `Cache-Control: no-store` en paneles | HU-002, [[Seguridad y proteccion de datos]] | S1 | Dev 1 | hecho (S1) |
| TEC-14 | Spike: peso del login en 3G | Medir `/admin/login` en local con red 3G simulada (meta < 200 KB, < 10 s) y proponer optimizaciones | HU-001, [[Requisitos no funcionales]] | S1 | Dev 3 | hecho (S1): no cumple 200 KB |
| TEC-15 | Spike: MFA por rol en Filament 5 | Confirmar cómo exigir MFA por rol (no solo por panel), 10 códigos de recuperación y conteo de códigos fallidos para el bloqueo | [[HU-005 MFA para personal administrativo\|HU-005]] | S1 | Dev 3 | hecho (S1) |
| TEC-16 | Datos de demostración ficticios | `DemoStaffSeeder`: cuentas `@colegio-piloto.test` (hasta 15 administrativos y 50 docentes ficticios, al menos una por rol y por estado: activa, pendiente, bloqueada, desactivada, con y sin MFA). Se amplía en S3 con la ficha del personal. ~~Respaldos y monitoreo~~: fuera del alcance del piloto | Demostración de todas las historias | [[Sprint 2 - Seguridad del login\|S2]] · S3 | Dev 2 · Dev 3 | por hacer |
| TEC-17 | ~~Tareas programadas y retención de auditoría~~ | **Descartado por alcance piloto** (datos ficticios que se regeneran; sin purga a 1 año). La limpieza de tokens pasa a TEC-08 | — | — | — | descartado |
| TEC-18 | Deuda: Pint sin exclusiones | Quitar los 20 `notPath` de `pint.json` aplicando `declare(strict_types=1)` y el formato a los archivos del esqueleto; eliminar la prueba trivial `tests/Unit/ExampleTest.php` | DoD (formato uniforme) | S1 (T-1-22, día 1) | Dev 2 | hecho (S1) |
| TEC-19 | Deuda: CI sin filtro `paths` y primera ejecución | Quitar el filtro `paths` del disparador `pull_request` (o agregar un trabajo de resumen que siempre informe) para que los trabajos obligatorios no bloqueen los PR que solo tocan el vault; verificar la primera ejecución real en GitHub (4 trabajos en verde) | DoD (CI en verde), TEC-20 | S1 (T-1-23, día 1–2) | Dev 2 | hecho (S1, CI verde en PR #1) |
| TEC-20 | Deuda: protección de `main` | Regla de protección: PR obligatorio, 1 revisión y los 4 trabajos de CI obligatorios. Requiere un administrador del repositorio (la API devolvió 403): **impedimento** que gestiona el SM. Se activa después de TEC-19 | DoD (revisión e integración) | S1 (gestión del SM) | SM + administrador del repositorio | bloqueado (sigue el 403; lo activa el dueño del repo) |
| TEC-21 | Fuentes del sistema en los paneles | `FontProvider` propio sin Inter en `StaffPanel` (≈ −67 KB en el login; de ≈ 334 a ≈ 267 KB con gzip) | HU-001, [[Requisitos no funcionales]] | S2 (T-2-01) | Dev 3 | por hacer |
| TEC-22 | *Helpers* de MFA para las pruebas | `UserFactory::withMfa()/withoutMfa()`, cuentas administrativas con MFA configurado por defecto, `completeMfaChallenge()`; requisito para activar el MFA sin romper 16 pruebas | HU-005 | S2 (T-2-17) | Dev 2 | por hacer |
| DEF-01 | Defecto: tono mezclado "usted"/"tú" | El login de Filament dice "Entre a su cuenta" y `auth.throttle` dice "Intente…"; el resto usa "tú" | DoD (español claro y consistente) | S2 (T-2-18 Dev 1; T-2-08 Dev 2; textos MFA en T-2-13/14 Dev 3) | Dev 1 · Dev 2 · Dev 3 | por hacer |
| DEF-02 | Defecto: *throttle* del login por IP | Filament limita 5 intentos/min por IP y cuenta también los exitosos: varias personas detrás de una misma IP (oficina, NAT) se bloquean entre sí | HU-004 | S2 (T-2-08) | Dev 2 | por hacer |

**Total:** 21 elementos TEC vigentes + 1 descartado, y 2 defectos (S0: 9 · S1: 6 + 3 de deuda · S2: TEC-16, TEC-21, TEC-22, DEF-01, DEF-02 · S3: ampliación de TEC-16).

> 🧪 **Ajuste por alcance piloto (2026-10-28):** sin staging, producción, respaldos ni retención productiva; SQLite como única base de datos; correo a `log`/Mailpit; datos ficticios con *seeders*. Ver [[2026-10-28 Decisiones de la direccion]] y [[2026-10-28 Sprint Planning tecnico - Scrum Master#7. Actualización: alcance piloto]].

## Deuda técnica
Registrada en el cierre del [[Sprint 0 - Preparacion]] ([[2026-11-13 Retrospectiva - Sprint 0]]). Se atiende al **inicio del Sprint 1**: es pequeña (menos de 1 día en total) y, si se deja para después, crece con cada archivo que se toque.

| ID | Origen | Riesgo si no se atiende | Sprint |
|---|---|---|---|
| TEC-18 | T-0-05: `pint.json` con 20 `notPath` | Cada developer que toque `AppServiceProvider`, `bootstrap/app.php` o `config/session.php` en S1 queda fuera de la regla de formato | S1, día 1 (antes de que Dev 1 y Dev 2 editen esos archivos) |
| TEC-19 | T-0-06: filtro `paths` y CI sin ejecutar | PR bloqueados al exigir los trabajos; no hay evidencia de CI verde en GitHub | S1, día 1–2 |
| TEC-20 | T-0-07: protección de `main` (403) | Se integra sin revisión ni CI obligatorios | S1 (impedimento; depende del administrador del repositorio) |

## Defectos y deuda del Sprint 1
Registrados en el cierre del [[Sprint 1 - Login base]] ([[2026-11-27 Retrospectiva - Sprint 1]]).

| ID | Origen | Decisión del SM | Sprint |
|---|---|---|---|
| DEF-01 | T-1-21 | Unificar en "tú", que es el tono mayoritario y el de las historias. El PO confirma el tono (propuesta 2) | S2 |
| DEF-02 | T-1-21 | Contar solo los intentos fallidos, por IP + correo, con un tope por IP más alto; el bloqueo por cuenta (HU-004) sigue siendo el control principal. El PO confirma los umbrales (propuesta 3) | S2 (dentro de HU-004) |
| TEC-21 | [[Spike T-1-19 Peso del login en 3G]] | Aceptado: fuentes del sistema. Quitar `echo.js`/`tables.js` del login queda como investigación de baja prioridad (sin fecha) | S2 |
| TEC-22 | [[Spike T-1-20 MFA por rol]] | Aceptado: requisito previo de la activación del MFA | S2 |
| TEC-20 | S0 | Sigue bloqueado: el dueño del repositorio debe activar la protección de `main` (el CI ya está en verde para exigirlo) | Impedimento abierto |
| — | T-1-21 | Verificación manual en navegador (Chrome, Firefox, Android, 3G, Lighthouse): el entorno de los agentes no la permite → la hace una persona en cada Sprint Review con la lista de verificación del sprint | Cada Review |

## Propuestas al Product Owner
> **Respondidas por el PO** en la [[2026-11-27 Sprint Review - Sprint 1]]: se aceptan (1) el RNF de peso, (2) el tono "tú", (3) el límite por IP y (4) la contraseña temporal al restablecer el MFA. Sobre (5), en la Fase 1 no se ofrece MFA a docentes y la decisión sigue pendiente para la dirección.
- ✅ **HU-008 sin "ubicación aproximada":** aceptada por el PO ([[2026-10-28 Decisiones de la direccion]]).
- **(1) RNF de peso del login (Sprint 1):** Filament no baja de ≈ 230–270 KB con gzip en la primera visita. Propuesta: redefinir el RNF como "primera visita < 300 KB comprimidos y < 10 s en 3G; visitas siguientes < 50 KB". Mientras el PO no decida, HU-001 queda con el RNF incumplido y se informa en la Review. Alternativa descartada: un login sin Livewire, que duplicaría MFA, límites de intentos y auditoría.
- **(2) Tono de la interfaz:** "tú" en toda la aplicación (DEF-01).
- **(3) Límite de intentos por IP:** 20 intentos fallidos/min por IP; los ingresos correctos no cuentan (DEF-02).
- **(4) Restablecer MFA:** al restablecerlo, emitir también una contraseña temporal (HU-006), para cerrar la ventana en la que alguien con solo la contraseña podría vincular su propia app ([[Spike T-1-20 MFA por rol]]). Cambia el alcance de HU-005: lo decide el PO.
- **(5) Docentes y MFA voluntario:** por defecto se bloquea la configuración a quien no es administrativo (decisión de la dirección: MFA de docentes fuera de la Fase 1). El PO puede permitirlo.
- **Sprint 3 con capacidad reducida** (9 días hábiles por el feriado del 25/12): mantener la previsión de 18 pts con [[HU-014 Consultar bitacora de auditoria]] como primera en salir, tal como ya decidió el PO. Ver [[2026-10-28 Sprint Planning tecnico - Scrum Master]].

## Relacionado
- Tareas por sprint: [[Sprint 0 - Preparacion#Tareas técnicas]] · [[Sprint 1 - Login base#Tareas técnicas]] · [[Sprint 2 - Seguridad del login#Tareas técnicas]] · [[Sprint 3 - Gestion de personal#Tareas técnicas]]
