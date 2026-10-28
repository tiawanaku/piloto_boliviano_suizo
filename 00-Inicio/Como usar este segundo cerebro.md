---
tipo: guia
tags: [guia, obsidian]
---
# Cómo usar este segundo cerebro

Volver a [[Inicio]]

## Abrir el vault
1. Instala [Obsidian](https://obsidian.md).
2. *Open folder as vault* → selecciona la carpeta raíz de este repositorio.
3. Abre [[Inicio]] (también está en Marcadores).

## Estructura de carpetas

| Carpeta | Propósito |
|---|---|
| `00-Inicio` | Punto de entrada, guías y glosario |
| `01-Proyecto` | Contexto del colegio virtual y del proyecto |
| `02-Scrum` | Conocimiento de Scrum (roles, eventos, artefactos, prácticas) |
| `03-Producto` | Backlog, épicas e historias de usuario |
| `04-Sprints` | Una nota por sprint |
| `05-Arquitectura` | Diseño técnico y decisiones (ADR) |
| `06-Diseno-UX` | Pantallas, flujos, accesibilidad |
| `07-Reuniones` | Notas de dailies, reviews, retros y reuniones |
| `08-Plantillas` | Plantillas (plugin *Templates*) |
| `09-Recursos` | Referencias, normativa, adjuntos |

## Convenciones

- **Nombres de archivo** sin tildes (compatibilidad Windows/Mac/Linux); el título dentro de la nota sí lleva tildes.
- **Identificadores:** épicas `EP-XX`, historias `HU-XXX`, decisiones `ADR-XXX`.
- **Propiedades (frontmatter)** comunes:
  - `tipo`: moc, concepto, epica, historia, sprint, adr, reunion, guia
  - `estado`: idea · backlog · refinada · lista · en-progreso · en-revision · terminada · descartada
  - `prioridad`: alta · media · baja (orden real = posición en [[Backlog del producto]])
  - `puntos`: estimación en puntos de historia (Fibonacci)
  - `sprint`: enlace al sprint
- **Etiquetas:** `#scrum/rol`, `#scrum/evento`, `#scrum/artefacto`, `#scrum/practica`, `#epica`, `#historia`, `#fase1`…
- **Enlaza siempre**: cada historia enlaza su épica; cada sprint enlaza sus historias. Así el *Graph view* muestra el mapa real del proyecto.

## Plantillas
Configuradas en `08-Plantillas` (plugin núcleo *Templates*). Usa `Ctrl/Cmd + P → Templates: Insert template`.

- [[Plantilla Historia de usuario]]
- [[Plantilla Epica]]
- [[Plantilla Sprint]]
- [[Plantilla Daily Scrum]]
- [[Plantilla Sprint Review]]
- [[Plantilla Retrospectiva]]
- [[Plantilla ADR]]
- [[Plantilla Reunion]]
- [[Plantilla Nota de conocimiento]]

## Plugins comunitarios recomendados (opcionales)
- **Dataview** — las notas incluyen consultas ` ```dataview ` que generan tablas automáticas (backlog, historias por épica). Sin el plugin verás el código, pero las listas manuales siguen funcionando.
- **Kanban** — tablero visual del Sprint Backlog.
- **Templater** — plantillas con lógica avanzada.

## Flujo de trabajo diario
1. Abrir el sprint actual desde [[Inicio]].
2. Crear la nota diaria (Daily Notes → se guarda en `07-Reuniones`).
3. Actualizar el `estado` de las historias trabajadas.
4. Registrar decisiones técnicas como ADR en `05-Arquitectura/Decisiones`.
5. Capturar aprendizajes en notas de concepto y enlazarlas.
