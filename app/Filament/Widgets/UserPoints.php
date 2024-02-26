<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Illuminate\Support\Facades\Auth;

class UserPoints extends BaseWidget
{

    public function getPoints(){
        $user = Auth::user();

        return $user->points;
    }

    protected function getStats(): array
    {
        return [
            Stat::make('Your Points', auth()->user()->points)
                ->icon('heroicon-o-sparkles'),
            Stat::make('Total Points Used', auth()->user()->used_points),
            Stat::make('Items Redeemed', auth()->user()->items_redeemed),
        ];
    }

    

}
