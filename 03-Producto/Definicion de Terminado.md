---
tipo: acuerdo
tags: [producto, dod]
aliases: [DoD del proyecto]
---
# Definición de Terminado (DoD) — Colegio Virtual

Volver a [[Inicio]] · Concepto: [[Definition of Done]]

Una historia está **terminada** solo si cumple **todo** lo siguiente:

## Código y calidad
- [ ] Código integrado en la rama principal mediante *pull request* revisado por al menos 1 persona.
- [ ] Pruebas unitarias para la lógica nueva (cobertura de lo nuevo ≥ 80 %).
- [ ] Pruebas automatizadas de los [[Criterios de aceptacion]]: cada escenario Gherkin tiene al menos una prueba **Pest** con su nombre.
- [ ] Sin errores de análisis estático ni vulnerabilidades altas/críticas en dependencias.
- [ ] CI de GitHub Actions en verde (formato, análisis estático, pruebas en SQLite, cobertura, auditoría de dependencias).

### Comandos del stack
Ejecutar desde `app-colegio/` antes de pedir revisión ([[Stack tecnologico]]):

```bash
vendor/bin/pint --test              # formato Laravel Pint, sin cambios pendientes
vendor/bin/phpstan analyse          # Larastan/PHPStan nivel 6, sin errores ni baseline
vendor/bin/pest                     # todas las pruebas en verde
vendor/bin/pest --coverage --min=80 # cobertura (se verifica en CI con pcov)
composer audit                      # sin vulnerabilidades altas/críticas
```

## Seguridad y privacidad
- [ ] Permisos verificados según [[Roles y permisos RBAC]] mediante *Policies* en el servidor (probado con un rol sin acceso: respuesta 403).
- [ ] Ninguna contraseña, token o dato personal en logs.
- [ ] Acciones sensibles registradas en auditoría ([[EP-08 Seguridad y auditoria]]).

## Experiencia de usuario
- [ ] Funciona en Chrome, Firefox y en móvil (Android) — vista responsive.
- [ ] Accesibilidad básica: etiquetas, contraste, navegación con teclado ([[Accesibilidad y conectividad]]).
- [ ] Mensajes en español claro, sin jerga técnica, tratando al usuario de **tú** en toda la interfaz (incluidas las traducciones de Filament).
- [ ] Probado en red lenta simulada (3G).

## Alcance piloto
- [ ] Solo **datos ficticios** (seeders/factories), dominio `@colegio-piloto.test`; ningún dato real de personas ni de menores.
- [ ] Los correos se capturan en el entorno de demostración (sin envío a personas reales).
- El "ambiente de pruebas" es el entorno de demostración del piloto; **no hay producción**. Cómo se monta lo decide el [[Scrum Master]] con los Developers.

## Entrega
- [ ] Demostrable en el entorno de demostración del piloto (`php artisan colegio:demo` + `composer dev`) con datos ficticios.
- [ ] Aceptado por el [[Product Owner]].
- [ ] Documentación actualizada (este vault: historia, ADR si aplica, guía de usuario si aplica).

> Ajuste técnico del 2026-10-28: el [[Scrum Master]] añadió los comandos del stack ([[ADR-005 Stack PHP Laravel y Filament]]) sin relajar ningún criterio.
>
> Acuerdo explícito del PO (2026-11-13, [[2026-11-13 Sprint Review - Sprint 0]]): por el alcance piloto se confirman (1) el CI solo con SQLite y (2) "demostrable en el entorno de demostración" en lugar de "desplegado en staging". Siguen obligatorios el PR revisado y el CI de GitHub en verde: el Sprint 0 no los demostró y son condición para aceptar las historias desde el Sprint 1.
>
> La DoD se revisa en cada [[Sprint Retrospective]]. Solo se endurece, nunca se relaja sin acuerdo explícito.
