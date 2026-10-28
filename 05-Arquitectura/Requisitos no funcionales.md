---
tipo: arquitectura
tags: [arquitectura, rnf]
aliases: [RNF]
---
# Requisitos no funcionales

Volver a [[Vision de arquitectura]]

> 🧪 Piloto con datos ficticios: los requisitos marcados "fuera del alcance del piloto" aplican solo a una eventual implementación real ([[2026-10-28 Decisiones de la direccion]]).

| Categoría | Requisito | Medida |
|---|---|---|
| Rendimiento | Login rápido en redes lentas | < 10 s en 3G; página de login < 200 KB |
| Disponibilidad | Plataforma disponible en horario escolar | **Fuera del alcance del piloto** (referencia para implementación real: ≥ 99,5 % lun–sáb 06:00–22:00) |
| Escalabilidad | Picos al inicio de clases | Piloto: ≤ 15 administrativos + ≤ 50 docentes (≤ 65 cuentas) y estudiantes ficticios; soportar a todos ingresando en 15 min |
| Seguridad | Protección de credenciales y datos | Ver [[Seguridad y proteccion de datos]] |
| Usabilidad | Personal sin experiencia técnica | ≥ 90 % login sin ayuda |
| Accesibilidad | Inclusión | Pautas WCAG 2.1 nivel AA ([[Accesibilidad y conectividad]]) |
| Compatibilidad | Dispositivos variados | Navegadores modernos, Android 8+ |
| Respaldo | Recuperación ante desastres | **Fuera del alcance del piloto** (datos ficticios, se regeneran con *seeders*); referencia real: backup diario, restauración trimestral |
| Trazabilidad | Auditoría | Eventos de acceso y cambios sensibles retenidos 1 año |
| Idioma | Interfaz | Español; preparado para otros idiomas en el futuro |
