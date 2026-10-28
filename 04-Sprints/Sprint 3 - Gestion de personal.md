---
tipo: sprint
numero: 3
inicio: 2026-12-14
fin: 2026-12-24
estado: previsto
puntos_comprometidos: 18
tags: [sprint, fase1]
---
# Sprint 3 · Gestión de personal

Volver a [[Sprints MOC]] · Épica: [[EP-02 Gestion de usuarios y roles]]

## 🎯 Objetivo del sprint (propuesto)
**"El colegio crea, configura y desactiva por sí mismo las cuentas del personal, con trazabilidad completa."**

## Sprint Backlog (previsión)
| Historia | Pts |
|---|---|
| [[HU-009 Invitar personal]] | 5 |
| [[HU-030 Listado y ficha del personal]] | 3 |
| [[HU-010 Asignar roles al personal]] | 3 |
| [[HU-011 Desactivar cuenta]] | 2 |
| [[HU-014 Consultar bitacora de auditoria]] | 5 |
| **Total** | **18** |

## Fechas y capacidad
**Decisión del Scrum Master (2026-10-28):** el Sprint 3 dura **2 semanas, del lunes 14/12 al jueves 24/12/2026**. El viernes 25/12 es feriado (Navidad), así que la Sprint Review y la Retrospectiva se adelantan al **jueves 24/12 por la mañana**. Del 28/12/2026 al 01/01/2027 hay **pausa de fin de año** (sin sprint), y la Fase 2 empieza el **lunes 04/01/2027** con el Sprint 4. Ver [[2026-10-28 Sprint Planning tecnico - Scrum Master]].

| Developer | Días disponibles | Notas |
|---|---|---|
| Dev 1 | 8,5 | 25/12 feriado; 24/12 medio día de eventos |
| Dev 2 | 8,5 | ídem |
| Dev 3 | 8,5 | ídem |
| **Total** | **25,5** | ~12 % menos que un sprint completo → velocidad esperada 13–18 pts |

> La previsión de 18 pts queda en el límite. Se mantiene el alcance del PO; si en la Sprint Planning la velocidad real de S1–S2 es menor, sale primero [[HU-014 Consultar bitacora de auditoria]] (decisión del PO). Las tareas de Dev 3 están ordenadas para que TEC-17 y la regresión se hagan aunque HU-014 salga.

> Revisión del PO (2026-10-28): entra [[HU-030 Listado y ficha del personal]], necesaria para operar HU-010 y HU-011. Si la capacidad real no alcanza, la primera en salir es HU-014.
>
> ✅ **Resuelto por el Scrum Master (2026-10-28):** sprint de 2 semanas, 14/12 – 24/12/2026, con pausa de fin de año hasta el 01/01/2027.

## Tareas técnicas
> Definidas por el [[Scrum Master]] el 2026-10-28 ([[2026-10-28 Sprint Planning tecnico - Scrum Master]]); se confirman en la [[Sprint Planning]] del sprint. Stack: [[ADR-005 Stack PHP Laravel y Filament]] · [[Stack tecnologico]] · Paquetes: [[Sprint 3 - Dev 1]], [[Sprint 3 - Dev 2]], [[Sprint 3 - Dev 3]].
>
> **Terminado técnico común:** `vendor/bin/pint --test`, `vendor/bin/phpstan analyse`, `vendor/bin/pest` en verde (CI con SQLite y PostgreSQL); cada escenario Gherkin con su prueba Pest; prueba con rol sin acceso (403); acciones sensibles auditadas con actor, objetivo y cambio; PR revisado.
>
> Reparto: **Dev 1** = ficha del personal y roles (HU-030, HU-010; dueño de `UserResource`) · **Dev 2** = invitación y desactivación (HU-009, HU-011; acciones y página pública de activación) · **Dev 3** = bitácora y tareas programadas (HU-014, TEC-17, regresión de la Fase 1).

