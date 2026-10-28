---
tipo: historia
id: HU-001
epica: "[[EP-01 Login plantel administrativo y docentes]]"
sprint: "[[Sprint 1 - Login base]]"
puntos: 5
estado: aceptada-condicional
prioridad: alta
orden: 1
roles: [administrativo, docente]
tags: [historia, fase1, autenticacion]
---
# HU-001 · Iniciar sesión con correo institucional

> ✅ **Aceptada con condición** en la [[2026-11-27 Sprint Review - Sprint 1]]: falta que una persona revise y fusione el PR #1 y que el usuario verifique la experiencia en un navegador real.

## Historia
> **Como** miembro del personal (administrativo o docente)
> **quiero** iniciar sesión con mi correo institucional y contraseña
> **para** acceder a la plataforma del colegio sin depender de otra persona.

## Criterios de aceptación
```gherkin
Escenario: Inicio de sesión exitoso
  Dado que tengo una cuenta activa con correo "ana.perez@colegio-piloto.test"
  Cuando ingreso ese correo y mi contraseña correcta y presiono "Ingresar"
  Entonces accedo a la plataforma
  Y soy redirigida a mi panel según mi rol (ver HU-007)

Escenario: Credenciales incorrectas
  Dado que estoy en la pantalla de inicio de sesión del personal
  Cuando ingreso un correo o contraseña incorrectos
  Entonces veo el mensaje "Correo o contraseña incorrectos"
  Y el mensaje no revela si el correo existe

Escenario: Cuenta desactivada
  Dado que mi cuenta fue desactivada por el colegio
  Cuando intento iniciar sesión con credenciales correctas
  Entonces veo "Tu cuenta no está activa. Comunícate con secretaría o la oficina de información"

Escenario: Correo no institucional
  Cuando ingreso un correo que no pertenece al dominio del colegio
  Entonces veo "Usa tu correo institucional"

Escenario: Campos vacíos
  Cuando presiono "Ingresar" sin completar los campos
  Entonces veo qué campo falta, sin enviar la solicitud
```

## Notas
- Cuentas del Sprint 1 se crean por script/semilla; la invitación llega en [[HU-009 Invitar personal]].
- Contraseñas almacenadas con hash robusto (Argon2id o bcrypt). Ver [[Seguridad y proteccion de datos]].
- Mostrar/ocultar contraseña (accesibilidad en móvil).
- Registrar intento exitoso y fallido → [[HU-013 Registro de auditoria de accesos]].

## Diseño
[[Pantalla login personal]] · [[Flujo de autenticacion]]

## Tareas (Sprint Planning)
- [ ] Endpoint de autenticación
- [ ] Hash y verificación de contraseña
- [ ] Pantalla de login (web responsive)
- [ ] Validaciones de formulario
- [ ] Pruebas automatizadas de los 5 escenarios
