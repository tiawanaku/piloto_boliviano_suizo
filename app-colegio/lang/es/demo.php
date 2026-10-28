<?php

declare(strict_types=1);

/*
| Textos del comando `php artisan colegio:demo` (T-0-11).
*/

return [

    'production' => 'colegio:demo no se puede ejecutar en producción: borra la base de datos. No se modificó ningún dato.',
    'confirm' => 'Se borrará la base de datos actual y se cargarán datos ficticios de demostración. ¿Continuar?',
    'cancelled' => 'Operación cancelada. No se modificó ningún dato.',
    'preparing' => 'Preparando la base de demostración (migrate:fresh --seed)…',
    'failed' => 'No se pudo preparar la base de demostración. Revise el mensaje anterior.',
    'ready' => 'Base de demostración lista. Solo contiene datos ficticios.',
    'urls' => 'Direcciones (con `composer dev` o `php artisan serve` en marcha):',
    'panel_admin' => 'Panel administrativo',
    'panel_docente' => 'Panel docente',
    'accounts' => 'Cuentas ficticias de demostración:',
    'columns' => [
        'name' => 'Nombre',
        'email' => 'Correo',
        'status' => 'Estado',
    ],
    'password' => 'Contraseña de todas las cuentas de demostración: :password (ficticia, solo para el piloto).',
    'mail' => 'Los correos no salen a personas reales: quedan en storage/logs/laravel.log o en Mailpit si está configurado.',

];
