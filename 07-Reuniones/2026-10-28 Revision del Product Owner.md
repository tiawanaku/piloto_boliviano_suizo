---
tipo: reunion
tipo_reunion: revision-po
fecha: 2026-10-28
sprint: "[[Sprint 0 - Preparacion]]"
tags: [reunion, producto, backlog, refinamiento]
---
# 2026-10-28 · Revisión del Product Owner

Volver a [[Reuniones MOC]] · Backlog: [[Backlog del producto]] · DoR: [[Definicion de Listo]] · DoD: [[Definicion de Terminado]]

**Participantes:** Product Owner (revisión individual, previa al [[Sprint 0 - Preparacion]]).
**Objetivo:** dejar el backlog coherente, ordenado y listo para que el [[Scrum Master]] defina el stack y descomponga la Fase 1 (Sprints 1–3) y las Fases 2–3 en tareas.

## Resumen
- El backlog de la Fase 1 estaba bien escrito, pero el Sprint 2 superaba la velocidad estimada (21 pts contra 15–20) y faltaban tres piezas que otras historias daban por hechas: el listado y la ficha del personal, el cambio voluntario de contraseña y las credenciales de los estudiantes.
- Las historias de las Fases 2–3 tenían criterios casi solo de camino feliz. Se refinaron todas, con errores, bordes, permisos, gestión cerrada y auditoría.
- HU-019 (8 pts) mezclaba tres necesidades y se dividió. HU-023 mezclaba registro, matrícula y credenciales y también se dividió.
- Se cubrieron los huecos de **tutores y datos de menores** (registro con consentimiento) y de **inicio de gestión** (gestión "planificada" para preparar la siguiente).
- Resultado: **34 historias · 148 pts** (antes 28 · 130). Fase 1 en sprints: **S1 17 · S2 19 · S3 18 = 54 pts**.

## Hallazgos
### Coherencia
1. **Sprint 2 sobrecargado:** 21 pts contra una velocidad estimada de 15–20.
2. **Sprint 3 de ~4 semanas** (14/12/2026 – 08/01/2027), mientras el acuerdo del equipo y el gantt del roadmap fijan sprints de 2 semanas.
3. **[[Inicio]]** decía "Sprint actual: Sprint 1", pero hoy (28/10) el Sprint 0 aún no empieza. EP-01 y EP-08 figuraban "en-progreso" sin trabajo iniciado.
4. Las épicas EP-02 a EP-08 no tenían totales de puntos, y el orden de HU-019 (22) quedaba entre historias de la Fase 3 sin explicación.
5. **[[Panel por rol]]** prometía en la Fase 1 una búsqueda para la Oficina de información (es HU-027, Fase 5) y un resumen de indicadores para Dirección que no tenía historia.
6. HU-009 a HU-028 no tenían `prioridad` en el frontmatter.
7. Había dos mecanismos de primera contraseña sin aclarar: la contraseña temporal (HU-006) y el enlace de activación (HU-009).
8. **Calendario:** según el roadmap, las aulas con docentes (H4) llegan hacia marzo de 2027 y la app de estudiantes hacia mayo de 2027, después del inicio habitual de clases en Bolivia (febrero).

### Calidad de historias (INVEST / criterios)
- La Fase 1 está sólida. Faltaban errores en HU-005 (código incorrecto, abandonar la activación), HU-009 (invitación vencida, dominio, CI), HU-010 (quitar rol, cuenta sin roles), HU-011 (autodesactivación), HU-012 (archivo inválido, importación parcial) y HU-014 (permisos).
- Fases 2–3: HU-015 a HU-023 tenían 1–2 escenarios cada una, sin permisos, duplicados ni gestión cerrada.
- **HU-019** (8 pts, "demasiado grande") no era *Small* ni *Independent*: dependía de las asignaciones, la matrícula y la decisión del LMS.
- **HU-023** no era *Small*: registraba al estudiante y al tutor, lo matriculaba y además generaba credenciales.
- **HU-020** citaba una "malla" que ninguna historia definía.

