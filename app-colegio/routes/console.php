<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schedule;

/*
|--------------------------------------------------------------------------
| Tareas programadas (scheduler)
|--------------------------------------------------------------------------
|
| En el piloto se ejecutan con `php artisan schedule:work` (o un cron con
| `schedule:run` si la demostración corre en un servidor compartido).
|
*/

// Borra los tokens de restablecimiento de contraseña vencidos (HU-003).
Schedule::command('auth:clear-resets')->daily();
