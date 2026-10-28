---
tipo: historia
id: HU-013
epica: "[[EP-08 Seguridad y auditoria]]"
sprint: "[[Sprint 1 - Login base]]"
puntos: 3
estado: lista
orden: 5
tags: [historia, fase1]
---
# HU-013 · Registro de auditoría de accesos

Épica: [[EP-08 Seguridad y auditoria]] · Sprint: [[Sprint 1 - Login base]]

## Historia
> **Como** responsable de soporte TI
> **quiero** que cada intento de inicio de sesión quede registrado
> **para** poder investigar accesos sospechosos.

## Criterios de aceptación
```gherkin
Escenario: Registro de intento
  Cuando alguien intenta iniciar sesión (con éxito o no)
  Entonces se registra fecha/hora, correo intentado, resultado, IP y navegador
  Y nunca se registra la contraseña

Escenario: Inmutabilidad
  Entonces los registros no pueden ser editados ni borrados desde la aplicación
```

## Notas
La consulta de la bitácora llega en [[HU-014 Consultar bitacora de auditoria]]. Retención sugerida: 1 año.