| ID | Tarea | Relacionada | Dev | Depende de |
|---|---|---|---|---|
| T-3-01 | Perfil `StaffMember` y `UserPolicy` completa del sprint ⚠️ **primero** | HU-030, HU-009, HU-010, HU-011 | Dev 1 | — |
| T-3-02 | Listado del personal: búsqueda, filtros y orden | HU-030 | Dev 1 | T-3-01 |
| T-3-03 | Ficha de la persona y último acceso | HU-030 | Dev 1 | T-3-01 |
| T-3-04 | Formulario y edición con auditoría de cambios | HU-030 | Dev 1 | T-3-03 |
| T-3-05 | Asignar y quitar roles con restricciones | HU-010 | Dev 1 | T-3-04 |
| T-3-06 | Efecto inmediato y auditoría de roles | HU-010 | Dev 1 | T-3-05 |
| T-3-07 | Integrar en la ficha las acciones de otros paquetes | HU-030, HU-009, HU-011 | Dev 1 | T-3-10, T-3-11 |
| T-3-08 | Acción `InviteStaffMember` y correo de invitación | HU-009 | Dev 2 | T-3-01 |
| T-3-09 | Página "Invitar personal" (alta) | HU-009 | Dev 2 | T-3-04, T-3-08 |
| T-3-10 | Activación de la cuenta, invitación vencida y reenvío | HU-009 | Dev 2 | T-3-08 |
| T-3-11 | Acciones desactivar y reactivar | HU-011 | Dev 2 | T-3-01 |
| T-3-12 | Efectos de la desactivación (sesiones, login, historial) | HU-011 | Dev 2 | T-3-11 |
| T-3-13 | Tareas programadas y retención de auditoría | TEC-17 | Dev 3 | — |
| T-3-14 | `AuditEventResource`: lista, orden y filtros | HU-014 | Dev 3 | — |
| T-3-15 | Detalle del evento y control de acceso | HU-014 | Dev 3 | T-3-14 |
| T-3-16 | Exportación CSV auditada | HU-014 | Dev 3 | T-3-14 |
| T-3-17 | Regresión de la Fase 1 y DoD de experiencia en staging | Todas | Dev 3 | resto del sprint |

#### T-3-01 · `StaffMember` y `UserPolicy` — Dev 1 ⚠️ debe completarse primero (día 1)
- **Qué:** migración `create_staff_members_table` (UUID, `user_id` único, `first_names`, `last_names`, `ci` único, `phone` nullable, `position` nullable); modelo `StaffMember` y relación `User::staffMember()`; *factory*. `UserPolicy` con todas las habilidades del sprint: `viewAny`, `view`, `create` (`staff.invite`), `update` (`staff.edit`), `changeEmail` (solo Soporte TI), `assignRole(User $actor, User $target, StaffRole $role)` (roles altos solo Dirección/TI), `deactivate`/`reactivate` (`accounts.deactivate`, nunca sobre uno mismo), `resendInvitation`, `delete` siempre `false`. Desde aquí `UserPolicy` y `User.php` pertenecen a Dev 1.
- **Archivos:** `database/migrations/2026_12_14_090000_create_staff_members_table.php`, `app/Models/StaffMember.php`, `database/factories/StaffMemberFactory.php`, `app/Models/User.php`, `app/Policies/UserPolicy.php`, `tests/Feature/Rbac/UserPolicyTest.php`.
- **Pruebas:** *dataset* rol × habilidad según [[Roles y permisos RBAC]]; desactivarse a sí mismo es `false`.

#### T-3-02 · Listado del personal — Dev 1
- **Qué:** `UsersTable`: columnas apellidos, nombres, CI, correo, roles, estado; búsqueda por nombre, CI o correo; filtros por rol y estado; orden por apellido.
- **Archivos:** `app/Filament/Admin/Resources/Users/Tables/UsersTable.php`, `app/Filament/Admin/Resources/Users/UserResource.php`, `lang/es/staff.php`, `tests/Feature/HU030/StaffListTest.php`.
- **Pruebas (HU-030):** "Buscar y filtrar", "Sin permiso" (Docente y Oficina → 403).

