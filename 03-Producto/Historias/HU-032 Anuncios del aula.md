---
tipo: historia
id: HU-032
epica: "[[EP-04 Aulas virtuales]]"
sprint: ""
puntos: 5
estado: idea
prioridad: baja
orden: 31
tags: [historia, fase4]
---
# HU-032 · Anuncios del aula

Épica: [[EP-04 Aulas virtuales]]

> Surge de la división de [[HU-019 Panel del aula virtual]] en la [[2026-10-28 Revision del Product Owner]]. Queda en **idea** hasta que se decida si el aula usa un LMS propio o uno integrado (ver [[EP-04 Aulas virtuales]]). Estimación provisional del PO.

## Historia
> **Como** docente
> **quiero** publicar anuncios para toda el aula o solo para mi materia
> **para** avisar a mis estudiantes de clases, tareas o cambios sin usar chats externos.

## Criterios de aceptación
```gherkin
Escenario: Publicar anuncio
  Dado que soy docente asignado al aula
  Cuando publico un anuncio con título y texto (máx. 2000 caracteres) para "Toda el aula" o para "Matemática"
  Entonces aparece en el aula, del más reciente al más antiguo, con mi nombre y la fecha
  Y en la Fase 4 lo ven los estudiantes de esa aula en su app

Escenario: Anuncio vacío
  Cuando intento publicar sin título o sin texto
  Entonces veo qué falta y no se publica

Escenario: Editar o eliminar
  Cuando edito o elimino un anuncio que yo publiqué
  Entonces el cambio se refleja en el aula y queda registrado

Escenario: Anuncio de otra persona
  Cuando intento editar un anuncio publicado por otro docente
  Entonces la acción no está permitida

Escenario: Sin asignación
  Dado que no tengo asignación en el aula
  Cuando intento publicar en ella
  Entonces se deniega la acción
```
