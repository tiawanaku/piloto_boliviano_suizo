<?php

declare(strict_types=1);

return [

    'immutable' => 'Los registros de auditoría no se pueden editar ni borrar.',

    // Claves = valor de App\Enums\AuditEventType con "_" en lugar de ".".
    'event_type' => [
        'login_succeeded' => 'Inicio de sesión correcto',
        'login_failed' => 'Inicio de sesión fallido',
        'logout' => 'Cierre de sesión',
        'access_denied' => 'Acceso denegado',
        'audit_exported' => 'Exportación de la bitácora',
        'password_changed' => 'Cambio de contraseña',
    ],

    'result' => [
        'success' => 'Correcto',
        'failure' => 'Fallido',
        'denied' => 'Denegado',
    ],

];