#### T-3-03 · Ficha y último acceso — Dev 1
- **Qué:** página `ViewUser` con infolist (datos, roles, estado, último acceso); migración `add_last_login_at_to_users_table` y *listener* `UpdateLastLoginAt` (evento `Login`).
- **Archivos:** `app/Filament/Admin/Resources/Users/Pages/ViewUser.php`, `app/Filament/Admin/Resources/Users/Schemas/UserInfolist.php`, `database/migrations/2026_12_14_100000_add_last_login_at_to_users_table.php`, `app/Listeners/UpdateLastLoginAt.php`, `tests/Feature/HU030/StaffProfileTest.php`.
- **Pruebas (HU-030):** "Ver ficha" (incluye que cada rol ve solo las acciones que su rol permite, verificable al completar T-3-07).

#### T-3-04 · Formulario y edición con auditoría — Dev 1
- **Qué:** `UserForm` (datos de `StaffMember` + correo con `InstitutionalEmail` y único; CI único con "Ya existe una persona con este CI"); `EditUser`; el correo solo editable si `changeEmail`; evento `staff.updated` con valores anterior y nuevo (sin datos sensibles).
- **Archivos:** `app/Filament/Admin/Resources/Users/Schemas/UserForm.php`, `app/Filament/Admin/Resources/Users/Pages/EditUser.php`, `app/Actions/Staff/UpdateStaffMember.php`, `tests/Feature/HU030/EditStaffTest.php`.
- **Pruebas (HU-030):** "Corregir datos" (auditoría con antes/después), "CI duplicado", "Cambio de correo institucional" (Secretaría no puede; TI sí y queda auditado).

#### T-3-05 · Asignar y quitar roles — Dev 1
- **Qué:** campo de roles en `UserForm` con opciones filtradas por `assignRole` del actor y validación en servidor (no solo ocultar); al menos un rol: "La cuenta debe tener al menos un rol; si la persona dejó el colegio, desactívala"; acción `App\Actions\Staff\SyncStaffRoles`.
- **Archivos:** `app/Filament/Admin/Resources/Users/Schemas/UserForm.php`, `app/Actions/Staff/SyncStaffRoles.php`, `tests/Feature/HU010/AssignRolesTest.php`.
- **Pruebas (HU-010):** "Asignar rol", "Restricción" (Secretaría no puede asignar Dirección/TI ni forzándolo por Livewire), "Cuenta sin roles".

#### T-3-06 · Efecto inmediato y auditoría de roles — Dev 1
- **Qué:** eventos `RoleAssigned`/`RoleRevoked` → `AuditLogger` (quién, a quién, qué rol, cuándo); limpiar la caché de permisos de spatie; si la persona pierde su rol principal, recalcularlo.
- **Archivos:** `app/Events/RoleAssigned.php`, `app/Events/RoleRevoked.php`, `app/Listeners/RecordRoleChange.php`, `app/Actions/Staff/SyncStaffRoles.php`, `tests/Feature/HU010/RoleChangeEffectTest.php`.
- **Pruebas (HU-010):** "Quitar rol" (con sesión abierta, la siguiente petición al panel da 403), "Auditoría", "Asignar rol" (en el próximo ingreso ve el cambio de panel de HU-007).

#### T-3-07 · Integrar acciones en la ficha — Dev 1
- **Qué:** registrar en `ViewUser` y `UsersTable` las acciones `ResendInvitationAction`, `DeactivateAccountAction`, `ReactivateAccountAction` (Dev 2), `UnlockAccountAction` y `ResetMfaAction` (Sprint 2), cada una autorizada por `UserPolicy`.
- **Archivos:** `app/Filament/Admin/Resources/Users/Pages/ViewUser.php`, `app/Filament/Admin/Resources/Users/Tables/UsersTable.php`, `tests/Feature/HU030/StaffActionsVisibilityTest.php`.
- **Pruebas (HU-030):** "Ver ficha" → *dataset* rol × acción visible.

