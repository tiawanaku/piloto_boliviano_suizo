<?php

declare(strict_types=1);

namespace App\Filament\Support;

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
use Illuminate\View\Middleware\ShareErrorsFromSession;

/**
 * Configuración común de los paneles del personal (/admin y /docente):
 * guard y sesión compartidos, página de login, marca, colores y middleware.
 *
 * Cada PanelProvider la invoca con StaffPanel::configure($panel) y solo
 * define lo propio (id, ruta, recursos, páginas y widgets). Aquí se
 * registrarán los middleware de seguridad del Sprint 1 (T-1-04, T-1-05,
 * T-1-07) y la página de login personalizada (T-1-02).
 */
final class StaffPanel
{
    public static function configure(Panel $panel): Panel
    {
        return $panel
            ->login()
            ->authGuard('web')
            ->brandName('Colegio Virtual')
            ->colors([
                'primary' => Color::Blue,
            ])
            ->middleware([
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
            ]);
    }
}
