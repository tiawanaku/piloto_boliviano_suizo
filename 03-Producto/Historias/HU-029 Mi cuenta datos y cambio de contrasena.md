---
tipo: historia
id: HU-029
epica: "[[EP-01 Login plantel administrativo y docentes]]"
sprint: "[[Sprint 2 - Seguridad del login]]"
puntos: 3
estado: refinada
prioridad: alta
orden: 9
roles: [administrativo, docente]
tags: [historia, fase1, autenticacion]
---
# HU-029 · Mi cuenta: ver mis datos y cambiar mi contraseña

Épica: [[EP-01 Login plantel administrativo y docentes]] · Sprint: [[Sprint 2 - Seguridad del login]]

> Agregada en la [[2026-10-28 Revision del Product Owner]]: la política de contraseñas exige poder cambiarla ante sospecha de compromiso, y el menú "Mi cuenta" de [[Panel por rol]] no tenía historia que lo respaldara. Estimación provisional del PO, a confirmar por los Developers.

## Historia
> **Como** miembro del personal
> **quiero** ver mis datos de cuenta y cambiar mi contraseña cuando lo necesite
> **para** comprobar que mis datos son correctos y proteger mi cuenta si sospecho que alguien conoce mi contraseña.

## Criterios de aceptación
```gherkin
Escenario: Ver mis datos
  Dado que tengo una sesión iniciada
  Cuando abro "Mi cuenta"
  Entonces veo mi nombre completo, correo institucional, roles y si tengo MFA activo
  Y veo "Si algún dato es incorrecto, solicita la corrección a secretaría"

Escenario: Cambiar contraseña
  Dado que estoy en "Mi cuenta > Contraseña"
  Cuando ingreso mi contraseña actual correcta y una nueva que cumple la política
  Entonces mi contraseña se actualiza
  Y mis otras sesiones abiertas se cierran
  Y recibo un correo avisando del cambio

Escenario: Contraseña actual incorrecta
  Cuando ingreso mal mi contraseña actual
  Entonces veo "La contraseña actual no es correcta"
  Y el intento cuenta para el bloqueo por intentos fallidos (HU-004)

Escenario: Nueva contraseña no válida
  Cuando la nueva contraseña no cumple la política o es igual a la actual
  Entonces veo qué requisito no se cumple, en lenguaje claro
```

## Notas
- Política: [[Seguridad y proteccion de datos#Política de contraseñas]].
- El cambio queda en auditoría (sin registrar la contraseña) — [[HU-013 Registro de auditoria de accesos]].
- La corrección de datos la hace secretaría en [[HU-030 Listado y ficha del personal]].