#### T-3-08 · `InviteStaffMember` y correo de invitación — Dev 2
- **Qué:** migración `add_invitation_columns_to_users_table` (`invited_at`, `invited_by`); `App\Actions\Staff\InviteStaffMember` (transacción: `User` en `Pending` sin contraseña usable + `StaffMember` + roles vía `SyncStaffRoles`); `StaffInvitationNotification` (en cola) con URL firmada temporal de 72 h que incluye `invited_at` (reenviar invalida la anterior); evento `staff.invited`.
- **Archivos:** `database/migrations/2026_12_14_110000_add_invitation_columns_to_users_table.php`, `app/Actions/Staff/InviteStaffMember.php`, `app/Notifications/StaffInvitationNotification.php`, `lang/es/invitation.php`, `tests/Feature/HU009/InviteStaffActionTest.php`.
- **Pruebas (HU-009):** "Invitación enviada" (estado pendiente, correo con enlace de 72 h, auditado).

#### T-3-09 · Página "Invitar personal" — Dev 2
- **Qué:** `CreateUser` usa `UserForm` y delega en `InviteStaffMember`; correo duplicado → "Ya existe una cuenta con este correo" con enlace a esa ficha; autorizado por `UserPolicy::create`.
- **Archivos:** `app/Filament/Admin/Resources/Users/Pages/CreateUser.php`, `tests/Feature/HU009/InviteStaffPageTest.php`.
- **Pruebas (HU-009):** "Correo duplicado", "Correo fuera del dominio o CI duplicado", "Sin permiso" (Docente, Coordinación, Oficina).

#### T-3-10 · Activación, invitación vencida y reenvío — Dev 2
- **Qué:** página pública `ActivateAccount` (ruta firmada `/activar/{user}`) donde la persona define su contraseña con la política → cuenta `Active` y evento `staff.activated`; enlace vencido o reemplazado → "Esta invitación venció. Pide a secretaría que te la reenvíe"; `ResendInvitationAction`.
- **Archivos:** `routes/web.php`, `app/Filament/Pages/Auth/ActivateAccount.php`, `app/Filament/Admin/Resources/Users/Actions/ResendInvitationAction.php`, `tests/Feature/HU009/ActivationTest.php`.
- **Pruebas (HU-009):** "Activación" (luego inicia sesión — HU-001), "Invitación vencida" (73 h, y el enlace anterior falla tras reenviar).

#### T-3-11 · Desactivar y reactivar — Dev 2
- **Qué:** `App\Actions\Staff\DeactivateAccount` (motivo obligatorio, estado `Deactivated`, borra las sesiones del usuario, evento `account.deactivated`) y `ReactivateAccount`; acciones Filament `DeactivateAccountAction` y `ReactivateAccountAction` con confirmación.
- **Archivos:** `app/Actions/Staff/DeactivateAccount.php`, `app/Actions/Staff/ReactivateAccount.php`, `app/Filament/Admin/Resources/Users/Actions/DeactivateAccountAction.php`, `app/Filament/Admin/Resources/Users/Actions/ReactivateAccountAction.php`, `lang/es/accounts.php`, `tests/Feature/HU011/DeactivateAccountTest.php`.
- **Pruebas (HU-011):** "Desactivar" (motivo requerido, auditado), "Desactivar mi propia cuenta" (no permitido), "Reactivar".

#### T-3-12 · Efectos de la desactivación — Dev 2
- **Qué:** pruebas de punta a punta: la sesión abierta de la persona deja de funcionar en la siguiente petición; el login muestra el mensaje de cuenta no activa (HU-001); auditoría y datos se conservan (sin borrado físico).
- **Archivos:** `tests/Feature/HU011/DeactivationEffectsTest.php`.
- **Pruebas (HU-011):** "Desactivar" (sesiones cerradas de inmediato, historial conservado), "Reactivar" (vuelve a ingresar).

