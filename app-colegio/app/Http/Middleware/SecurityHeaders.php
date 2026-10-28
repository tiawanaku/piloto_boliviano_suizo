<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Cabeceras de seguridad de los paneles del personal (TEC-13).
 *
 * La CSP va en modo informe (Content-Security-Policy-Report-Only) mientras se
 * verifica con Livewire/Alpine (necesitan 'unsafe-inline' y 'unsafe-eval').
 * HSTS solo se envía en peticiones HTTPS.
 */
final class SecurityHeaders
{
    public const CONTENT_SECURITY_POLICY = "default-src 'self'; "
        ."script-src 'self' 'unsafe-inline' 'unsafe-eval'; "
        ."style-src 'self' 'unsafe-inline' https://fonts.bunny.net; "
        ."font-src 'self' data: https://fonts.bunny.net; "
        ."img-src 'self' data: blob: https://ui-avatars.com; "
        ."connect-src 'self'; "
        ."frame-ancestors 'none'; "
        ."base-uri 'self'; "
        ."form-action 'self'; "
        ."object-src 'none'";

    /**
     * @param  Closure(Request): Response  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Content-Security-Policy-Report-Only', self::CONTENT_SECURITY_POLICY);

        if ($request->isSecure()) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }

        return $response;
    }
}
