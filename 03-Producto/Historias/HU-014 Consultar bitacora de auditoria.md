---
tipo: historia
id: HU-014
epica: "[[EP-08 Seguridad y auditoria]]"
sprint: "[[Sprint 3 - Gestion de personal]]"
puntos: 5
estado: refinada
orden: 13
tags: [historia, fase1]
---
# HU-014 · Consultar bitácora de auditoría

Épica: [[EP-08 Seguridad y auditoria]] · Sprint: [[Sprint 3 - Gestion de personal]]

## Historia
> **Como** responsable de soporte TI o dirección
> **quiero** buscar y filtrar eventos de auditoría
> **para** detectar accesos indebidos y responder a incidentes.

## Criterios de aceptación
```gherkin
Escenario: Filtrar
  Cuando filtro por usuario, tipo de evento y rango de fechas
  Entonces veo los eventos ordenados del más reciente al más antiguo

Escenario: Exportar
  Cuando exporto el resultado
  Entonces obtengo un CSV y la exportación también queda auditada
```

## Notas
Solo roles Dirección y Soporte TI ([[Roles y permisos RBAC]]).
