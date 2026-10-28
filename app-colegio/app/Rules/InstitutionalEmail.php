<?php

declare(strict_types=1);

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;

/**
 * El correo debe pertenecer al dominio institucional del colegio
 * (config colegio.dominio_institucional). No acepta subdominios ni
 * dominios que solo terminen igual (p. ej. "otro-colegio-piloto.test").
 */
final class InstitutionalEmail implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_string($value) || ! self::passes($value)) {
            $fail('auth.institutional_email')->translate([
                'dominio' => self::domain(),
            ]);
        }
    }

    public static function passes(string $email): bool
    {
        $email = Str::lower(trim($email));

        if (substr_count($email, '@') !== 1) {
            return false;
        }

        [$local, $domain] = explode('@', $email);

        return $local !== '' && $domain === self::domain();
    }

    public static function domain(): string
    {
        return Str::lower(config()->string('colegio.dominio_institucional'));
    }
}
