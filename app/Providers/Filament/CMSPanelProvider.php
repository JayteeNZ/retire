<?php

namespace App\Providers\Filament;

use App\Filament\CMS\Pages\EmployerForm;
use App\Filament\CMS\Pages\JobSeeker;
use App\Filament\CMS\Pages\JobSeekerForm;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class CMSPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('CMS')
            ->path('website')
            ->colors([
                'primary' => Color::Green,
            ])
            ->brandName('Temp Website')
            ->discoverResources(in: app_path('Filament/CMS/Resources'), for: 'App\\Filament\\CMS\\Resources')
            ->discoverPages(in: app_path('Filament/CMS/Pages'), for: 'App\\Filament\\CMS\\Pages')
            ->pages([
//                Pages\Dashboard::class,
                JobSeekerForm::class,
                EmployerForm::class,
            ])
            ->topNavigation()
            ->discoverWidgets(in: app_path('Filament/CMS/Widgets'), for: 'App\\Filament\\CMS\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
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
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
