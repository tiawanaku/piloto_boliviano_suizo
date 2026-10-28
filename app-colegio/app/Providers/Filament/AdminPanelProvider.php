<?php

declare(strict_types=1);

namespace App\Providers\Filament;

use App\Filament\Support\PanelSwitchAction;
use App\Filament\Support\StaffPanel;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Widgets\AccountWidget;

/**
 * Panel del plantel administrativo (/admin), panel por defecto.
 * El acceso se decide en User::canAccessPanel() (ADR-005 §3).
 */
class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return StaffPanel::configure($panel)
            ->default()
            ->id('admin')
            ->path('admin')
            ->discoverResources(in: app_path('Filament/Admin/Resources'), for: 'App\Filament\Admin\Resources')
            ->discoverPages(in: app_path('Filament/Admin/Pages'), for: 'App\Filament\Admin\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Admin/Widgets'), for: 'App\Filament\Admin\Widgets')
            ->widgets([
                AccountWidget::class,
            ])
            ->userMenuItems([
                PanelSwitchAction::make('docente'),
            ]);
    }
}
