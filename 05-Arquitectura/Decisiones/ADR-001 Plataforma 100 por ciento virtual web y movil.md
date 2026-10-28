---
tipo: adr
id: ADR-001
estado: aceptada
fecha: 2026-10-28
tags: [adr, arquitectura]
---
# ADR-001 · Plataforma 100 % virtual: portal web + app móvil

Volver a [[Vision de arquitectura]]

## Contexto
El colegio no tendrá aulas físicas; solo oficinas de información. Todos los procesos académicos deben realizarse en línea. Los usuarios tienen dispositivos y conectividad variados ([[Contexto del colegio virtual]]).

## Decisión
Construir una plataforma con:
1. **Portal web responsive** para plantel administrativo y docentes.
2. **Aplicativo para estudiantes** (móvil, con versión web).
3. **Backend único** (API) compartido por ambos clientes.

## Consecuencias
- ✅ Un solo backend y modelo de datos.
- ✅ Cada cliente optimizado para su público.
- ⚠️ Dos interfaces que mantener.
- ⚠️ Requiere diseño liviano para baja conectividad ([[Accesibilidad y conectividad]]).
