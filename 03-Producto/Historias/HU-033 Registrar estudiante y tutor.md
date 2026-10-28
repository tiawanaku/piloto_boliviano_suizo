---
tipo: historia
id: HU-033
epica: "[[EP-05 Asignacion de cursos y materias]]"
sprint: ""
puntos: 5
estado: backlog
prioridad: alta
orden: 22
tags: [historia, fase3, menores, mvp-2027]
---
# HU-033 · Registrar estudiante y su tutor

Épica: [[EP-05 Asignacion de cursos y materias]]

> Surge de dividir [[HU-023 Matricular estudiantes en aula]] en la [[2026-10-28 Revision del Product Owner]]: el tutor y el consentimiento para tratar datos de menores no tenían historia propia. Estimación provisional del PO.

## Historia
> **Como** secretaria académica
> **quiero** registrar a cada estudiante con sus datos mínimos y los de su madre, padre o tutor legal, incluido su consentimiento
> **para** poder matricularlo, saber a quién contactar y a quién entregar sus credenciales.

## Criterios de aceptación
```gherkin
Escenario: Registro completo
  Dado que soy Secretaría académica o Dirección
  Cuando registro al estudiante (nombres, apellidos, fecha de nacimiento, código RUDE y CI si tiene)
  Y a su tutor (nombres, apellidos, CI, parentesco, celular y correo opcional)
  Y marco que el tutor otorgó el consentimiento, con fecha y medio
  Entonces el estudiante queda "registrado", aún sin matrícula

Escenario: Consentimiento obligatorio
  Cuando intento guardar sin registrar el consentimiento del tutor
  Entonces veo "Falta el consentimiento del tutor para el tratamiento de datos" y no se guarda

Escenario: RUDE obligatorio
  Cuando intento guardar a un estudiante sin código RUDE o con un RUDE de formato inválido
  Entonces veo "El código RUDE es obligatorio" o "El código RUDE no tiene un formato válido"
  Y no se guarda

Escenario: Estudiante duplicado
  Cuando registro un RUDE o un CI que ya existe
  Entonces veo "Ya existe un estudiante con ese RUDE/CI" y el enlace a su ficha

Escenario: Tutor con varios hijos
  Dado que el tutor ya está registrado por otro estudiante
  Cuando ingreso su CI
  Entonces se me ofrece vincularlo, sin volver a cargar sus datos

Escenario: Datos inválidos
  Cuando falta un dato obligatorio o la fecha de nacimiento es futura
  Entonces veo el error junto a cada campo y no se guarda

Escenario: Sin permiso
  Dado que soy Docente, Coordinación pedagógica u Oficina de información
  Cuando intento registrar o editar un estudiante o un tutor
  Entonces la acción no está permitida
```

## Notas
- Se recolecta el **mínimo** necesario; el registro y cada cambio quedan en auditoría ([[Seguridad y proteccion de datos]] · Ley N.º 548 en [[Marco normativo Bolivia]]).
- **RUDE obligatorio** para todo estudiante (decisión de la dirección, [[2026-10-28 Decisiones de la direccion]]). Es el Registro Único de Estudiantes del sistema educativo boliviano; el formato exacto a validar lo confirma secretaría.
- El **mecanismo** de consentimiento sigue pendiente; esta historia solo registra que existe (fecha y medio). Si se decide en línea, ver [[HU-038 Consentimiento en linea del tutor]].
- Los tutores tendrán acceso propio ([[EP-09 Acceso de tutores]]): registrar celular y correo con cuidado, porque serán su canal de invitación.
- Pendiente: más de un tutor por estudiante, quién ve los datos del tutor.
