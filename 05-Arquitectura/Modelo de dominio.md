---
tipo: arquitectura
tags: [arquitectura, dominio]
---
# Modelo de dominio

Volver a [[Vision de arquitectura]]

```mermaid
erDiagram
    USUARIO ||--o{ USUARIO_ROL : tiene
    ROL ||--o{ USUARIO_ROL : asignado
    ROL ||--o{ ROL_PERMISO : incluye
    PERMISO ||--o{ ROL_PERMISO : ""
    USUARIO ||--o{ SESION : abre
    USUARIO ||--o{ EVENTO_AUDITORIA : genera
    USUARIO ||--o| PERSONAL : "es (perfil)"
    USUARIO ||--o| ESTUDIANTE : "es (perfil)"

    GESTION ||--o{ PERIODO : divide
    NIVEL ||--o{ GRADO : contiene
    GRADO ||--o{ PARALELO : contiene
    GESTION ||--o{ AULA_VIRTUAL : organiza
    PARALELO ||--|| AULA_VIRTUAL : "se dicta en"
    MATERIA ||--o{ AULA_MATERIA : ""
    AULA_VIRTUAL ||--o{ AULA_MATERIA : ofrece
    AULA_MATERIA ||--o{ ASIGNACION_DOCENTE : ""
    PERSONAL ||--o{ ASIGNACION_DOCENTE : dicta
    ESTUDIANTE ||--o{ MATRICULA : ""
    AULA_VIRTUAL ||--o{ MATRICULA : recibe

    USUARIO {
        uuid id
        string correo
        string hash_contrasena
        bool mfa_activo
        string estado "pendiente|activo|bloqueado|desactivado"
    }
    GESTION {
        int anio
        date inicio
        date fin
        string estado "planificada|activa|cerrada"
    }
    AULA_VIRTUAL {
        uuid id
        string nombre
    }
    ASIGNACION_DOCENTE {
        string tipo "titular|suplente"
    }
```

## Notas
- **Usuario** = identidad para autenticarse; **Personal** / **Estudiante** = perfiles con datos de negocio. Permite una sola tabla de identidad con flujos de acceso separados ([[ADR-003 Separar acceso de personal y estudiantes]]).
- Todo lo académico cuelga de **Gestión** para conservar el histórico año a año.
- Niveles/grados configurables ([[Marco normativo Bolivia]]).
- Fase 1 implementa solo: USUARIO, ROL, PERMISO, USUARIO_ROL, ROL_PERMISO, SESION, EVENTO_AUDITORIA, PERSONAL.
