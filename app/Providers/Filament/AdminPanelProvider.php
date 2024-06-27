<?php

namespace App\Providers\Filament;

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
use Filament\FontProviders\GoogleFontProvider;
use Filament\Enums\ThemeMode;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('/')
            ->login()
            ->sidebarCollapsibleOnDesktop()
            ->brandName('Lana Hospital')
            ->favicon(asset('images/favicon.png'))
            // ->brandLogo(asset('images/logo.png'))
            ->brandLogo(fn () => view('filament.admin.logo'))
            ->brandLogoHeight('3.5rem')
            ->profile()
            ->colors([
                // 'danger' => Color::Red,
                // 'gray' => Color::Zinc,
                // 'info' => Color::Blue,
                // 'primary' => Color::Green,
                // 'success' => Color::Green,
                // 'warning' => Color::Amber,
                'primary' => Color::hex('#00a74a'), // Darkened green
                'secondary' => Color::hex('#c00'),  // Darkened red
                'background' => Color::hex('#ffffff'),         // White
                'surface' => Color::hex('#f5f5f5'),             // Light grey for surface elements
                'onPrimary' => Color::hex('#ffffff'),          // Text color on primary background (white)
                'onSecondary' => Color::hex('#ffffff'),        // Text color on secondary background (white)
                'onBackground' => Color::hex('#000000'),       // Text color on background (black)
                'onSurface' => Color::hex('#000000'),          // Text color on surface (black)
                'success' => Color::hex('#5cb85c'),            // Success color (green)
                'info' => Color::hex('#5bc0de'),               // Info color (blue)
                'warning' => Color::hex('#f0ad4e'),            // Warning color (yellow/orange)
                'danger' => Color::hex('#d9534f'),             // Danger color (red)
                'light' => Color::hex('#f8f9fa'),              // Light grey background
                'dark' => Color::hex('#343a40'),               // Dark grey background
                'link' => Color::hex('#007bff'),
            ])
            ->defaultThemeMode(ThemeMode::Dark)
            ->font('Inter', provider: GoogleFontProvider::class)
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->navigationGroups([
                'MENU ITEMS',
                'Email',
                'CONFIGURATIONS',
            ])
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                // Widgets\FilamentInfoWidget::class,
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