### Huecos de valor
- **Personal:** no había forma de buscar a una persona ni de corregir sus datos, aunque HU-004, HU-005, HU-010 y HU-011 lo necesitan. → HU-030.
- **Cuenta propia:** el menú "Mi cuenta" y la política "cambio ante sospecha de compromiso" no tenían historia. → HU-029.
- **Tutores y datos de menores:** no había historia para el tutor, el consentimiento ni el RUDE. → HU-033.
- **Credenciales de estudiantes:** HU-024 las suponía, pero nadie las generaba ni las restablecía. → HU-034.
- **Inicio de gestión:** no se podía preparar la gestión siguiente sin activarla. → estado "planificada" en HU-015 y sección "Próxima gestión" en HU-022.

## Cambios aplicados
### Historias nuevas
| ID | Historia | Épica | Pts* | Sprint |
|---|---|---|---|---|
| [[HU-029 Mi cuenta datos y cambio de contrasena]] | Mi cuenta: datos y cambio de contraseña | EP-01 | 3 | S2 |
| [[HU-030 Listado y ficha del personal]] | Listado y ficha del personal | EP-02 | 3 | S3 |
| [[HU-031 Lista de estudiantes del aula]] | Lista de estudiantes del aula (división de HU-019) | EP-04 | 2 | — |
| [[HU-032 Anuncios del aula]] | Anuncios del aula (división de HU-019, *idea*) | EP-04 | 5 | — |
| [[HU-033 Registrar estudiante y tutor]] | Estudiante + tutor + consentimiento (división de HU-023) | EP-05 | 5 | — |
| [[HU-034 Credenciales del estudiante para el tutor]] | Credenciales para el tutor (división de HU-023) | EP-06 | 5 | — |

\* Estimaciones provisionales del PO; las confirman los Developers en el refinamiento.

### Por archivo
- **03-Producto/Historias**
  - [[HU-005 MFA para personal administrativo]]: escenarios de código incorrecto o vencido y de activación abandonada.
  - [[HU-008 Gestion de sesiones activas]]: sale del S2 (orden 15, primera tras la Fase 1); escenario de sesión cerrada a distancia.
  - [[HU-009 Invitar personal]]: escenarios de dominio y CI, invitación vencida con reenvío y permisos; aclara su relación con HU-006.
  - [[HU-010 Asignar roles al personal]]: quitar rol con efecto inmediato y cuenta sin roles.
  - [[HU-011 Desactivar cuenta]]: no desactivar la propia cuenta; auditoría; efecto en las asignaciones.
  - [[HU-012 Carga masiva de personal]]: plantilla, vista previa, filas con error, archivo inválido, reporte y auditoría.
  - [[HU-014 Consultar bitacora de auditoria]]: escenarios sin resultados y sin permiso.
  - [[HU-015 Registrar gestion academica]] a [[HU-018 Crear aulas virtuales por paralelo]]: reescritas con errores, duplicados, gestión cerrada, permisos y gestión planificada.
  - [[HU-019 Panel del aula virtual]]: reducida de 8 a 3 pts (ficha del aula: materias y docentes).
  - [[HU-020 Asignar materias al aula]]: incluye las materias por grado (la "malla"); marcada para re-estimar.
  - [[HU-021 Asignar docente a materia]]: elegibilidad, reemplazo de titular, suplente, tablero de materias sin docente y carga horaria.
  - [[HU-022 Docente ve sus aulas asignadas]]: sección "Próxima gestión", asignación retirada y varios roles.
  - [[HU-023 Matricular estudiantes en aula]]: solo matrícula, cambio de paralelo y retiro.
  - [[HU-024 Login de estudiante en la app]] y [[HU-025 Estudiante ve sus materias]]: escenarios de error, matrícula no vigente, primer ingreso, accesos separados y cambio de paralelo.
  - Frontmatter: `prioridad` en todas las historias y `orden` renumerado del 1 al 34 sin duplicados.
