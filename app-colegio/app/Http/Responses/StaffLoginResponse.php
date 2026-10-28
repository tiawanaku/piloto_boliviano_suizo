<?php

declare(strict_types=1);

namespace App\Http\Responses;

use App\Models\User;
use Filament\Auth\Http\Responses\Contracts\LoginResponse;
use Filament\Facades\Filament;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * Tras el login, lleva al panel del rol principal (HU-007, ADR-005 §3),
 * sin importar por qué panel (/admin o /docente) se inició sesión.
 */
final class StaffLoginResponse implements LoginResponse
{
    /**
     * @param  Request  $request
     */
    public function toResponse($request): RedirectResponse
    {
        // La URL "intended" puede apuntar a un panel sin acceso: se descarta.
        session()->forget('url.intended');

        $user = Filament::auth()->user();

        $url = $user instanceof User ? $user->primaryPanelUrl() : null;

        return redirect()->to($url ?? Filament::getUrl() ?? '/');
    }
}
