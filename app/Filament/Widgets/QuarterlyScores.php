<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class QuarterlyScores extends BaseWidget
{
    protected static bool $isLazy = false;

    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 2;

    protected function getStats(): array
    {

        return [
            Stat::make('Q1', auth()->user()->q1_points)
                ->description('1st Quarter')
                ->color('primary'),
            Stat::make('Q2', auth()->user()->q2_points)
            ->description('2nd Quarter')
                ->color('primary'),
            Stat::make('Q3', auth()->user()->q3_points)
                ->description('3rd Quarter')
                ->color('primary'),
            Stat::make('Q4', auth()->user()->q4_points)
                ->description('4th Quarter')
                ->color('primary'),
        ];

        
    }
}
