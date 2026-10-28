<?php

declare(strict_types=1);

namespace App\Providers\Filament;

use App\Filament\Support\StaffPanel;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Widgets\AccountWidget;

/**
 * Panel del plantel docente (/docente). Comparte guard y sesión con /admin.
 * El acceso se decide en User::canAccessPanel() (ADR-005 §3).
 */
class DocentePanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return StaffPanel::configure($panel)
            ->id('docente')
            ->path('docente')
            ->discoverResources(in: app_path('Filament/Docente/Resources'), for: 'App\Filament\Docente\Resources')
            ->discoverPages(in: app_path('Filament/Docente/Pages'), for: 'App\Filament\Docente\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Docente/Widgets'), for: 'App\Filament\Docente\Widgets')
            ->widgets([
                AccountWidget::class,
            ]);
    }
}
