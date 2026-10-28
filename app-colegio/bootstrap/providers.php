<?php

declare(strict_types=1);

use App\Providers\AppServiceProvider;
use App\Providers\Filament\AdminPanelProvider;
use App\Providers\Filament\DocentePanelProvider;
use App\Providers\StaffAuthServiceProvider;

return [
    AppServiceProvider::class,
    AdminPanelProvider::class,
    DocentePanelProvider::class,
    StaffAuthServiceProvider::class,
];
