---
tipo: concepto
tags: [scrum/rol]
aliases: [Equipo de desarrollo, Desarrolladores]
---
# Developers

Volver a [[Scrum MOC]] · Aplicado: [[Equipo Scrum del proyecto]]

Personas del Equipo Scrum **comprometidas a crear cualquier aspecto de un [[Incremento]] usable en cada [[Sprint]]**. Incluye programación, diseño UX, pruebas, documentación, infraestructura.

## Responsabilidades
- Crear el plan del sprint: el [[Sprint Backlog]].
- Inculcar calidad adhiriéndose a la [[Definition of Done]].
- Adaptar su plan cada día hacia el [[Objetivo del sprint]].
- Hacerse responsables mutuamente como profesionales.

## Habilidades necesarias en este proyecto
Stack: PHP 8.3 + Laravel 13 + Filament 5 + PostgreSQL ([[ADR-005 Stack PHP Laravel y Filament]] · [[Stack tecnologico]]).

| Área | Habilidades concretas | Para qué |
|---|---|---|
| Backend Laravel | Eloquent y migraciones (UUID, PostgreSQL), autenticación de Laravel (guards, *password broker*, sesiones en base de datos), eventos/listeners, colas y notificaciones, `RateLimiter` | Identidad, bloqueo, recuperación, auditoría ([[EP-01 Login plantel administrativo y docentes]], [[EP-08 Seguridad y auditoria]]) |
| Autorización | Policies y Gates, `spatie/laravel-permission`, reglas de pertenencia por consulta | [[Roles y permisos RBAC]], [[EP-02 Gestion de usuarios y roles]] |
| Frontend Filament | Paneles, Resources, páginas propias, acciones, formularios y tablas; personalización del login y del MFA de Filament; Livewire 4 y Alpine.js; tema con Tailwind CSS 4 | Portal del personal ([[Panel por rol]]) |
| Móvil / PWA | PWA (manifest, *service worker*) o API Sanctum + app móvil, según el ADR de la Fase 4 | [[EP-06 App de estudiantes]] |
| UX/UI | Diseño accesible (WCAG 2.1 AA) y liviano sobre componentes de Filament; textos en español en `lang/es` | [[Accesibilidad y conectividad]] |
| QA | Pest 4 (+ plugins Laravel y Livewire), traducción de escenarios Gherkin a pruebas, pruebas con rol sin acceso | [[Definicion de Terminado]] |
| Calidad de código | Larastan/PHPStan (nivel 6), Laravel Pint, revisión de PR | [[Definicion de Terminado]] |
| DevOps / Seguridad | GitHub Actions, Nginx + PHP-FPM, PostgreSQL (respaldos, *triggers*), worker de colas y *scheduler*, `composer audit`, cabeceras de seguridad | [[Seguridad y proteccion de datos]] |

Equipo **multifuncional** y **autogestionado**: deciden internamente *cómo* hacer el trabajo.
