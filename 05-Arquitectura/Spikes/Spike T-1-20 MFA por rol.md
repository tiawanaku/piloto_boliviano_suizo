---
tipo: spike
sprint: "[[Sprint 1 - Login base]]"
tarea: T-1-20
historia: "[[HU-005 MFA para personal administrativo]]"
autor: Dev 3
fecha: 2026-10-28
estado: terminado
tags: [arquitectura, spike, seguridad, mfa]
---
# Spike T-1-20 · MFA por rol en Filament 5

Volver a [[Vision de arquitectura]] · Sprint: [[Sprint 1 - Login base]] · Historia: [[HU-005 MFA para personal administrativo]] · Decisión afectada: [[ADR-005 Stack PHP Laravel y Filament]] §4

## Pregunta
¿Cómo exigimos el MFA con app autenticadora (TOTP nativo de Filament 5) **solo** a cuentas con algún rol administrativo, y no a los docentes, si `/admin` y `/docente` comparten el guard `web`? ¿Cómo se fuerza la configuración en el primer ingreso, cómo funcionan los códigos de recuperación y cómo restablece el MFA Soporte TI?

## Cómo se hizo
- Prototipo en una **copia descartable** de `app-colegio/` (scratchpad, fuera del repositorio). No se integró nada del prototipo.
- Lectura del código de Filament 5.11 (`Panel\Concerns\HasAuth`, `Pages\Concerns\HasRoutes`, `routes/web.php`, `Auth\Pages\Login`, `Auth\MultiFactor\*`).
- 12 pruebas Pest del prototipo en verde (detalle abajo). También se corrió la suite completa con el MFA activado para medir el impacto.

## Resultado
**Sí se puede, con Filament nativo y sin dependencias nuevas.** `pragmarx/google2fa`, `pragmarx/google2fa-qrcode` y `chillerlan/php-qrcode` ya son dependencias de `filament/filament`: `composer.json` no cambia.

### Hallazgo clave: el "obligatorio" de Filament es por panel, no por usuario
`->multiFactorAuthentication(..., isRequired: fn () => ...)` acepta un *closure*, pero Filament lo evalúa **al registrar las rutas**, no en cada solicitud: decide si las páginas reciben el *middleware* y si existe la ruta `/<panel>/multi-factor-authentication/set-up`. En ese momento no hay usuario, así que **no sirve para decidir por rol**.

**Solución:** marcar el MFA como obligatorio en ambos paneles (`isRequired: true`) y **sustituir el *middleware*** con `multiFactorAuthenticationRequiredMiddlewareName()` por uno propio que solo lo exige a cuentas con rol administrativo.

### Enfoque recomendado
1. **Usuario** (`User`): implementar `HasAppAuthentication` y `HasAppAuthenticationRecovery` con los *traits* de Filament (`InteractsWithAppAuthentication`, `InteractsWithAppAuthenticationRecovery`). Los *traits* agregan los *casts* `encrypted` / `encrypted:array` y ocultan las columnas (`$hidden`). Agregar el método `requiresMultiFactorAuthentication()`, basado en `StaffRole::isAdministrative()`.
2. **Migración**: columnas `app_authentication_secret` (text, nullable) y `app_authentication_recovery_codes` (text, nullable).
3. **`StaffPanel`** (ambos paneles): proveedor `AppAuthentication` con `recoverable()->recoveryCodeCount(10)` y el *middleware* propio. Tiene que estar **en los dos paneles**, porque el desafío del login usa los proveedores del panel actual. Así, un Docente + Coordinación que entra por `/docente` también pasa por el MFA.
4. **Primer ingreso**: el *middleware* redirige a la página nativa `SetUpRequiredMultiFactorAuthentication` (QR, confirmación del código de 6 dígitos y los 10 códigos de respaldo). Mientras no termine, toda página del panel lo devuelve allí (escenario "Abandonar la activación").
5. **Orden con la contraseña temporal (HU-006)**: funciona sin cambios. La ruta de configuración del MFA está dentro de `authMiddleware`, donde ya está `EnsurePasswordIsChanged`, y `ChangeTemporaryPassword` es una ruta autenticada, no una página del panel, así que no recibe el *middleware* de MFA. Resultado: **primero se cambia la contraseña y después se configura el MFA**. Esto está probado.
6. **Código incorrecto → HU-004/HU-013**: Filament **no emite ningún evento** cuando el código es incorrecto; solo lanza `ValidationException` con claves `data.multiFactor.*`. Se intercepta en `App\Filament\Pages\Auth\Login::authenticate()` y se emite un evento propio `MultiFactorChallengeFailed`, que luego escuchan `AccountLockout` y la auditoría.
7. **Restablecer MFA (Soporte TI)**: un servicio (`MultiFactorReset`) que, en una transacción, pone en `null` el secreto y los códigos, rota `remember_token`, borra las filas de `sessions` del usuario y registra `mfa.reset` con `AuditLogger`. Se autoriza con `UserPolicy::resetMfa` (`Permission::MfaReset`). En el próximo ingreso el *middleware* vuelve a exigir la configuración.

