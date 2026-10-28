---
tipo: proyecto
tags: [proyecto, contexto]
---
# Contexto del colegio virtual

Volver a [[Inicio]] · Relacionado: [[Vision del producto]] · [[Stakeholders]]

> 🧪 **Proyecto piloto / demostración.** No es una puesta en producción real del colegio: se trabaja con **datos 100 % ficticios** (personas, estudiantes, RUDE y correos inventados, dominio `@colegio-piloto.test`), sin despliegue a producción ni compromisos operativos reales. La **Gestión 2027** es el escenario simulado del piloto, no una fecha de salida. Ver [[2026-10-28 Decisiones de la direccion]].

## Modelo del colegio
- **Netamente virtual**: no existen aulas físicas. Clases, tareas, evaluaciones y comunicación ocurren en la plataforma.
- **Oficinas físicas solo para información**: orientación a familias, consultas de inscripción, entrega de documentación. Ver [[EP-07 Oficina de informacion]].
- **Piloto** con enfoque de cooperación (proyecto *piloto boliviano-suizo*), por lo que la trazabilidad, la documentación y el aprendizaje del proceso son parte del entregable.

## Estructura académica (referencia Bolivia)
> Validar con la normativa vigente — ver [[Marco normativo Bolivia]].

- **Niveles**: Educación Inicial en Familia Comunitaria · Educación Primaria Comunitaria Vocacional · Educación Secundaria Comunitaria Productiva.
- **Gestión escolar** anual, organizada en periodos de evaluación (p. ej. trimestres).
- **Grado → Paralelo → Aula virtual**: cada paralelo de cada grado tiene un aula virtual.

```mermaid
flowchart TD
    G[Gestión 2027] --> N1[Primaria]
    G --> N2[Secundaria]
    N2 --> GR1[1.º de Secundaria]
    GR1 --> P1[Paralelo A = Aula virtual]
    GR1 --> P2[Paralelo B = Aula virtual]
    P1 --> M1[Matemática · Docente X]
    P1 --> M2[Lenguaje · Docente Y]
    P1 --> E[Estudiantes matriculados]
```

## Escala del piloto
- Plantel **administrativo: 1 a 15 personas**; plantel **docente: 1 a 50 personas** (≤ 65 cuentas del personal). Datos ficticios.
- Número de estudiantes: por definir; se simula con datos ficticios.
- Gestión simulada: **2027**.

## Actores y canales de acceso
| Actor | Canal | Fase |
|---|---|---|
| Plantel administrativo | Portal web del personal | 1 |
| Docentes | Portal web del personal (y móvil responsive) | 1 |
| Estudiantes | **Aplicativo de estudiantes** (móvil + web) | 4 |
| Padres / tutores | **Acceso propio** ([[EP-09 Acceso de tutores]]); se registran con su consentimiento en [[HU-033 Registrar estudiante y tutor]] | 3 (registro) / 4 (acceso) |
| Personal de oficina de información | Portal web del personal (rol propio) | 1 / 5 |

## Restricciones y realidades
- Conectividad variable (urbana/rural); muchos usuarios con datos móviles. Ver [[Accesibilidad y conectividad]].
- Dispositivos compartidos en el hogar → importancia de cerrar sesión y expiración. Ver [[HU-002 Cerrar sesion]].
- Datos de menores de edad → protección reforzada. Ver [[Seguridad y proteccion de datos]].
- Personal con distintos niveles de alfabetización digital → interfaz simple y guías.
