---
tipo: epica
id: EP-09
tags: [epica, fase4, tutores, menores]
estado: backlog
fase: 4
prioridad: media
---
# EP-09 · Acceso de tutores

Volver a [[Backlog del producto]] · Decisión: [[2026-10-28 Decisiones de la direccion]]

## Descripción
La dirección decidió que madres, padres y tutores legales **tendrán acceso propio** a la plataforma. Los estudiantes son en su mayoría menores sin correo propio: el tutor es quien da el consentimiento, recibe las credenciales y acompaña el estudio. Esta épica le da al tutor un acceso de **consulta** sobre su(s) hijo(s) y un canal para gestionar el acceso del estudiante sin ir a la oficina.

## Hipótesis de valor
> Si el tutor puede consultar en línea las materias y docentes de su hijo y pedir un nuevo acceso, baja la carga de secretaría y de la oficina de información y mejora el acompañamiento en casa.

## Alcance
**Incluye:** activar la cuenta del tutor, consultar las materias y docentes de sus hijos, pedir el restablecimiento del acceso del estudiante y, si así se decide, dar el consentimiento en línea.
**No incluye (por ahora):** calificaciones, asistencia, mensajería con docentes (parking lot).

## Historias
| ID | Historia | Pts* | Estado |
|---|---|---|---|
| [[HU-035 Activar cuenta del tutor]] | Activar la cuenta del tutor | 5 | backlog |
| [[HU-036 Tutor ve materias y docentes de su hijo]] | Consultar materias y docentes de sus hijos | 3 | backlog |
| [[HU-037 Tutor solicita restablecer acceso del estudiante]] | Pedir un nuevo acceso para el estudiante | 3 | backlog |
| [[HU-038 Consentimiento en linea del tutor]] | Consentimiento en línea | 5 | idea |
| **Total** | | **16** | |

\* Estimaciones provisionales del PO.

## Preguntas abiertas
- **Mecanismo de consentimiento** (pendiente de la dirección): firma presencial en la oficina de información, aceptación en línea al activar la cuenta, o ambos. Hasta decidirlo, [[HU-033 Registrar estudiante y tutor]] registra el consentimiento con su fecha y medio, sea cual sea.
- ¿Canal del tutor: la misma app de estudiantes con otro perfil, o un acceso web aparte? Lo proponen los Developers (ver [[ADR-003 Separar acceso de personal y estudiantes]]).
- ¿Cuántos tutores con acceso por estudiante?
- Relación con [[HU-034 Credenciales del estudiante para el tutor]]: las credenciales del estudiante aún no están definidas; podrían entregarse a través de la cuenta del tutor.

## Relacionado
[[EP-06 App de estudiantes]] · [[EP-05 Asignacion de cursos y materias]] · [[Seguridad y proteccion de datos]] · [[Marco normativo Bolivia]]
