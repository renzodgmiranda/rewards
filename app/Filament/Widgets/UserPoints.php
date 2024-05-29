<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Illuminate\Support\Facades\Auth;

class UserPoints extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 0;

    protected static bool $isLazy = false;

    protected function getStats(): array
    {
        $user = Auth::user();

        if($user->hasAnyRole('Employee')){
            return [
                Stat::make('Your Points', auth()->user()->points)
                    ->icon('heroicon-o-sparkles'),
                Stat::make('Total Points Used', auth()->user()->used_points),
                Stat::make('Items Redeemed', auth()->user()->items_redeemed),
            ];
        }
        else{
            return[

            ];
        }
        
    }

    

}
