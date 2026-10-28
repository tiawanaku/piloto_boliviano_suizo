<?php

declare(strict_types=1);

/*
| Textos del comando `php artisan colegio:crear-cuenta` (T-1-10).
*/

return [

    'email_attribute' => 'correo',
    'role_required' => 'Indica al menos un rol con --rol.',
    'role_invalid' => 'El rol indicado no existe o no es un rol del personal.',
    'created' => 'Cuenta creada y activa: :email',
    'roles' => 'Roles: :roles',
    'password_once' => 'Contraseña temporal (se muestra solo esta vez; entrégala por un canal seguro): :password',
    'expires' => 'La contraseña temporal vence el :date y debe cambiarse en el primer ingreso.',

];
