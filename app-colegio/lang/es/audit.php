<?php

declare(strict_types=1);

return [

    'immutable' => 'Los registros de auditoría no se pueden editar ni borrar.',

    'event_type' => [
        'login.succeeded' => 'Inicio de sesión correcto',
        'login.failed' => 'Inicio de sesión fallido',
        'logout' => 'Cierre de sesión',
        'access.denied' => 'Acceso denegado',
        'audit.exported' => 'Exportación de la bitácora',
    ],

    'result' => [
        'success' => 'Correcto',
        'failure' => 'Fallido',
        'denied' => 'Denegado',
    ],

];
