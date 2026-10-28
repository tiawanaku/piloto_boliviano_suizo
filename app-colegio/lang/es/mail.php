<?php

declare(strict_types=1);

/*
| Textos de las plantillas de correo (resources/views/vendor/mail y
| vendor/notifications) y del correo de prueba (colegio:correo-prueba).
*/

return [

    'greeting' => '¡Hola!',
    'greeting_error' => '¡Ups!',
    'salutation' => 'Saludos,',
    'footer' => 'Colegio Virtual — piloto',
    'footer_notice' => 'Correo de un entorno de demostración con datos ficticios.',
    'subcopy' => 'Si el botón ":actionText" no funciona, copie y pegue este enlace en su navegador:',

    'test' => [
        'subject' => 'Correo de prueba del Colegio Virtual',
        'line' => 'Este es un correo de prueba. Si lo está leyendo, el envío de correos y la cola funcionan.',
        'command' => [
            'invalid_email' => 'Solo se permiten correos ficticios del dominio @:domain.',
            'queued' => 'Correo de prueba en cola para :email. Ejecute la cola (composer dev o php artisan queue:work) y revíselo en storage/logs/laravel.log o en Mailpit.',
        ],
    ],

];
