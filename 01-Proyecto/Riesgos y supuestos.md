---
tipo: proyecto
tags: [proyecto, riesgos]
---
# Riesgos y supuestos

Volver a [[Inicio]]

> 🧪 **Proyecto piloto / demostración.** No es una puesta en producción real del colegio: se trabaja con **datos 100 % ficticios** (personas, estudiantes, RUDE y correos inventados, dominio `@colegio-piloto.test`), sin despliegue a producción ni compromisos operativos reales. La **Gestión 2027** es el escenario simulado del piloto, no una fecha de salida. Ver [[2026-10-28 Decisiones de la direccion]].

## Supuestos
- Es un **piloto**: datos ficticios, sin producción ni usuarios reales.
- El colegio proveerá un **dominio y correos institucionales** para el personal (p. ej. `nombre@colegio-piloto.test`).
- Existe una persona con autoridad para actuar como [[Product Owner]].
- El personal cuenta con un dispositivo con navegador moderno y un celular para MFA.
- La estructura académica sigue la normativa vigente ([[Marco normativo Bolivia]]).

## Registro de riesgos
| ID | Riesgo | Prob. | Impacto | Mitigación | Dueño |
|---|---|---|---|---|---|
| R1 | PO sin disponibilidad suficiente | Media | Alto | Acordar dedicación mínima; delegar a un proxy con autoridad | Scrum Master |
| R2 | Conectividad deficiente de usuarios | Alta | Alto | Diseño liviano, modo bajo consumo ([[Accesibilidad y conectividad]]) | Developers |
| R3 | Filtración de datos de menores | Baja | Muy alto | MFA, cifrado, auditoría, mínimo privilegio ([[Seguridad y proteccion de datos]]) | Equipo |
| R4 | Resistencia al cambio del personal | Media | Medio | Capacitación, guías, soporte en oficina de información | PO |
| R5 | Alcance creciente (*scope creep*) | Alta | Medio | Backlog priorizado, Sprint Goal firme | PO / SM |
| R6 | Pérdida de acceso al MFA (cambio de celular) | Media | Medio | Códigos de respaldo + flujo de restablecimiento por TI ([[HU-005 MFA para personal administrativo]]) | Developers |
| R7 | Cambios normativos en la estructura académica | Baja | Medio | Modelo de datos configurable ([[Modelo de dominio]]) | Developers |
| R8 | El MVP del escenario 2027 no llega a demostrarse en el tiempo previsto | Media | Bajo | Es un piloto: el MVP (39 pts) va primero en el backlog y se demuestra cuando esté; las fechas son referenciales | PO |
| R9 | Que se carguen datos reales (de menores) en el piloto | Baja | Alto | Solo datos ficticios, dominio `@colegio-piloto.test`, correo capturado sin envío real; DoD lo verifica | Equipo |

## Fuera del alcance del piloto (para una eventual implementación real)
- Despliegue a **producción** y operación con usuarios reales.
- Compromisos operativos: disponibilidad 99,5 %, respaldos con restauración probada, monitoreo 24/7.
- Cumplimiento legal completo (protección de datos de menores, consentimiento con validez legal, Ley N.º 548) y validación formal del RUDE con el sistema oficial.
- Correo saliente real del dominio institucional.

Revisar este registro en cada [[Sprint Retrospective]] y [[Sprint Review]].
