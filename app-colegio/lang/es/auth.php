<?php

declare(strict_types=1);

/*
| Mensajes de autenticación. Son genéricos a propósito: no revelan si el
| correo existe ni el estado de la cuenta (ver Flujo de autenticacion).
*/

return [

    'failed' => 'El correo o la contraseña no son correctos.',
    'password' => 'La contraseña no es correcta.',
    'throttle' => 'Demasiados intentos de inicio de sesión. Intente de nuevo en :seconds segundos.',

    // Página de login del personal (HU-001).
    'institutional_email' => 'Usa tu correo institucional (termina en @:dominio).',

    'login' => [
        'failed' => 'Correo o contraseña incorrectos.',
        'inactive' => 'Tu cuenta no está activa. Comunícate con secretaría o la oficina de información.',
        'temporary_password_expired' => 'Tu contraseña temporal venció. Solicita una nueva a secretaría.',
        'email' => [
            'label' => 'Correo institucional',
            'placeholder' => 'nombre.apellido@:dominio',
            'required' => 'Ingresa tu correo institucional.',
            'email' => 'Escribe un correo válido, por ejemplo nombre.apellido@:dominio.',
        ],
        'password' => [
            'label' => 'Contraseña',
            'required' => 'Ingresa tu contraseña.',
        ],
        'submit' => 'Ingresar',
    ],

    // Cambio obligatorio de la contraseña temporal (HU-006).
    'change_temporary_password' => [
        'title' => 'Define tu contraseña',
        'heading' => 'Define tu propia contraseña',
        'subheading' => 'Ingresaste con una contraseña temporal. Para continuar, crea una contraseña que solo tú conozcas.',
        'password' => [
            'label' => 'Nueva contraseña',
            'required' => 'Ingresa tu nueva contraseña.',
            'same_as_temporary' => 'La nueva contraseña debe ser distinta de la temporal.',
        ],
        'password_confirmation' => [
            'label' => 'Repite la nueva contraseña',
            'required' => 'Repite tu nueva contraseña.',
            'same' => 'Las contraseñas no coinciden.',
        ],
        'strength' => [
            'label' => 'Fortaleza:',
            'weak' => 'débil',
            'fair' => 'aceptable',
            'strong' => 'fuerte',
        ],
        'submit' => 'Guardar contraseña',
        'saved' => 'Tu contraseña se guardó. Ya puedes usar la plataforma.',
    ],

];
