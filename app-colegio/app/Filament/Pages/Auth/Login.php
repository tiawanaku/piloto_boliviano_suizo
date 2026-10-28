<?php

declare(strict_types=1);

namespace App\Filament\Pages\Auth;

use App\Models\User;
use App\Rules\InstitutionalEmail;
use Filament\Actions\Action;
use Filament\Auth\Pages\Login as BaseLogin;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Validation\ValidationException;

/**
 * Login del personal (/admin/login y /docente/login), HU-001 y HU-006.
 *
 * Sobre el login de Filament (timebox, rate limit, eventos Attempting/Failed
 * que audita HU-013) agrega: correo del dominio institucional, mensajes en
 * español claro, mostrar/ocultar contraseña, un único mensaje genérico de
 * credenciales incorrectas y el bloqueo de contraseñas temporales vencidas.
 */
class Login extends BaseLogin
{
    /**
     * Motivo del último rechazo con credenciales correctas (solo durante la
     * petición en curso; no se expone a Livewire).
     */
    protected ?string $rejectionMessage = null;

    protected function getEmailFormComponent(): Component
    {
        $dominio = InstitutionalEmail::domain();

        return TextInput::make('email')
            ->label(__('auth.login.email.label'))
            ->placeholder(__('auth.login.email.placeholder', ['dominio' => $dominio]))
            ->email()
            ->required()
            ->rule(new InstitutionalEmail)
            ->validationMessages([
                'required' => __('auth.login.email.required'),
                'email' => __('auth.login.email.email', ['dominio' => $dominio]),
            ])
            ->autocomplete('username')
            ->autofocus();
    }

    protected function getPasswordFormComponent(): Component
    {
        /** @var TextInput $component */
        $component = parent::getPasswordFormComponent();

        return $component
            ->label(__('auth.login.password.label'))
            ->revealable()
            ->validationMessages([
                'required' => __('auth.login.password.required'),
            ]);
    }

    protected function getAuthenticateFormAction(): Action
    {
        return parent::getAuthenticateFormAction()
            ->label(__('auth.login.submit'));
    }

    /**
     * Se ejecuta con credenciales ya verificadas (dentro del timebox de
     * Filament). Una contraseña temporal vencida impide el ingreso con un
     * mensaje propio (HU-006); el intento se registra como fallido.
     */
    protected function isUserAllowedToAccessPanel(Authenticatable $user): bool
    {
        $this->rejectionMessage = null;

        if ($user instanceof User && $user->temporaryPasswordExpired()) {
            $this->rejectionMessage = __('auth.login.temporary_password_expired');

            return false;
        }

        return parent::isUserAllowedToAccessPanel($user);
    }

    protected function throwFailureValidationException(): never
    {
        $message = $this->rejectionMessage ?? __('auth.login.failed');
        $this->rejectionMessage = null;

        throw ValidationException::withMessages([
            'data.email' => $message,
        ]);
    }
}
