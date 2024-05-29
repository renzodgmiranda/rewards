<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Kenepa\MultiWidget\MultiWidget;

class UserMultiWidget extends MultiWidget
{
    protected static bool $isLazy = false;

    protected static ?int $sort = 3;
    
    //protected static string $view = 'filament.widgets.user-multi-widget';
    public static function canView(): bool
    {
        return true;
    }

    public array $widgets = [
        Badges::class,
        AvailableRewards::class,
        ClaimedRewards::class,
    ];

    public function shouldPersistMultiWidgetTabsInSession(): bool
    {
        return true;
    }
}
