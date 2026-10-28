---
tipo: arquitectura
tags: [arquitectura, rnf]
aliases: [RNF]
---
# Requisitos no funcionales

Volver a [[Vision de arquitectura]]

| Categoría | Requisito | Medida |
|---|---|---|
| Rendimiento | Login rápido en redes lentas | < 10 s en 3G; página de login < 200 KB |
| Disponibilidad | Plataforma disponible en horario escolar | ≥ 99,5 % lun–sáb 06:00–22:00 |
| Escalabilidad | Picos al inicio de clases | Soportar a todo el colegio ingresando en 15 min |
| Seguridad | Protección de credenciales y datos | Ver [[Seguridad y proteccion de datos]] |
| Usabilidad | Personal sin experiencia técnica | ≥ 90 % login sin ayuda |
| Accesibilidad | Inclusión | Pautas WCAG 2.1 nivel AA ([[Accesibilidad y conectividad]]) |
| Compatibilidad | Dispositivos variados | Navegadores modernos, Android 8+ |
| Respaldo | Recuperación ante desastres | Backup diario, restauración probada cada trimestre |
| Trazabilidad | Auditoría | Eventos de acceso y cambios sensibles retenidos 1 año |
| Idioma | Interfaz | Español; preparado para otros idiomas en el futuro |