- **03-Producto/Epicas:** tablas con totales en todas las épicas (EP-01 38 · EP-02 21 · EP-03 11 · EP-04 15 · EP-05 21 · EP-06 26 · EP-07 8 · EP-08 8). EP-01 y EP-08 pasan a estado "lista". Se agregan una sección de inicio de gestión en EP-03, el bloqueo por la decisión del LMS en EP-04 y reglas de tutor y credenciales en EP-05.
- **[[Backlog del producto]]:** nuevo orden agrupado por fase y sprint, con totales; el parking lot suma carga masiva de estudiantes, tablero de inicio de gestión e indicadores de Dirección.
- **04-Sprints:** [[Sprint 2 - Seguridad del login]] queda en 19 pts (−HU-008, +HU-029). [[Sprint 3 - Gestion de personal]] queda en 18 pts (+HU-030), con la duración marcada como pendiente. [[Sprints MOC]] actualizado.
- **01-Proyecto:** [[Fases y roadmap]] con los hitos H1, H2 y H4 ajustados y la alerta de calendario; [[Contexto del colegio virtual]] con el papel de los tutores.
- **05-Arquitectura:** [[Roles y permisos RBAC]] con 3 permisos nuevos (ficha del personal, estudiantes y tutores, credenciales); [[Seguridad y proteccion de datos]] con HU-029 y el consentimiento; [[Modelo de dominio]] con el pendiente de TUTOR y del historial de matrícula.
- **06-Diseno-UX:** [[Panel por rol]] alineado con lo que de verdad se entrega en la Fase 1.
- **00-Inicio / 02-Scrum:** [[Inicio]] (próximo sprint = Sprint 0), [[Metricas agiles]] e [[Incremento]] actualizados.

## Decisiones pendientes para la dirección del colegio

> ✅ **Actualización:** la dirección respondió el mismo día y aclaró que es un **piloto con datos ficticios**. Ver [[2026-10-28 Decisiones de la direccion]]. Estado: 1 ✅ Gestión 2027 (escenario simulado) · 2 ✅ sistema propio · 3 ◐ tutores con acceso propio ([[EP-09 Acceso de tutores]]); consentimiento pendiente · 4 ✅ RUDE obligatorio · 5 ⏳ credenciales pendientes (Fase 4) · 6 ✅ plantel 1–15 + 1–50 · 7 ◐ cupo y carga horaria se aplican; valores pendientes · 8 ⏳ datos obligatorios del personal · 9 ⏳ MFA docentes (fuera de la Fase 1) · 10 ✅ Sprint 3 = 14/12–24/12 (SM).
1. **¿Con qué gestión arranca el colegio en la plataforma?** ¿Clases de febrero de 2027 (habría que acelerar o reducir las Fases 2–4) o gestión 2028? Esto define el orden de las Fases 2–4.
2. **¿LMS propio o integrado?** Bloquea el contenido del aula (HU-032 y siguientes). Requiere un ADR con el Scrum Master y los Developers.
3. **Tutores:** texto y medio del consentimiento (firma en la oficina o aceptación en línea), ¿más de un tutor por estudiante?, ¿el docente ve el contacto del tutor?, ¿los tutores tendrán acceso propio a futuro?
4. **RUDE:** ¿obligatorio para todos los estudiantes al registrarlos?
5. **Credenciales de estudiantes:** formato de usuario, vigencia de la contraseña temporal, ¿se envían también al celular o correo del tutor? Política de contraseñas y duración de la sesión para estudiantes.
6. **Volúmenes:** cuántas personas tiene el plantel (prioridad de HU-012) y cuántos estudiantes (prioridad de la carga masiva de estudiantes).
7. **Reglas académicas:** cupo máximo por paralelo, carga horaria semanal máxima por docente, periodos (trimestres o bimestres).
8. **Datos obligatorios del personal** en la ficha (HU-030).
9. **MFA para docentes** (ya en la agenda del [[2026-11-03 Taller - Roles y permisos]]).
10. **Para el Scrum Master:** duración real del Sprint 3 (2 semanas como los demás, o un acuerdo explícito por los feriados).

## Orden final del backlog

