<?php

declare(strict_types=1);

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Rechaza contraseñas que aparecen en la lista local de contraseñas comunes
 * (resources/data/common-passwords.txt). La comparación ignora mayúsculas y
 * espacios en los extremos. Complementa Password::uncompromised() sin
 * depender de la red (HU-006).
 */
final class NotCommonPassword implements ValidationRule
{
    /** @var array<string, true>|null */
    private static ?array $list = null;

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_string($value)) {
            return;
        }

        if (isset(self::list()[mb_strtolower(trim($value))])) {
            $fail('passwords.common')->translate();
        }
    }

    /**
     * @return array<string, true>
     */
    private static function list(): array
    {
        if (self::$list !== null) {
            return self::$list;
        }

        $lines = file(resource_path('data/common-passwords.txt'), FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $list = [];

        foreach ($lines === false ? [] : $lines as $line) {
            $line = mb_strtolower(trim($line));

            if ($line !== '' && ! str_starts_with($line, '#')) {
                $list[$line] = true;
            }
        }

        return self::$list = $list;
    }
}