### Fragmentos clave
```php
// StaffPanel::configure()
->multiFactorAuthentication(
    AppAuthentication::make()
        ->brandName('Colegio Virtual')
        ->recoverable()
        ->recoveryCodeCount(10),
    isRequired: true,
)
->multiFactorAuthenticationRequiredMiddlewareName(EnsureAdministrativeMfa::class)
```
```php
// App\Http\Middleware\EnsureAdministrativeMfa
$user = Filament::auth()->user();
if (! $user instanceof User || ! $user->requiresMultiFactorAuthentication()) {
    return $next($request);
}
if (MultiFactorChallenge::make()->hasEnabledProviders($user)) {
    return $next($request);
}
return redirect()->guest(Filament::getSetUpRequiredMultiFactorAuthenticationUrl());
```
```php
// User
public function requiresMultiFactorAuthentication(): bool
{
    return $this->getRoleNames()->contains(
        fn (string $role): bool => StaffRole::tryFrom($role)?->isAdministrative() ?? false,
    );
}
```
```php
// App\Filament\Pages\Auth\Login
public function authenticate(): ?LoginResponse
{
    try {
        return parent::authenticate();
    } catch (ValidationException $e) {
        $user = $this->getUserUndertakingMultiFactorAuthentication();
        if ($user && collect($e->errors())->keys()->contains(fn ($k) => str_starts_with($k, 'data.multiFactor.'))) {
            MultiFactorChallengeFailed::dispatch($user);
        }
        throw $e;
    }
}
```

### Pruebas del prototipo (12, en verde)
Administrativo sin MFA → se le redirige a la configuración en `/admin` y en `/docente` · Docente sin rol administrativo → entra sin MFA · Administrativo con MFA → entra · El login pide el código y entra con un TOTP válido (`Google2FA::getCurrentOtp`) · Un código de respaldo funciona una sola vez (quedan 1 de 2) · Un código incorrecto emite `MultiFactorChallengeFailed` y no inicia sesión · Docente: el login no pide código · Restablecer: borra el secreto y los códigos, y se vuelve a exigir la configuración · La contraseña temporal va antes que el MFA · El secreto y los códigos se guardan cifrados (los códigos, además, con `Hash::make`) y no aparecen en `toArray()`.

