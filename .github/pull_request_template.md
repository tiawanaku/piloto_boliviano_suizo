## Qué cambia

<!-- Resumen en 1-3 líneas. -->

**Historia / tarea:** <!-- p. ej. HU-001 · T-1-03 (enlace a la nota del vault) -->

## Escenarios de aceptación cubiertos

<!-- Un renglón por escenario Gherkin con el nombre de su prueba Pest. -->
| Escenario | Prueba Pest |
|---|---|
|  |  |

## Lista de verificación (Definición de Terminado)

### Código y calidad
- [ ] `vendor/bin/pint --test` sin cambios pendientes.
- [ ] `vendor/bin/phpstan analyse` (Larastan nivel 6) sin errores ni baseline.
- [ ] `vendor/bin/pest` en verde; cobertura de lo nuevo ≥ 80 % (`--coverage --min=80` en CI).
- [ ] `composer audit` sin vulnerabilidades altas/críticas.
- [ ] Cada escenario Gherkin de la historia tiene al menos una prueba Pest con su nombre.
- [ ] `declare(strict_types=1);` en los archivos PHP nuevos.

### Seguridad y privacidad
- [ ] Autorización por *Policy*/`Gate` en el servidor, con prueba de un rol sin acceso (403).
- [ ] Acciones sensibles registradas en auditoría.
- [ ] Ninguna contraseña, token, secreto ni dato personal en logs ni en `audit_events`.
- [ ] Sin secretos en el repositorio.

### Experiencia de usuario
- [ ] Textos de UI en `lang/es`, en español claro.
- [ ] Probado en Chrome, Firefox y móvil (vista responsive); accesibilidad básica (etiquetas, contraste, teclado).

### Alcance piloto
- [ ] Solo datos ficticios (`@colegio-piloto.test`), ningún dato real de personas ni de menores.
- [ ] Demostrable con `php artisan colegio:demo` + `composer dev`.
- [ ] Documentación del vault actualizada (historia, tarea del sprint, ADR si aplica).

## Capturas

<!-- Capturas o GIF de la UI afectada (escritorio y móvil), si aplica. -->

## Notas para la revisión

<!-- Decisiones técnicas, deuda técnica, dudas. Se requiere 1 revisión de otro developer. -->
