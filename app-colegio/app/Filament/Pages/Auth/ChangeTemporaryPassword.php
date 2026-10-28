<?php

declare(strict_types=1);

namespace App\Filament\Pages\Auth;

use App\Enums\AuditEventType;
use App\Models\User;
use App\Services\AuditLogger;
use Closure;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\SimplePage;
use Filament\Panel;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Schema;
use Filament\Support\Components\Attributes\Exposed;
use Filament\Support\Components\Attributes\Unexposed;
use Illuminate\Auth\SessionGuard;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\HtmlString;
use Illuminate\Validation\Rules\Password;

/**
 * "Define tu contraseña" (HU-006): obligatoria mientras la cuenta tenga una
 * contraseña temporal. EnsurePasswordIsChanged redirige aquí desde cualquier
 * otra página del panel. Ruta registrada por StaffPanel en cada panel.
 *
 * @property-read Schema $form
 */
class ChangeTemporaryPassword extends SimplePage
{
    public const ROUTE_NAME = 'auth.change-temporary-password';

    public const ROUTE_PATH = '/cambiar-contrasena';

    /**
     * @var array<string, mixed>|null
     */
    public ?array $data = [];

    public static function urlFor(Panel $panel): string
    {
        return $panel->route(self::ROUTE_NAME);
    }

    #[Unexposed]
    public function mount(): void
    {
        if (! $this->user()?->must_change_password) {
            $this->redirect(Filament::getUrl());

            return;
        }

        $this->form->fill();
    }

    #[Exposed]
    public function save(): void
    {
        $user = $this->user();

        if ($user === null || ! $user->must_change_password) {
            $this->redirect(Filament::getUrl());

            return;
        }

        /** @var array{password: string} $data */
        $data = $this->form->getState();

        $user->password = $data['password'];
        $user->clearTemporaryPassword()->save();

        // Sin la contraseña ni su hash: solo quién, cuándo y el motivo.
        app(AuditLogger::class)->record(
            AuditEventType::PasswordChanged,
            actor: $user,
            subject: $user,
            email: $user->email,
            context: ['reason' => 'temporary_password', 'panel' => Filament::getCurrentOrDefaultPanel()->getId()],
        );

        $this->keepSessionAfterPasswordChange($user);

        Notification::make()
            ->title(__('auth.change_temporary_password.saved'))
            ->success()
            ->send();

        $this->redirect(Filament::getUrl());
    }

    #[Unexposed]
    public function defaultForm(Schema $schema): Schema
    {
        return $schema->statePath('data');
    }

    #[Unexposed]
    public function form(Schema $schema): Schema
    {
        return $schema->components([
            $this->getPasswordFormComponent(),
            $this->getPasswordConfirmationFormComponent(),
        ]);
    }

    #[Unexposed]
    public function content(Schema $schema): Schema
    {
        return $schema->components([
            Form::make([EmbeddedSchema::make('form')])
                ->id('form')
                ->livewireSubmitHandler('save')
                ->footer([
                    Actions::make([
                        Action::make('save')
                            ->label(__('auth.change_temporary_password.submit'))
                            ->submit('save'),
                    ])->fullWidth()->key('form-actions'),
                ]),
        ]);
    }

    #[Unexposed]
    public function getTitle(): string|Htmlable
    {
        return __('auth.change_temporary_password.title');
    }

    #[Unexposed]
    public function getHeading(): string|Htmlable|null
    {
        return __('auth.change_temporary_password.heading');
    }

    #[Unexposed]
    public function getSubheading(): string|Htmlable|null
    {
        return __('auth.change_temporary_password.subheading');
    }

    protected function getPasswordFormComponent(): Component
    {
        return TextInput::make('password')
            ->label(__('auth.change_temporary_password.password.label'))
            ->password()
            ->revealable()
            ->autocomplete('new-password')
            ->required()
            ->rule(Password::default())
            ->rule(fn (): Closure => function (string $attribute, mixed $value, Closure $fail): void {
                $current = $this->user()?->getAuthPassword();

                if (is_string($value) && is_string($current) && Hash::check($value, $current)) {
                    $fail(__('auth.change_temporary_password.password.same_as_temporary'));
                }
            })
            ->same('passwordConfirmation')
            ->validationAttribute(__('validation.attributes.password'))
            ->validationMessages([
                'required' => __('auth.change_temporary_password.password.required'),
                'same' => __('auth.change_temporary_password.password_confirmation.same'),
            ])
            ->helperText(fn (): Htmlable => $this->strengthIndicator());
    }

    protected function getPasswordConfirmationFormComponent(): Component
    {
        return TextInput::make('passwordConfirmation')
            ->label(__('auth.change_temporary_password.password_confirmation.label'))
            ->password()
            ->revealable()
            ->autocomplete('new-password')
            ->required()
            ->validationMessages([
                'required' => __('auth.change_temporary_password.password_confirmation.required'),
            ])
            ->dehydrated(false);
    }

    /**
     * Indicador de fortaleza simple, calculado en el navegador (Alpine) para
     * no enviar la contraseña al servidor en cada tecla. Solo orienta: la
     * validación real es Password::defaults() en el servidor.
     */
    protected function strengthIndicator(): Htmlable
    {
        $labels = e((string) json_encode([
            'weak' => __('auth.change_temporary_password.strength.weak'),
            'fair' => __('auth.change_temporary_password.strength.fair'),
            'strong' => __('auth.change_temporary_password.strength.strong'),
        ], JSON_UNESCAPED_UNICODE));

        $requirements = e(__('passwords.requirements', ['min' => 10]));
        $label = e(__('auth.change_temporary_password.strength.label'));

        return new HtmlString(<<<HTML
            <span>{$requirements}</span>
            <span data-password-strength aria-live="polite"
                x-data="{
                    labels: {$labels},
                    level() {
                        const p = String(\$wire.\$get('data.password') ?? '');
                        if (p.length < 10) return 'weak';
                        let n = 0;
                        if (p.length >= 14) n++;
                        if (/[a-z]/.test(p) && /[A-Z]/.test(p)) n++;
                        if (/[0-9]/.test(p)) n++;
                        if (/[^A-Za-z0-9]/.test(p)) n++;
                        return n >= 3 ? 'strong' : 'fair';
                    },
                }"
                x-show="String(\$wire.\$get('data.password') ?? '').length > 0"
                style="display: block">
                {$label} <strong x-text="labels[level()]"></strong>
            </span>
            HTML);
    }

    /**
     * AuthenticateSession cerraría la sesión al detectar el nuevo hash: se
     * actualiza el hash guardado en la sesión y se regenera el identificador.
     */
    protected function keepSessionAfterPasswordChange(User $user): void
    {
        if (! request()->hasSession()) {
            return;
        }

        $guard = Filament::auth();
        $hash = $user->getAuthPassword();

        if ($guard instanceof SessionGuard) {
            $hash = $guard->hashPasswordForCookie($hash);
        }

        request()->session()->put('password_hash_'.Filament::getAuthGuard(), $hash);
        request()->session()->regenerate();
    }

    protected function user(): ?User
    {
        $user = Filament::auth()->user();

        return $user instanceof User ? $user : null;
    }
}
