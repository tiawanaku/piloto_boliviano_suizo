<?php

declare(strict_types=1);

namespace App\Providers;

use App\Http\Responses\StaffLoginResponse;
use Filament\Auth\Http\Responses\Contracts\LoginResponse;
use Illuminate\Support\ServiceProvider;

/**
 * Autenticación del personal: respuestas propias de Filament (HU-007).
 * Se registra después de los proveedores de paquetes, así que reemplaza el
 * enlace por defecto de FilamentServiceProvider.
 */
class StaffAuthServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(LoginResponse::class, StaffLoginResponse::class);
    }
}
