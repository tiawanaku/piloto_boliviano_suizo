---
tipo: reunion
tipo_reunion: retro
fecha: 2026-11-13
sprint: "[[Sprint 0 - Preparacion]]"
tags: [reunion, retro]
---
# Retrospectiva · Sprint 0

Volver a [[Reuniones MOC]] · Sprint: [[Sprint 0 - Preparacion]] · Facilita: [[Scrum Master]] · Plantilla: [[Plantilla Retrospectiva]]

**Participantes:** Developers (Dev 1, Dev 2, Dev 3), Scrum Master. El Product Owner fue invitado.
Dinámica usada: Start / Stop / Continue.

**Datos del sprint:** 11 tareas técnicas, 10 hechas y 1 parcial (T-0-07). Calidad local: `pint` OK, `phpstan` sin errores, `pest` 43/43, `composer audit` limpio. El arranque desde cero con el README funciona (verificado por el SM en una copia limpia). Detalle en [[Sprint 0 - Preparacion#Cierre del sprint (13/11/2026)]].

## Seguimiento de acciones de la retro anterior
- No aplica (primer sprint).

## 🟢 Empezar a hacer
- **Ejecutar el CI en GitHub desde el primer PR.** El workflow quedó listo pero nunca corrió: "CI en verde" se verificó solo con los mismos comandos en local.
- **Registrar la deuda técnica el mismo día en que se acepta** (p. ej. el `notPath` de Pint): se detectó recién en el cierre.
- **Pedir los permisos externos el día 1** (administración del repositorio, red/proxy). La protección de `main` se trabó por un 403 al final del sprint.

## 🔴 Dejar de hacer
- Crear archivos fuera de la lista del paquete sin avisar (`lang/es/demo.php`). El archivo era razonable, pero el aviso evita solapamientos cuando el equipo trabaja en paralelo.
- Aceptar exclusiones de herramientas de calidad (`notPath`) como solución permanente.

## 🔵 Continuar haciendo
- Paquetes con **dueño único por archivo** y una tarea "primero" que desbloquea: no hubo conflictos de *merge*.
- Pruebas Pest con el nombre del criterio en español; pruebas de humo y de comandos (`colegio:demo`, correo de prueba).
- README verificable: otra persona pudo arrancar el proyecto desde cero solo con él.
- Reportar los impedimentos con su solución temporal (caché de Composer ante el bloqueo del proxy).

## ¿La Definición de Terminado sigue siendo adecuada?
- Sí, sin relajarla. Se observa que **"PR revisado por otra persona"** y **"CI en verde"** no se pudieron demostrar en el Sprint 0: los cambios se integraron sin PR y el CI no corrió en GitHub. A partir del Sprint 1, cada tarea se integra por PR con CI (TEC-19) y, cuando el administrador la active, con protección de `main` (TEC-20).

## Acciones de mejora (máx. 3)
| Acción | Responsable | Se agrega al Sprint Backlog |
|---|---|---|
| Quitar `notPath` de Pint y la prueba trivial el día 1 del S1, antes de editar los archivos del esqueleto (TEC-18 → T-1-22) | Dev 2 | [x] Sprint 1 |
| Quitar el filtro `paths` del CI y verificar la primera ejecución en GitHub; desde ahí, toda tarea entra por PR con CI en verde (TEC-19 → T-1-23) | Dev 2 | [x] Sprint 1 |
| Conseguir la protección de `main` con el dueño del repositorio y revisar en cada Daily los impedimentos externos abiertos (TEC-20) | Scrum Master | [x] Sprint 1 (impedimento) |

Ver también: [[Backlog tecnico#Deuda técnica]].
