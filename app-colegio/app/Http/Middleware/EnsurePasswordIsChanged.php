<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Filament\Pages\Auth\ChangeTemporaryPassword;
use App\Models\User;
use Closure;
use Filament\Facades\Filament;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Mientras la cuenta tenga una contraseña temporal, cualquier página del
 * panel redirige a "Define tu contraseña" (HU-006). Se permite la propia
 * página de cambio y el cierre de sesión.
 */
final class EnsurePasswordIsChanged
{
    /**
     * @param  Closure(Request): Response  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user instanceof User || ! $user->must_change_password) {
            return $next($request);
        }

        $panel = Filament::getCurrentOrDefaultPanel();
        $allowed = [
            $panel->generateRouteName(ChangeTemporaryPassword::ROUTE_NAME),
            $panel->generateRouteName('auth.logout'),
        ];

        if ($request->routeIs(...$allowed)) {
            return $next($request);
        }

        return redirect()->to(ChangeTemporaryPassword::urlFor($panel));
    }
}
