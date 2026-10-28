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
- [ ] CI de GitHub Actions en verde (formato, análisis estático, pruebas en SQLite y PostgreSQL, cobertura, auditoría de dependencias).

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
- [ ] Mensajes en español claro, sin jerga técnica.
- [ ] Probado en red lenta simulada (3G).

## Entrega
- [ ] Desplegado en el ambiente de pruebas (staging).
- [ ] Aceptado por el [[Product Owner]].
- [ ] Documentación actualizada (este vault: historia, ADR si aplica, guía de usuario si aplica).

> Ajuste técnico del 2026-10-28: el [[Scrum Master]] añadió los comandos del stack ([[ADR-005 Stack PHP Laravel y Filament]]) sin relajar ningún criterio.
>
> La DoD se revisa en cada [[Sprint Retrospective]]. Solo se endurece, nunca se relaja sin acuerdo explícito.
