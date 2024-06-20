<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Auth\ProfileSettings;
use App\Filament\Pages\Auth\Registration;
use App\Filament\Resources\AnnouncementResource;
use App\Filament\Resources\PermissionResource;
use App\Filament\Resources\RedeemHistoryResource;
use App\Filament\Resources\RewardsResource;
use App\Filament\Resources\RoleResource;
use App\Filament\Resources\UserResource;
use App\Filament\Widgets\AdminStats;
use App\Filament\Widgets\PillarsPoints;
use App\Filament\Widgets\UserMultiWidget;
use App\Filament\Widgets\UserPoints;
use Filament\Facades\Filament;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
use Filament\Navigation\NavigationBuilder;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Filament\Pages;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\Widget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Shanerbaner82\PanelRoles\PanelRoles;
use Rupadana\FilamentAnnounce\FilamentAnnouncePlugin;

class HomePanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->brandName('Rewards')
            ->brandLogo(asset('images/tslogo.png'))
            ->brandLogoHeight('3rem')
            ->topNavigation()
            ->profile(ProfileSettings::class, isSimple: false)
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                AccountWidget::class,
                UserMultiWidget::class,
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
            ])
            ->userMenuItems([
                MenuItem::make('Points')
                ->label(function(){
                    $user = Auth::user();

                    $msg = "Your Points: " . $user->points . " Pts";
                    return $msg;
                }),
                MenuItem::make('Tier')
                ->label(function(){
                    $user = Auth::user();

                    $msg = "Your Tier: Level " . $user->tier . "";
                    return $msg;
                }),
            ])
            ->plugin(
                FilamentAnnouncePlugin::make()
                    ->pollingInterval('30s') // optional, by default it is set to null
                    ->defaultColor(Color::Blue) // optional, by default it is set to "primary"
            )
            ->registration(Registration::class);



    }
}
