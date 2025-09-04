<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Favorites;
use App\Filament\Pages\Gallery;
use App\Filament\Resources\UserImages\UserImageResource;
use App\Http\Middleware\SetLocale;
use Filament\Actions\Action;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class UserPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->brandName('Capsule')
            ->darkMode(true)
            ->id('user')
            ->path('user')
            ->login()
            ->renderHook(
                PanelsRenderHook::SIMPLE_LAYOUT_START,
                fn(): string => view('components.language-switcher')->render(),
            )
            ->registration()
            ->passwordReset()
            ->colors([
                'primary' => Color::Indigo,
            ])
            ->viteTheme('resources/css/filament/user/theme.css')
            ->pages([
                Gallery::class,
                Favorites::class,
            ])
            ->resources([
                UserImageResource::class,
            ])
            ->navigationGroups([
                'Gallery',
                'content',
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
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
                SetLocale::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }

    public function boot(): void
    {
        FilamentView::registerRenderHook(
            'panels::topbar.end',
            fn(): string => view('components.language-switcher')->render(),
        );
    }
}
