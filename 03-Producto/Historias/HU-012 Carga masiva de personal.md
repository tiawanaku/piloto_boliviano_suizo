---
tipo: historia
id: HU-012
epica: "[[EP-02 Gestion de usuarios y roles]]"
sprint: ""
puntos: 8
estado: backlog
prioridad: media
orden: 16
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
Escenario: Plantilla
  Cuando descargo la plantilla
  Entonces obtengo un CSV con las columnas nombres, apellidos, CI, correo institucional y rol(es)

Escenario: Vista previa
  Cuando subo un CSV con el formato de la plantilla
  Entonces veo una vista previa con las filas válidas y los errores por fila
  Y nada se crea hasta que confirmo

Escenario: Filas con errores
  Cuando hay correos o CI duplicados (en el archivo o ya registrados), correos fuera del dominio, roles inexistentes o campos vacíos
  Entonces esas filas se marcan con su motivo y no se importan
  Y las filas válidas sí pueden importarse

Escenario: Archivo inválido
  Cuando subo un archivo que no es CSV, tiene otras columnas o supera 500 filas
  Entonces se rechaza completo con un mensaje que explica el problema

Escenario: Confirmar importación
  Cuando confirmo
  Entonces se crean las cuentas en estado "pendiente" y se envían las invitaciones (HU-009)
  Y puedo descargar un reporte con el resultado de cada fila
  Y la carga queda en auditoría con su resumen
```

## Notas
- Depende de [[HU-009 Invitar personal]] y [[HU-010 Asignar roles al personal]].
- Su prioridad depende de cuántas personas tiene el plantel (**decisión pendiente** de la dirección). Si los Developers la estiman en más de 8, dividir en vista previa / importación y reporte.
