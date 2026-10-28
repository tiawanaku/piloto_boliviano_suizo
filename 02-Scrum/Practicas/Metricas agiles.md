---
tipo: concepto
tags: [scrum/practica, metricas]
---
# Métricas ágiles

Volver a [[Scrum MOC]]

## Velocidad
Puntos de historia **terminados (DoD)** por sprint. Sirve para *pronosticar*, no para comparar equipos ni presionar.

| Sprint | Comprometidos | Terminados |
|---|---|---|
| [[Sprint 1 - Login base]] | 17 | 17\* |
| [[Sprint 2 - Seguridad del login]] | 19 | _pendiente_ |
| [[Sprint 3 - Gestion de personal]] | 18 | _pendiente_ |

\* Sprint 1: los 17 pts cumplen la DoD en código, pruebas y CI (397 pruebas, CI de GitHub en verde), pero quedan **condicionados** a la verificación manual de experiencia en navegador real en la Sprint Review. Si una historia falla, vuelve al backlog y esta cifra se corrige. Ver [[2026-11-27 Retrospectiva - Sprint 1]].

**Velocidad actual:** 17 pts (1 sprint con datos). La previsión del Sprint 2 (19 pts) está dentro del rango estimado de 15–20, pero suma trabajo técnico no estimado en puntos (TEC-21, TEC-22, DEF-01, DEF-02). Si hay que recortar, sale primero HU-029 (decisión del PO).

Velocidad media (últimos 3 sprints) → capacidad referencial para la [[Sprint Planning]].

## Burndown del sprint
Trabajo restante vs. días. Detecta temprano si el [[Objetivo del sprint]] está en riesgo.

## Burnup del producto
Trabajo terminado acumulado vs. alcance total; muestra cambios de alcance.

## Lead time / Cycle time
Tiempo desde que se pide algo hasta que se entrega / desde que se empieza hasta que se termina.

## Métricas de producto (las más importantes)
Ver [[Vision del producto#Métricas de éxito (indicadores)]].
