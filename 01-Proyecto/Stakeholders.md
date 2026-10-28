---
tipo: proyecto
tags: [proyecto, stakeholders]
aliases: [Interesados, Partes interesadas]
---
# Stakeholders (partes interesadas)

Volver a [[Inicio]]

| Stakeholder | Interés | Influencia | Necesidad principal | Participa en |
|---|---|---|---|---|
| Dirección del colegio | Alto | Alta | Control, reportes, cumplimiento | [[Sprint Review]] |
| Secretaría académica | Alto | Media | Gestionar personal, matrícula, estructura | Review, refinamiento |
| Coordinación pedagógica | Alto | Media | Asignar docentes/materias, seguimiento | Review, refinamiento |
| Docentes (1–50 en el piloto) | Alto | Media | Acceso simple a sus aulas y materias | Review, pruebas de usabilidad con datos ficticios |
| Soporte TI | Medio | Media | Administración de cuentas, seguridad | Refinamiento técnico |
| Oficina de información | Medio | Baja | Consultar datos para atender al público | Review |
| Estudiantes | Alto | Baja (fase 1) | App fácil, liviana | Pruebas (fase 4) |
| Padres / tutores | Alto | Media | Seguimiento de sus hijos (acceso propio: [[EP-09 Acceso de tutores]]) | Encuestas, pruebas (Fase 4) |
| Cooperación / financiadores del piloto | Medio | Alta | Resultados medibles y documentados | Review de hitos |
| Autoridad educativa | Bajo-medio | Alta | Cumplimiento normativo | Según requiera |

## Mapa de poder / interés
```mermaid
quadrantChart
    title Poder vs Interés
    x-axis Bajo interés --> Alto interés
    y-axis Baja influencia --> Alta influencia
    quadrant-1 Gestionar de cerca
    quadrant-2 Mantener satisfechos
    quadrant-3 Monitorear
    quadrant-4 Mantener informados
    Direccion: [0.9, 0.9]
    Financiadores: [0.55, 0.85]
    Autoridad educativa: [0.3, 0.8]
    Secretaria: [0.85, 0.6]
    Coordinacion: [0.85, 0.55]
    Docentes: [0.8, 0.45]
    Padres: [0.75, 0.5]
    Soporte TI: [0.5, 0.5]
    Estudiantes: [0.8, 0.2]
    Oficina info: [0.45, 0.2]
```

El [[Product Owner]] es quien representa y equilibra estos intereses en el [[Backlog del producto]].