> ⚠️ Orden **superado** por el reordenamiento del MVP del piloto en [[2026-10-28 Decisiones de la direccion]]. El orden vigente está en [[Backlog del producto]].
| # | ID | Pts | Sprint / fase |
|---|---|---|---|
| 1 | [[HU-001 Iniciar sesion con correo institucional\|HU-001]] | 5 | S1 |
| 2 | [[HU-007 Panel segun rol\|HU-007]] | 5 | S1 |
| 3 | [[HU-002 Cerrar sesion\|HU-002]] | 1 | S1 |
| 4 | [[HU-006 Cambio de contrasena en primer ingreso\|HU-006]] | 3 | S1 |
| 5 | [[HU-013 Registro de auditoria de accesos\|HU-013]] | 3 | S1 |
| 6 | [[HU-003 Recuperar contrasena\|HU-003]] | 5 | S2 |
| 7 | [[HU-004 Bloqueo por intentos fallidos\|HU-004]] | 3 | S2 |
| 8 | [[HU-005 MFA para personal administrativo\|HU-005]] | 8 | S2 |
| 9 | [[HU-029 Mi cuenta datos y cambio de contrasena\|HU-029]] 🆕 | 3 | S2 |
| 10 | [[HU-009 Invitar personal\|HU-009]] | 5 | S3 |
| 11 | [[HU-030 Listado y ficha del personal\|HU-030]] 🆕 | 3 | S3 |
| 12 | [[HU-010 Asignar roles al personal\|HU-010]] | 3 | S3 |
| 13 | [[HU-011 Desactivar cuenta\|HU-011]] | 2 | S3 |
| 14 | [[HU-014 Consultar bitacora de auditoria\|HU-014]] | 5 | S3 |
| 15 | [[HU-008 Gestion de sesiones activas\|HU-008]] | 5 | Cierre Fase 1 |
| 16 | [[HU-012 Carga masiva de personal\|HU-012]] | 8 | Cierre Fase 1 |
| 17 | [[HU-015 Registrar gestion academica\|HU-015]] | 3 | Fase 2 |
| 18 | [[HU-016 Configurar niveles grados y paralelos\|HU-016]] | 5 | Fase 2 |
| 19 | [[HU-017 Catalogo de materias\|HU-017]] | 3 | Fase 2 |
| 20 | [[HU-018 Crear aulas virtuales por paralelo\|HU-018]] | 5 | Fase 2 |
| 21 | [[HU-020 Asignar materias al aula\|HU-020]] | 3 | Fase 3 |
| 22 | [[HU-021 Asignar docente a materia\|HU-021]] | 5 | Fase 3 |
| 23 | [[HU-022 Docente ve sus aulas asignadas\|HU-022]] | 3 | Fase 3 |
| 24 | [[HU-019 Panel del aula virtual\|HU-019]] ✂️ | 3 | Fase 3 |
| 25 | [[HU-033 Registrar estudiante y tutor\|HU-033]] 🆕 | 5 | Fase 3 |
| 26 | [[HU-023 Matricular estudiantes en aula\|HU-023]] ✂️ | 5 | Fase 3 |
| 27 | [[HU-031 Lista de estudiantes del aula\|HU-031]] 🆕 | 2 | Fase 3 |
| 28 | [[HU-034 Credenciales del estudiante para el tutor\|HU-034]] 🆕 | 5 | Fase 4 |
| 29 | [[HU-024 Login de estudiante en la app\|HU-024]] | 8 | Fase 4 |
| 30 | [[HU-025 Estudiante ve sus materias\|HU-025]] | 5 | Fase 4 |
| 31 | [[HU-032 Anuncios del aula\|HU-032]] 🆕 | 5 | Fase 4 (idea, depende del LMS) |
| 32 | [[HU-026 Modo bajo consumo de datos\|HU-026]] | 8 | Fase 4 (idea) |
| 33 | [[HU-027 Consulta rapida para oficina de informacion\|HU-027]] | 5 | Fase 5 (idea) |
| 34 | [[HU-028 Registro de atenciones\|HU-028]] | 3 | Fase 5 (idea) |
| | **Total** | **148** | |

## Acciones
| Acción | Responsable | Fecha |
|---|---|---|
| Presentar las decisiones pendientes 1–8 a la dirección | Product Owner | Taller del 03/11/2026 |
| Confirmar la duración del Sprint 3 y re-estimar HU-020, HU-029 a HU-034 | Scrum Master + Developers | Sprint 0 |
| Definir el stack y descomponer S1–S3 en tareas | Scrum Master | Sprint 0 |
| Wireframes de HU-029 y HU-030 (DoR) | Developers (UX) | Antes del Sprint 2 |
