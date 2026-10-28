<?php

declare(strict_types=1);

namespace App\Filament\Support;

use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Models\Contracts\FilamentUser;
use Filament\Support\Icons\Heroicon;

/**
 * Ítem del menú de usuario "Cambiar a panel …" (HU-007). Solo es visible si
 * el usuario puede entrar al otro panel; como la sesión es compartida, el
 * cambio no pide un nuevo login. La autorización real la hace el panel
 * destino con User::canAccessPanel().
 */
final class PanelSwitchAction
{
    public static function make(string $targetPanelId): Action
    {
        return Action::make('switch-to-'.$targetPanelId)
            ->label(__('panels.switch_to.'.$targetPanelId))
            ->icon(Heroicon::OutlinedArrowsRightLeft)
            ->url(fn (): ?string => Filament::getPanel($targetPanelId)->getUrl())
            ->visible(function () use ($targetPanelId): bool {
                $user = Filament::auth()->user();

                return $user instanceof FilamentUser
                    && $user->canAccessPanel(Filament::getPanel($targetPanelId));
            });
    }
}
