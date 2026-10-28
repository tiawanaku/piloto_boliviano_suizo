---
tipo: proyecto
tags: [proyecto, vision]
aliases: [Visión, Product Vision]
---
# Visión del producto

Volver a [[Inicio]]

## Declaración de visión
> **Para** estudiantes, familias, docentes y personal de un colegio que funciona **100 % en línea**,
> **que** necesitan enseñar, aprender y gestionar la vida escolar sin aulas físicas,
> **la Plataforma del Colegio Virtual** es un sistema web + app móvil
> **que** centraliza el acceso seguro, la organización académica (gestiones, grados, paralelos, materias) y las aulas virtuales,
> **a diferencia de** usar herramientas sueltas (chats, correos, hojas de cálculo, videollamadas sin estructura),
> **nuestro producto** ofrece una sola puerta de entrada con roles claros, trazabilidad y una experiencia pensada para conexiones de baja calidad.

## Objetivo del producto (Product Goal)
> *"Que cada miembro del colegio — personal, docentes y estudiantes — acceda de forma segura a su espacio virtual y encuentre allí, organizado, todo lo que necesita para enseñar o aprender."*

Ver concepto: [[Objetivo del producto]].

## Objetivos por fase
| Fase | Resultado esperado | Épicas |
|---|---|---|
| 1 | Personal administrativo y docente ingresa de forma segura y ve su panel según rol | [[EP-01 Login plantel administrativo y docentes]], [[EP-02 Gestion de usuarios y roles]], [[EP-08 Seguridad y auditoria]] |
| 2 | La estructura académica y las aulas virtuales existen en el sistema | [[EP-03 Estructura academica]], [[EP-04 Aulas virtuales]] |
| 3 | Cursos y materias asignados a docentes dentro de las aulas | [[EP-05 Asignacion de cursos y materias]] |
| 4 | Estudiantes acceden mediante su aplicativo | [[EP-06 App de estudiantes]] |
| 5 | Oficina de información conectada a la plataforma | [[EP-07 Oficina de informacion]] |

Detalle: [[Fases y roadmap]].

## Principios del producto
1. **Virtual primero**: todo proceso debe poder completarse en línea; la oficina física solo informa.
2. **Seguro por defecto**: cuentas creadas por el colegio, sin auto-registro del personal. Ver [[Seguridad y proteccion de datos]].
3. **Mínimo privilegio**: cada rol ve y hace solo lo necesario. Ver [[Roles y permisos RBAC]].
4. **Ligero y accesible**: funciona con poco ancho de banda y en celulares de gama baja. Ver [[Accesibilidad y conectividad]].
5. **Entrega incremental**: cada sprint produce un [[Incremento]] usable.

## Métricas de éxito (indicadores)
- % de personal que ingresa sin ayuda en su primer intento (meta ≥ 90 %).
- Tiempo medio de inicio de sesión < 10 s en 3G.
- 0 incidentes de acceso no autorizado.
- % de aulas virtuales con docentes asignados al inicio de la gestión (meta 100 %).
- Satisfacción del personal (encuesta) ≥ 4/5.
