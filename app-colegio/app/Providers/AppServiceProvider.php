<?php

declare(strict_types=1);

namespace App\Providers;

use App\Rules\NotCommonPassword;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configurePasswordPolicy();
    }

    /**
     * Política de contraseñas del personal (HU-006): mínimo 10 caracteres,
     * no aparecer en filtraciones conocidas (Have I Been Pwned, k-anonimato)
     * ni en la lista local de contraseñas comunes.
     */
    protected function configurePasswordPolicy(): void
    {
        Password::defaults(fn (): Password => Password::min(10)
            ->uncompromised()
            ->rules([new NotCommonPassword]));
    }
}
