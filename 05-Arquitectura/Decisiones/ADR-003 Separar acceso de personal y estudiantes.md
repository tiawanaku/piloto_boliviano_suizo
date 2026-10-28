---
tipo: adr
id: ADR-003
estado: aceptada
fecha: 2026-10-28
tags: [adr, autenticacion]
---
# ADR-003 · Separar el acceso del personal y el de estudiantes

Volver a [[Vision de arquitectura]]

## Contexto
Personal y estudiantes tienen necesidades distintas: el personal administra datos sensibles desde computadora; los estudiantes (muchos menores, sin correo propio) usan principalmente el celular.

## Decisión
- **Portal del personal** (web) con login por correo institucional + MFA ([[EP-01 Login plantel administrativo y docentes]]).
- **App de estudiantes** con login por usuario asignado por el colegio ([[EP-06 App de estudiantes]]).
- **Una sola base de identidades** con perfiles distintos ([[Modelo de dominio]]); un estudiante nunca puede ingresar al portal del personal y viceversa.

## Consecuencias
- ✅ Superficie de ataque reducida en el portal administrativo.
- ✅ Permite priorizar el login del personal primero (Fase 1) sin bloquear la app (Fase 4).
- ⚠️ Dos flujos de recuperación de acceso que mantener.
