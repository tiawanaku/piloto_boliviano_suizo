---
tipo: historia
id: HU-024
epica: "[[EP-06 App de estudiantes]]"
sprint: ""
puntos: 8
estado: backlog
prioridad: media
orden: 29
tags: [historia, fase4]
---
# HU-024 · Login de estudiante en la app

Épica: [[EP-06 App de estudiantes]]

## Historia
> **Como** estudiante
> **quiero** ingresar a la app con el usuario y la contraseña que el colegio entregó a mi tutor
> **para** entrar a mis clases virtuales.

## Criterios de aceptación
```gherkin
Escenario: Ingreso
  Dado que tengo credenciales (HU-034) y matrícula vigente
  Cuando ingreso mi usuario de estudiante y contraseña
  Entonces veo mis materias (HU-025)

Escenario: Primer ingreso
  Dado que uso la contraseña temporal por primera vez
  Cuando inicio sesión
  Entonces debo definir una nueva contraseña antes de continuar, con requisitos explicados en lenguaje sencillo

Escenario: Credenciales incorrectas
  Cuando ingreso un usuario o contraseña incorrectos
  Entonces veo "Usuario o contraseña incorrectos", sin revelar si el usuario existe

Escenario: Demasiados intentos
  Cuando fallo 5 veces seguidas
  Entonces el acceso se bloquea temporalmente con las mismas reglas de HU-004
  Y veo "Espera unos minutos o pide a tu tutor que solicite un nuevo acceso"

Escenario: Matrícula no vigente
  Dado que fui retirado o no tengo matrícula en la gestión activa
  Cuando inicio sesión con credenciales correctas
  Entonces veo "Tu matrícula no está vigente. Tu tutor puede consultar en secretaría o en la oficina de información"

Escenario: Accesos separados
  Cuando un estudiante intenta entrar al portal del personal, o un miembro del personal a la app de estudiantes
  Entonces el acceso se rechaza (ADR-003)

Escenario: Olvidé mi contraseña
  Cuando elijo "Olvidé mi contraseña"
  Entonces la app me indica que mi tutor puede pedir un nuevo acceso en secretaría (HU-034)

Escenario: Cerrar sesión
  Cuando elijo "Cerrar sesión"
  Entonces vuelvo a la pantalla de ingreso y nadie más puede ver mis datos en ese celular
```

## Notas
- Separado del login del personal: [[ADR-003 Separar acceso de personal y estudiantes]].
- Intentos y accesos quedan en auditoría ([[HU-013 Registro de auditoria de accesos]]).
- Si los Developers estiman más de 8 pts, dividir en (a) ingreso y errores, (b) primer ingreso y cambio de contraseña.
- **Decisiones pendientes**: política de contraseñas para estudiantes (edades distintas) y cuánto dura la sesión en el celular (dispositivos compartidos).
