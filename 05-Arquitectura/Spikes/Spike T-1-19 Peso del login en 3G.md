---
tipo: spike
sprint: "[[Sprint 1 - Login base]]"
tarea: T-1-19
historia: "[[HU-001 Iniciar sesion con correo institucional]]"
autor: Dev 3
fecha: 2026-10-28
estado: terminado
tags: [arquitectura, spike, rendimiento]
---
# Spike T-1-19 · Peso del login en 3G

Volver a [[Vision de arquitectura]] · Sprint: [[Sprint 1 - Login base]] · Requisito: [[Requisitos no funcionales]] (login < 200 KB, < 10 s en 3G) · Decisión afectada: [[ADR-005 Stack PHP Laravel y Filament]] §4

## Pregunta
¿Cuánto pesa `/admin/login` (y `/docente/login`) con Filament 5 y cuánto tarda en una red 3G lenta? ¿Cumple el presupuesto de 200 KB / 10 s? Si no, ¿qué se puede hacer en la aplicación?

## Cómo se midió
- **Entorno:** copia descartable de `app-colegio/` con el código del Sprint 1 (login propio de Dev 1), `APP_ENV=production`, `APP_DEBUG=false`, `php artisan optimize`, `php artisan filament:assets` y `php artisan serve` en local.
- **Limitación:** en el entorno de desarrollo no hay Chrome ni Lighthouse, así que no se pudo usar DevTools "Slow 3G" ni medir el tiempo hasta interactivo real. Se midió con un script (`curl`/Python) que descarga el HTML y todos los recursos que referencia (CSS, JS, fuentes) y calcula el tamaño **sin comprimir** y **comprimido con gzip -9**, que es lo que enviaría un servidor web con compresión. El tiempo en 3G se estima con el perfil "Slow 3G" de DevTools (~400 kbit/s ≈ 50 KB/s de bajada, latencia alta). Se comprobó con `curl --limit-rate 50k`: `livewire.min.js` (256 KB sin comprimir) tardó 4,7 s.
- **Pendiente:** repetir con Chrome DevTools + Lighthouse en un equipo con navegador, durante T-1-21 o en el Sprint 2.

## Resultados (`/admin/login`; `/docente/login` es idéntico)
| Recurso | Sin comprimir | gzip |
|---|---:|---:|
| HTML del login | 31,3 KB | 5,6 KB |
| `css/filament/filament/app.css` | 673,2 KB | 66,5 KB |
| Fuente Inter (`woff2` latín + `index.css`) | 68,7 KB | 67,4 KB |
| `livewire.min.js` | 255,8 KB | 84,2 KB |
| `js/filament/support/support.js` | 190,7 KB | 64,1 KB |
| `js/filament/filament/echo.js` (*broadcasting*, no se usa) | 89,8 KB | 23,7 KB |
| `js/filament/tables/tables.js` (no se usa en el login) | 29,9 KB | 9,7 KB |
| `app.js`, `notifications.js`, `schemas.js`, `actions.js` | 39,9 KB | 13,3 KB |
| **Total (12 solicitudes)** | **≈ 1 379 KB** | **≈ 334 KB** |

Además, `password-reveal.js` se carga de forma diferida (`x-load-src`) al usar "mostrar contraseña".

**Estimación en Slow 3G (≈ 50 KB/s):**
- Sin compresión (lo que entrega hoy `php artisan serve`): ≈ 1,38 MB → **unos 28 s**. No cumple.
- Con gzip en el servidor web: ≈ 334 KB → ≈ 6,7 s de transferencia más la latencia de 12 solicitudes → **unos 9 a 11 s**. Está en el límite de los 10 s y **supera los 200 KB**.
- Visitas siguientes: los recursos llevan versión (`?v=5.11.0.0`) y se pueden cachear mucho tiempo. Solo viaja el HTML (≈ 6 KB comprimido): **menos de 2 s**.

## Conclusión
**El login de Filament no cumple los 200 KB en la primera visita, ni siquiera comprimido (≈ 334 KB con gzip).** El tiempo queda en el límite de los 10 s solo si el servidor web comprime. El grueso es el núcleo de Filament/Livewire (CSS + `support.js` + `livewire.min.js` ≈ 215 KB comprimidos), que no se puede quitar sin salir de Filament.

## Medidas propuestas
**En la aplicación (piloto):**
1. **Fuentes del sistema** en lugar de Inter: `->font('system-ui, …', provider: SystemFontProvider::class)` en `StaffPanel`, con un `FontProvider` propio que no emite HTML. Probado en el prototipo: la página usa `system-ui`. Ahorra **≈ 67 KB** (el navegador no descarga el `woff2` de Inter si no se usa; queda solo su `index.css` de 0,6 KB, que Filament registra siempre). Resultado: **≈ 267 KB comprimido**. → Tarea propuesta para el Sprint 2 (Dev 1, archivo `StaffPanel`).
2. **Evaluar quitar `echo.js` y `tables.js` del login** (≈ 33 KB comprimidos). Filament los registra como recursos globales y no hay una opción documentada para excluirlos por página. Tiene riesgo de romper otras páginas, así que queda solo como investigación de baja prioridad. Con las medidas 1 y 2 se llegaría a **≈ 234 KB**; sigue por encima de 200 KB.

**En el servidor web (recomendación para una implementación real, fuera del piloto):**
3. Compresión **gzip o brotli** obligatoria (brotli suele ahorrar otro 10–20 % frente a gzip) y `Cache-Control: public, max-age=31536000, immutable` para `/css/filament`, `/js/filament`, `/fonts` y `livewire.min.js`.
4. HTTP/2 o HTTP/3, para que la latencia de 12 solicitudes no sume.

**Al PO / Scrum Master:**
5. Con Filament, el presupuesto realista es **≈ 250–270 KB comprimidos en la primera visita y < 10 KB en las siguientes**. Se propone redefinir el requisito así: "primera visita < 300 KB comprimidos y < 10 s en 3G; visitas siguientes < 50 KB". La alternativa (un login sin Livewire, Blade puro + POST) sí entraría en < 50 KB, pero duplica la lógica del login de Filament (MFA, límites de intentos, auditoría) y no se recomienda en el piloto.
6. Para la app de estudiantes ([[ADR-005 Stack PHP Laravel y Filament]], opción A, panel Filament como PWA) este peso es un **riesgo**: la decisión de la Fase 4 debe tener en cuenta esta medición.

## Propuesta de cambio al ADR-005 (para el Scrum Master)
En §4, en la viñeta "La pantalla de login debe cumplir el presupuesto de < 200 KB … **(spike)** medir el peso real…", reemplazar la marca "(spike)" por:
> Medido en el [[Spike T-1-19 Peso del login en 3G]]: ≈ 334 KB con gzip (1,38 MB sin comprimir); con fuentes del sistema ≈ 267 KB. Filament no permite bajar de ~230 KB sin salir de Livewire. Se usan fuentes del sistema y se exige compresión y caché larga en el servidor web; el presupuesto de [[Requisitos no funcionales]] se revisa con el PO.