#### T-3-13 · Tareas programadas y retención — Dev 3
- **Qué:** en `routes/console.php`: `auth:clear-resets` diario; comando `colegio:auditoria-retencion` que elimina eventos de más de `auditoria_retencion_dias` usando una conexión de mantenimiento (`audit_maintenance`) cuyo rol de PostgreSQL es el único que el *trigger* deja borrar; ajustar el *trigger* de T-1-16 en una migración nueva.
- **Archivos:** `routes/console.php`, `app/Console/Commands/PurgeExpiredAuditEvents.php`, `config/database.php` (conexión `audit_maintenance`), `database/migrations/2026_12_14_120000_allow_audit_retention_role.php`, `tests/Feature/Infra/ScheduleTest.php`, `tests/Feature/Infra/AuditRetentionTest.php`.
- **Pruebas:** el *schedule* contiene las tareas; la retención borra solo eventos de más de 365 días; la conexión normal sigue sin poder borrar (trabajo `pest-pgsql`).

#### T-3-14 · `AuditEventResource`: lista y filtros — Dev 3
- **Qué:** `Admin/Resources/AuditEvents/AuditEventResource` de solo lectura; orden por `occurred_at` descendente; filtros por usuario, tipo de evento (etiquetas en español) y rango de fechas; estado vacío "No hay eventos para estos filtros"; paginación de 25.
- **Archivos:** `app/Filament/Admin/Resources/AuditEvents/AuditEventResource.php`, `app/Filament/Admin/Resources/AuditEvents/Pages/ListAuditEvents.php`, `app/Filament/Admin/Resources/AuditEvents/Tables/AuditEventsTable.php`, `lang/es/audit.php`, `tests/Feature/HU014/AuditLogListTest.php`.
- **Pruebas (HU-014):** "Filtrar", "Sin resultados".

#### T-3-15 · Detalle del evento y control de acceso — Dev 3
- **Qué:** `ViewAuditEvent` con el contexto legible; sin acciones de crear/editar/borrar; acceso solo con `audit.view` (Dirección, TI).
- **Archivos:** `app/Filament/Admin/Resources/AuditEvents/Pages/ViewAuditEvent.php`, `app/Filament/Admin/Resources/AuditEvents/Schemas/AuditEventInfolist.php`, `tests/Feature/HU014/AuditLogAccessTest.php`.
- **Pruebas (HU-014):** "Sin permiso" (Secretaría, Coordinación, Oficina y Docente → 403 por URL directa y `access.denied` registrado).

#### T-3-16 · Exportación CSV auditada — Dev 3
- **Qué:** acción de encabezado "Exportar CSV" que exporta por *streaming* (`response()->streamDownload`, lectura por bloques) la consulta filtrada; columnas en español; evento `audit.exported` con los filtros usados.
- **Archivos:** `app/Filament/Admin/Resources/AuditEvents/Actions/ExportAuditEventsAction.php`, `app/Actions/Audit/ExportAuditEventsCsv.php`, `tests/Feature/HU014/AuditLogExportTest.php`.
- **Pruebas (HU-014):** "Exportar" (CSV con los eventos filtrados y la exportación auditada).

#### T-3-17 · Regresión de la Fase 1 y DoD de experiencia — Dev 3
- **Qué:** recorrer en staging todas las historias de la Fase 1 terminadas (S1–S3) con cuentas de cada rol (Chrome, Firefox, Android, 3G, teclado); datos de demostración para la Sprint Review con un *seeder* `DemoStaffSeeder` solo para staging.
- **Archivos:** `database/seeders/DemoStaffSeeder.php`.
- **Entregable:** lista de verificación del hito H2 en esta nota.

## Decisiones técnicas
_(completar durante el sprint)_

## Hito
**H2 — Personal gestionado por el colegio**. Siguiente: [[Fases y roadmap#Fase 2 — Estructura académica y aulas virtuales|Fase 2]].
