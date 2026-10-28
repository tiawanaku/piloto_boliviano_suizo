---
tipo: historia
id: HU-034
epica: "[[EP-06 App de estudiantes]]"
sprint: ""
puntos: 5
estado: backlog
prioridad: media
orden: 27
tags: [historia, fase4, menores]
---
# HU-034 · Credenciales del estudiante para su tutor

Épica: [[EP-06 App de estudiantes]]

> Agregada en la [[2026-10-28 Revision del Product Owner]]: [[HU-024 Login de estudiante en la app]] supone credenciales y restablecimiento a través del tutor, y ninguna historia los cubría (antes estaban mezclados en HU-023). Estimación provisional del PO.

## Historia
> **Como** secretaria académica
> **quiero** generar el usuario y una contraseña temporal de cada estudiante matriculado y entregárselos a su tutor
> **para** que el estudiante pueda entrar a la app sin necesitar un correo propio.

## Criterios de aceptación
```gherkin
Escenario: Generar credenciales
  Dado que el estudiante tiene matrícula vigente (HU-023)
  Cuando genero sus credenciales
  Entonces se crea un usuario único y una contraseña temporal
  Y obtengo una hoja imprimible para el tutor con el usuario, la contraseña temporal y las instrucciones de ingreso
  Y la contraseña solo se muestra en ese momento

Escenario: Generar para toda el aula
  Cuando genero las credenciales de "1.º Secundaria A — 2027"
  Entonces se crean para los estudiantes que aún no las tienen
  Y obtengo un archivo con una hoja por estudiante

Escenario: Estudiante sin matrícula vigente
  Cuando intento generar credenciales para un estudiante retirado o no matriculado
  Entonces veo "El estudiante no tiene una matrícula vigente"

Escenario: Restablecer a pedido del tutor
  Dado que el tutor registrado (HU-033) pide restablecer el acceso y verifiqué su identidad
  Cuando restablezco las credenciales
  Entonces se genera una nueva contraseña temporal y la anterior deja de funcionar
  Y se cierran las sesiones abiertas del estudiante

Escenario: Auditoría
  Cuando se generan o restablecen credenciales
  Entonces queda registrado quién lo hizo, para qué estudiante y cuándo, nunca la contraseña
```

## Notas
- Permisos: Secretaría académica y Dirección ([[Roles y permisos RBAC]]).
- **Credenciales aún no definidas** por la dirección (pendiente para la Fase 4, [[2026-10-28 Decisiones de la direccion]]): formato del usuario, vigencia de la contraseña temporal y canal de entrega. Con el acceso propio de los tutores ([[EP-09 Acceso de tutores]]), podrían entregarse a través de su cuenta. Refinar antes de la Fase 4.
