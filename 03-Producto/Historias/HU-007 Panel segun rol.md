---
tipo: historia
id: HU-007
epica: "[[EP-01 Login plantel administrativo y docentes]]"
sprint: "[[Sprint 1 - Login base]]"
puntos: 5
estado: aceptada-condicional
prioridad: alta
orden: 2
roles: [administrativo, docente]
tags: [historia, fase1, autorizacion]
---
# HU-007 · Redirección al panel según rol

> ✅ **Aceptada con condición** en la [[2026-11-27 Sprint Review - Sprint 1]]: falta que una persona revise y fusione el PR #1 y que el usuario verifique la experiencia en un navegador real.

> **Como** miembro del personal
> **quiero** llegar directamente al panel que corresponde a mi rol
> **para** ver solo las opciones que necesito y no perderme.

## Criterios de aceptación
```gherkin
Escenario: Docente
  Dado que tengo solo el rol Docente
  Cuando inicio sesión
  Entonces veo el panel docente (mis aulas — vacío hasta la Fase 3, con mensaje explicativo)

Escenario: Administrativo
  Dado que tengo el rol Secretaría académica
  Cuando inicio sesión
  Entonces veo el panel administrativo con las opciones permitidas a mi rol

Escenario: Varios roles
  Dado que tengo los roles Docente y Coordinación pedagógica
  Cuando inicio sesión
  Entonces entro al panel de mi rol principal
  Y puedo cambiar de rol desde el menú sin volver a iniciar sesión

Escenario: Acceso no autorizado por URL
  Dado que soy Docente
  Cuando intento abrir directamente una URL del panel administrativo
  Entonces veo "No tienes permiso para ver esta página"
  Y el intento queda registrado
```

## Notas
- La autorización se valida **en el servidor**, no solo ocultando menús.
- Ver [[Roles y permisos RBAC]] y [[Panel por rol]].
