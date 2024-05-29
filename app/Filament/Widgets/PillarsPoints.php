<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class PillarsPoints extends BaseWidget
{
    protected static bool $isLazy = false;

    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 1;

    protected function getStats(): array
    {

        return [
            Stat::make('SRS', auth()->user()->srs_points)
                ->description('Social Responsibility & Sustainability')
                ->color('primary'),
            Stat::make('HW', auth()->user()->hw_points)
                ->description('Health & Wellness')
                ->color('primary'),
            Stat::make('TW', auth()->user()->tw_points)
                ->description('Teamwork')
                ->color('primary'),
        ];

        
    }
}
