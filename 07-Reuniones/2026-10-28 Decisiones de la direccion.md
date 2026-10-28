---
tipo: reunion
tipo_reunion: decisiones-direccion
fecha: 2026-10-28
sprint: "[[Sprint 0 - Preparacion]]"
tags: [reunion, producto, decisiones, piloto]
---
# 2026-10-28 · Decisiones de la dirección del colegio

Volver a [[Reuniones MOC]] · Origen: [[2026-10-28 Revision del Product Owner]] · Backlog: [[Backlog del producto]]

**Participantes:** Dirección del colegio (respuestas a las decisiones pendientes), Product Owner.
**Objetivo:** registrar las respuestas de la dirección, cómo las interpreta el PO y su efecto en el backlog.

## 🧪 Marco: proyecto piloto
La dirección aclaró que **no se trata de una implementación real**: es un **piloto/demostración**.
- Todos los datos son **ficticios**: personas, estudiantes, RUDE y correos inventados, con el dominio `@colegio-piloto.test`.
- No hay despliegue a producción ni compromisos operativos reales.
- La **Gestión 2027** es el **escenario simulado**, no una fecha de salida.
- Quedan fuera del alcance del piloto, para una eventual implementación real: disponibilidad del 99,5 %, respaldos con restauración probada, cumplimiento legal completo, validación oficial del RUDE y correo institucional real.

Actualizado en: [[Vision del producto]], [[Contexto del colegio virtual]], [[Fases y roadmap]], [[Riesgos y supuestos]], [[Requisitos no funcionales]], [[Definicion de Terminado]], [[Seguridad y proteccion de datos]] e [[Inicio]].

## Respuestas, interpretación e impacto
| # | Decisión | Interpretación del PO | Impacto en el producto |
|---|---|---|---|
| 1 | Gestión de arranque: **2027** | Es el escenario que se simula en el piloto | Se define un **MVP del piloto** de 39 pts al inicio de las Fases 2–3 (ver abajo). Roadmap y riesgos actualizados, sin presión de una fecha real (R8). |
| 2 | Aula virtual: **sistema propio** (sin LMS) | El contenido del aula se construye dentro de la plataforma | Se cierra la pregunta abierta de [[EP-04 Aulas virtuales]]. [[HU-032 Anuncios del aula]] pasa de *idea* a *backlog*. [[HU-018 Crear aulas virtuales por paralelo]] actualizada. |
| 3 | Tutores con **acceso propio**; mecanismo de consentimiento **pendiente** | El tutor tendrá una cuenta de consulta sobre sus hijos | Nueva épica [[EP-09 Acceso de tutores]] con [[HU-035 Activar cuenta del tutor]] (5), [[HU-036 Tutor ve materias y docentes de su hijo]] (3), [[HU-037 Tutor solicita restablecer acceso del estudiante]] (3) y [[HU-038 Consentimiento en linea del tutor]] (5, *idea*): 16 pts provisionales. Mientras tanto, [[HU-033 Registrar estudiante y tutor]] solo registra que hubo consentimiento, con su fecha y medio. Nuevo rol Tutor en [[Roles y permisos RBAC]]. |
| 4 | RUDE **obligatorio** | Ningún estudiante se registra sin RUDE | [[HU-033 Registrar estudiante y tutor]] incluye el escenario "RUDE obligatorio" y valida el formato. En el piloto los RUDE son ficticios. |
| 5 | Credenciales de estudiantes **no definidas** (Fase 4) | No bloquea las Fases 1–3 | [[HU-034 Credenciales del estudiante para el tutor]] queda en backlog con la decisión pendiente; podrían entregarse a través de la cuenta del tutor. |
| 6 | Plantel administrativo **1–15**, docente **1–50** | Escala pequeña (≤ 65 cuentas) | Escala registrada en [[Contexto del colegio virtual]], [[Requisitos no funcionales]] y [[Stakeholders]]. [[HU-012 Carga masiva de personal]] pasa a **prioridad baja** (ver la propuesta 2 del SM). |
| 7 | Cupo por paralelo y carga horaria máxima por docente: **se aplican**, con valores **configurables** aún no definidos | **Confirmado por la dirección: ambos bloquean la acción** (no solo advierten) | Cupo en [[HU-016 Configurar niveles grados y paralelos]] (por defecto, editable por paralelo) y en [[HU-023 Matricular estudiantes en aula]] (bloquea la matrícula o el cambio a un paralelo lleno). Carga máxima en [[HU-021 Asignar docente a materia]] (bloquea, muestra las horas usadas y disponibles). Sin excepciones en el piloto. |
| 8 | MFA para docentes: **pendiente, fuera de la Fase 1** | Docentes sin MFA en la Fase 1 | Actualizados [[HU-005 MFA para personal administrativo]], [[ADR-002 Autenticacion con correo institucional y MFA]] y [[Roles y permisos RBAC]]. Queda como idea en el parking lot del backlog. |

## Propuestas del Scrum Master ([[2026-10-28 Sprint Planning tecnico - Scrum Master]])
| # | Propuesta | Decisión del PO | Motivo |
|---|---|---|---|
| 1 | HU-008 sin "ubicación aproximada" | ✅ **Aceptada** | Geolocalizar la IP aporta poco para reconocer una sesión, cuesta un servicio externo y suma riesgo de privacidad. Basta con navegador, sistema operativo, IP y último uso. [[HU-008 Gestion de sesiones activas]] actualizada. |
| 2 | Revisar el valor de HU-012 con un plantel ≤ 65 | ✅ **Aceptada** | Invitar a 65 personas una por una con [[HU-009 Invitar personal]] toma pocas horas. HU-012 baja a prioridad baja, detrás de las Fases 2–4 (orden 35). No se elimina, por si el plantel crece. |
| 3 | Definir el mínimo de las Fases 2–3 para el inicio de clases de 2027 | ✅ **Aceptada** | Se define el **MVP del piloto** (abajo) y se reordena el backlog. |

