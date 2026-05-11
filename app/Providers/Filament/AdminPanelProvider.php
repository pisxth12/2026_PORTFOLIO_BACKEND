<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Auth\CustomLogin;
use App\Filament\Widgets\ActivityTimeline;
use App\Filament\Widgets\LatestProjects;
use App\Filament\Widgets\ProjectsByTech;
use App\Filament\Widgets\RecentMessages;
use App\Filament\Widgets\SkillsChart;
use App\Filament\Widgets\StatsOverview;
use App\Filament\Widgets\WelcomeWidget;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationItem;
use Filament\Navigation\UserMenuItem;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->favicon(asset('images/favicon.ico'))
            ->login()
            ->path('sorn-piseth-admin')
            ->brandName('')
            ->userMenuItems([
                'profile' => UserMenuItem::make()
                    ->label('My Profile')
                    ->icon('heroicon-o-user-circle'),
                'logout' => UserMenuItem::make()
                    ->label('Logout')
                    ->icon('heroicon-o-arrow-right-on-rectangle'),
            ])
            ->navigationItems([
                NavigationItem::make('Visit Website')
                    ->url('https://pisethsorn.site', shouldOpenInNewTab: true)
                    ->icon('heroicon-o-globe-alt')
                    ->sort(1),
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                StatsOverview::class,
                WelcomeWidget::class,
                SkillsChart::class,
                ProjectsByTech::class,
                LatestProjects::class,
                RecentMessages::class,
                ActivityTimeline::class,
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
