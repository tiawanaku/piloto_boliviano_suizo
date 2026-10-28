<?php

declare(strict_types=1);

namespace App\Filament\Support;

use App\Filament\Pages\Auth\ChangeTemporaryPassword;
use App\Filament\Pages\Auth\Login;
use App\Http\Middleware\EnsurePasswordIsChanged;
use App\Http\Middleware\PreventBackHistory;
use App\Http\Middleware\SecurityHeaders;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Middleware\ShareErrorsFromSession;

/**
 * Configuración común de los paneles del personal (/admin y /docente):
 * guard y sesión compartidos, página de login, marca, colores y middleware.
 *
 * Cada PanelProvider la invoca con StaffPanel::configure($panel) y solo
 * define lo propio (id, ruta, recursos, páginas y widgets).
 *
 * - Login propio (HU-001) y página "Define tu contraseña" (HU-006).
 * - SecurityHeaders (TEC-13) y PreventBackHistory (HU-002) en todas las rutas.
 * - EnsurePasswordIsChanged tras Authenticate (HU-006).
 */
final class StaffPanel
{
    public static function configure(Panel $panel): Panel
    {
        return $panel
            ->login(Login::class)
            ->authGuard('web')
            ->brandName('Colegio Virtual')
            ->colors([
                'primary' => Color::Blue,
            ])
            ->middleware([
                SecurityHeaders::class,
                PreventBackHistory::class,
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
                EnsurePasswordIsChanged::class,
            ])
            ->authenticatedRoutes(function (): void {
                Route::get(ChangeTemporaryPassword::ROUTE_PATH, ChangeTemporaryPassword::class)
                    ->name(ChangeTemporaryPassword::ROUTE_NAME);
            });
    }
}
