---
tipo: moc
tags: [moc, reuniones]
---
# 🗓️ Reuniones

Volver a [[Inicio]]

Aquí se guardan las notas de eventos Scrum y reuniones con stakeholders.

- Daily: usar *Daily Notes* (se crean aquí con [[Plantilla Daily Scrum]]).
- Review: [[Plantilla Sprint Review]]
- Retro: [[Plantilla Retrospectiva]]
- Otras: [[Plantilla Reunion]]

Convención de nombre: `AAAA-MM-DD Tipo - Tema`, p. ej. `2026-11-16 Sprint Planning - Sprint 1`.

## Reuniones registradas
```dataview
TABLE tipo_reunion AS "Tipo", sprint AS "Sprint"
FROM "07-Reuniones"
WHERE tipo = "reunion"
SORT file.name DESC
```

- [[2026-10-28 Revision del Product Owner]]
- [[2026-11-03 Taller - Roles y permisos]]
