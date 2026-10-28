<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Enums\AuditEventType;
use App\Models\User;
use App\Services\AuditLogger;
use Filament\Facades\Filament;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

/**
 * Registra en la bitácora cada respuesta 403 (HU-007 "Acceso no autorizado
 * por URL", ADR-005 §3). Se engancha como callback de render en
 * bootstrap/app.php y nunca cambia la respuesta: devuelve null para que
 * Laravel muestre la vista errors/403.
 *
 * Contexto mínimo: método, ruta (sin query string, que podría llevar datos
 * sensibles) y panel. Las políticas que niegan (AuthorizationException)
 * llegan aquí ya convertidas en AccessDeniedHttpException.
 */
final class RecordAccessDenied
{
    public function __invoke(HttpExceptionInterface $exception, Request $request): null
    {
        if ($exception->getStatusCode() !== 403) {
            return null;
        }

        try {
            $user = $request->user();

            app(AuditLogger::class)->record(
                AuditEventType::AccessDenied,
                actor: $user,
                email: $user instanceof User ? $user->email : null,
                context: [
                    'method' => $request->method(),
                    'path' => '/'.ltrim($request->path(), '/'),
                    'panel' => Filament::getCurrentPanel()?->getId(),
                ],
            );
        } catch (Throwable $e) {
            // La auditoría no debe impedir mostrar la página 403.
            report($e);
        }

        return null;
    }
}
