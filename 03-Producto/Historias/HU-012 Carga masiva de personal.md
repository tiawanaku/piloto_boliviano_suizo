---
tipo: historia
id: HU-012
epica: "[[EP-02 Gestion de usuarios y roles]]"
sprint: ""
puntos: 8
estado: backlog
orden: 14
tags: [historia, fase1]
---
# HU-012 · Carga masiva de personal (CSV)

Épica: [[EP-02 Gestion de usuarios y roles]]

## Historia
> **Como** secretaria académica al inicio de gestión
> **quiero** cargar a todo el personal desde una planilla CSV
> **para** no registrar decenas de personas una por una.

## Criterios de aceptación
```gherkin
Escenario: Carga válida
  Cuando subo un CSV con el formato de la plantilla descargable
  Entonces veo una vista previa con las filas válidas y los errores por fila
  Y al confirmar se crean las cuentas y se envían las invitaciones

Escenario: Errores
  Cuando el archivo tiene correos duplicados o roles inexistentes
  Entonces esas filas se marcan y no se importan
```

## Notas
Candidata a dividir (vista previa / importación / reporte). 8 pts.