## MVP del piloto (escenario: inicio de clases de la Gestión 2027)
Es el **mínimo para demostrar el piloto**: con datos ficticios, el colegio prepara su gestión y cada docente ve sus aulas y sus estudiantes. **39 pts**, unos 2 sprints (Sprints 4–5, referenciales).

| Orden | Historia | Pts | Por qué es imprescindible |
|---|---|---|---|
| 15 | [[HU-015 Registrar gestion academica]] | 3 | Todo cuelga de la gestión |
| 16 | [[HU-016 Configurar niveles grados y paralelos]] | 5 | Estructura y cupos |
| 17 | [[HU-017 Catalogo de materias]] | 3 | Materias con su carga horaria |
| 18 | [[HU-018 Crear aulas virtuales por paralelo]] | 5 | Sin aulas no hay asignaciones |
| 19 | [[HU-020 Asignar materias al aula]] | 3 | Plan de estudios por aula |
| 20 | [[HU-021 Asignar docente a materia]] | 5 | Meta de la visión: 100 % de aulas con docentes |
| 21 | [[HU-022 Docente ve sus aulas asignadas]] | 3 | Primer valor visible para el docente |
| 22 | [[HU-033 Registrar estudiante y tutor]] | 5 | RUDE + tutor, requisito de la matrícula |
| 23 | [[HU-023 Matricular estudiantes en aula]] | 5 | Estudiantes en su aula, con cupo |
| 24 | [[HU-031 Lista de estudiantes del aula]] | 2 | El docente conoce a su curso desde el primer día |

**Fuera del MVP:**
- [[HU-019 Panel del aula virtual]]: las tarjetas de HU-022 cubren lo esencial.
- [[HU-008 Gestion de sesiones activas]].
- Toda la Fase 4 (app de estudiantes, anuncios, tutores).
- HU-012 y las ideas.

## Notas para el Scrum Master (efecto en S1–S3, sin editar tareas ni paquetes)
- **HU-008:** ya estaba fuera de S1–S3; ahora queda en el orden 26, después del MVP, y sin "ubicación aproximada". Revisar si alguna tarea de TEC-06 (sesiones con `user_id`) preveía guardar la ubicación; si es así, se puede quitar.
- **HU-012:** no estaba en S1–S3; ahora tiene prioridad baja (orden 35). No hace falta preparar nada para ella en la Fase 1.
- **HU-005 / MFA docentes:** confirma lo que ya ajustó el SM (MFA solo para administrativos; T-2-13 y T-1-20). Sin cambios.
- **Datos ficticios:** `DemoStaffSeeder` y las *factories* deben usar el dominio `@colegio-piloto.test` y la escala 1–15 / 1–50.
- El contenido de S1–S3 **no cambia**.

## Ajustes para el Scrum Master por alcance piloto
Propuestas del PO; la decisión técnica es del SM con los Developers. Solo se menciona lo que se podría **simplificar**:
1. **Producción:** no habrá ambiente de producción. Basta con un **entorno de demostración** (staging o incluso local/compartido) que despliegue desde `main`; TEC-09 puede reducirse.
2. **PostgreSQL:** su uso como base "de producción" deja de ser un requisito. Puede mantenerse por los *triggers* de auditoría si ya está resuelto; si complica, valorar SQLite o PostgreSQL solo en CI y demostración.
3. **Respaldos y monitoreo (TEC-16):** fuera del alcance del piloto. Los datos ficticios se regeneran con *seeders* (`migrate:fresh --seed`); como mucho, un respaldo manual antes de cada demostración.
4. **Correo:** no se necesita SMTP institucional real. Usar **Mailpit o el driver `log`** también en el entorno de demostración; ningún correo sale a personas reales.
5. **Dominio y HTTPS:** el dominio de ejemplo `colegio-piloto.test` basta. HTTPS solo si la demostración es pública.
6. **Datos:** *seeders* de demostración completos (personal, estructura 2027, estudiantes con RUDE ficticio, tutores) como parte del incremento de cada fase.
7. **Seguridad:** se mantienen los controles funcionales (hash, MFA, bloqueo, auditoría, permisos) porque son parte de lo que se demuestra; las cabeceras y los escaneos se mantienen si no cuestan esfuerzo extra.

## Decisiones que siguen pendientes
- Mecanismo de consentimiento del tutor (firma presencial, en línea o ambos).
- Credenciales de estudiantes: formato, vigencia y canal de entrega (Fase 4).
- Valores de cupo por paralelo y carga horaria máxima, y si existe una excepción autorizada.
- MFA para docentes (fuera de la Fase 1).
- Número de estudiantes del escenario simulado; más de un tutor por estudiante; quién ve los datos del tutor; datos obligatorios del personal.

## Acciones
| Acción | Responsable | Fecha |
|---|---|---|
| Revisar los ajustes por alcance piloto y las notas sobre HU-008 y HU-012 | Scrum Master | Sprint Planning del S0 |
| ~~Confirmar con la dirección que cupo y carga horaria bloquean~~ → **confirmado: bloquean** | Product Owner | Resuelto 28/10/2026 |
| Refinar el MVP del piloto (re-estimar HU-016, HU-020, HU-021 y HU-033) | PO + Developers | Refinamiento del S3 |
