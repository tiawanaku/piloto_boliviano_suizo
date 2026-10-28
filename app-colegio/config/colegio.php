<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Configuración del Colegio Virtual (piloto)
|--------------------------------------------------------------------------
|
| Parámetros de negocio de la Fase 1 (identidad y seguridad). Ver
| ADR-005 y las historias HU-001 a HU-008 del vault. Todos los valores
| se pueden ajustar por variable de entorno.
|
*/

return [

    // Dominio de los correos institucionales del personal (solo ficticio en el piloto).
    'dominio_institucional' => env('COLEGIO_DOMINIO_INSTITUCIONAL', 'colegio-piloto.test'),

    // Minutos de inactividad tras los cuales se cierra la sesión (HU-002).
    'sesion_inactividad_minutos' => (int) env('COLEGIO_SESION_INACTIVIDAD_MINUTOS', 30),

    // Bloqueo por intentos fallidos de inicio de sesión (HU-004).
    'bloqueo' => [
        'intentos' => (int) env('COLEGIO_BLOQUEO_INTENTOS', 5),
        'ventana_minutos' => (int) env('COLEGIO_BLOQUEO_VENTANA_MINUTOS', 15),
        'minutos' => (int) env('COLEGIO_BLOQUEO_MINUTOS', 15),
    ],

    // Vigencia de la contraseña temporal (HU-006).
    'contrasena_temporal_horas' => (int) env('COLEGIO_CONTRASENA_TEMPORAL_HORAS', 72),

    // Vigencia de la invitación al personal (HU-009).
    'invitacion_horas' => (int) env('COLEGIO_INVITACION_HORAS', 72),

    // Vigencia del enlace de restablecimiento de contraseña (HU-003).
    'restablecimiento_minutos' => (int) env('COLEGIO_RESTABLECIMIENTO_MINUTOS', 30),

];