## Riesgos e impacto
- **Impacto en las pruebas existentes (alto, previsible):** al activar el MFA fallaron 16 pruebas de HU-002, HU-006, HU-007 y paneles, porque las cuentas administrativas pasan a ser redirigidas a la configuración. Una prueba rápida confirmó la mitigación: si `UserFactory::withRoles()` / `actingAsStaff()` crean las cuentas administrativas **con MFA ya configurado**, quedan solo las pruebas de login de punta a punta (HU-007 `LoginRedirectTest`, HU-013 `LoginAuditTest`), que tienen que completar el desafío con un TOTP. **Hace falta una tarea en el Sprint 2** para un estado `withMfa()` / `withoutMfa()` y un *helper* `completeMfaChallenge()`.
- **Ventana tras el restablecimiento:** entre el restablecimiento y la nueva configuración, quien tenga solo la contraseña puede vincular su propia app. Mitigación propuesta: al restablecer, emitir también una **contraseña temporal** (HU-006), de modo que el titular la reciba por un canal verificado.
- **Desactivación por el propio usuario:** la acción nativa `DisableAppAuthenticationAction` aparece en la gestión del MFA dentro del perfil. Hoy no hay `->profile()` y por eso no se ve. Si "Mi cuenta" ([[HU-029 Mi cuenta datos y cambio de contrasena]]) muestra la gestión del MFA, hay que extender `AppAuthentication::getActions()` para ocultar "Desactivar" a los roles administrativos.
- **Docentes que se inscriben voluntariamente:** un docente que entra directamente a `/docente/multi-factor-authentication/set-up` puede activar el MFA (la página no lo impide). No es un problema de seguridad, pero el PO debe decidir si se permite. Si no, se subclasifica la página para redirigir a quien no es administrativo.
- **Rutas fuera de las páginas del panel:** el *middleware* se aplica a las páginas y *Resources* de Filament, no a las rutas propias registradas con `authenticatedRoutes()`. Cualquier ruta propia nueva con datos debe aplicar `EnsureAdministrativeMfa` explícitamente.
- **Textos:** las traducciones `es` de Filament mezclan "tú" y "usted", y el mensaje de código incorrecto no es el de HU-005. Hay que sobrescribir `lang/vendor/filament-panels/es/auth/multi-factor/...` ("Código incorrecto. Revisa la hora de tu celular e inténtalo de nuevo").
- **Límite de intentos:** el desafío ya tiene su propio limitador por usuario en Filament (`MultiFactorChallenge::isRateLimited`). Se suma al bloqueo de HU-004; hay que alinear los umbrales para no mostrar dos mensajes distintos.

## Propuesta de cambio al ADR-005 (para el Scrum Master)
En §4, fila "MFA (TOTP)", reemplazar la nota "**(spike)**: confirmar en Sprint 2 cómo exigir MFA por rol..." por:
> Resuelto en el [[Spike T-1-20 MFA por rol]]: proveedor `AppAuthentication` (`recoverable()`, `recoveryCodeCount(10)`) en **ambos** paneles vía `StaffPanel`, `isRequired: true` y *middleware* propio `EnsureAdministrativeMfa` (`multiFactorAuthenticationRequiredMiddlewareName`), que lo exige solo si `User::requiresMultiFactorAuthentication()` (algún `StaffRole::isAdministrative()`). Código incorrecto → evento propio `MultiFactorChallengeFailed` (Filament no emite uno). Sin dependencias nuevas (vienen con Filament).

No cambia ninguna decisión de fondo del ADR (MFA nativo de Filament, 10 códigos, obligatorio solo para roles administrativos). Solo se precisa el mecanismo.

## Tareas propuestas para el Sprint 2 (HU-005)
1. Migración de columnas MFA + `User` con los contratos y `requiresMultiFactorAuthentication()`.
2. `StaffPanel` + `EnsureAdministrativeMfa` + textos en `lang/vendor/filament-panels/es`.
3. Evento `MultiFactorChallengeFailed` → `AccountLockout` (HU-004) y `AuditEventType::MfaFailed` (HU-013).
4. `MultiFactorReset` + acción "Restablecer MFA" en `UserResource`, `UserPolicy::resetMfa`, auditoría `mfa.reset` (considerar contraseña temporal).
5. Ajuste de *factories* / *helpers* de prueba (`withMfa()`, `completeMfaChallenge()`) **antes** de activar el MFA en `StaffPanel`, para que la suite no se rompa.
