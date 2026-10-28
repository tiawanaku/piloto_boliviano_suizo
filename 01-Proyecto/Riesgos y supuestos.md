---
tipo: proyecto
tags: [proyecto, riesgos]
---
# Riesgos y supuestos

Volver a [[Inicio]]

## Supuestos
- El colegio proveerá un **dominio y correos institucionales** para el personal (p. ej. `nombre@colegio.edu.bo`).
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

Revisar este registro en cada [[Sprint Retrospective]] y [[Sprint Review]].
