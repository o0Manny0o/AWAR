<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Http\Request;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Stancl\Tenancy\Contracts\TenantCouldNotBeIdentifiedException;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

class TenantAdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('tenant-admin')
            ->path('admin')
            ->colors([
                'primary' => Color::Amber,
            ])
            ->login()
            ->domain('foo.awar.test')
            ->brandName(fn() => tenant()->name)
            ->discoverResources(
                in: app_path('Filament/TenantAdmin/Resources'),
                for: 'App\Filament\TenantAdmin\Resources',
            )
            ->discoverPages(
                in: app_path('Filament/TenantAdmin/Pages'),
                for: 'App\Filament\TenantAdmin\Pages',
            )
            ->pages([Dashboard::class])
            ->discoverWidgets(
                in: app_path('Filament/TenantAdmin/Widgets'),
                for: 'App\Filament\TenantAdmin\Widgets',
            )
            ->widgets([AccountWidget::class, FilamentInfoWidget::class])
            ->middleware([
                InitializeTenancyByDomain::class,
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([Authenticate::class]);
    }
}
