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
- [ ] Pruebas automatizadas de los [[Criterios de aceptacion]].
- [ ] Sin errores de análisis estático ni vulnerabilidades altas/críticas en dependencias.

## Seguridad y privacidad
- [ ] Permisos verificados según [[Roles y permisos RBAC]] (probado con un rol sin acceso).
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

> La DoD se revisa en cada [[Sprint Retrospective]]. Solo se endurece, nunca se relaja sin acuerdo explícito.
