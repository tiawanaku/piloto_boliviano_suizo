<?php

declare(strict_types=1);

namespace App\Filament\Docente\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Schemas\Components\EmptyState;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;

/**
 * Inicio del panel docente (HU-007). Vacío en la Fase 1: las aulas llegan
 * en la Fase 3 (EP-05), por eso muestra un mensaje explicativo.
 */
class Dashboard extends BaseDashboard
{
    public function getTitle(): string|Htmlable
    {
        return __('panels.docente.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('panels.docente.title');
    }

    public function content(Schema $schema): Schema
    {
        return $schema->components([
            EmptyState::make(__('panels.docente.empty_heading'))
                ->description(__('panels.docente.empty_description'))
                ->icon(Heroicon::OutlinedAcademicCap),
            $this->getWidgetsContentComponent(),
        ]);
    }
}
