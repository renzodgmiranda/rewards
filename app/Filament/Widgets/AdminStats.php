<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Illuminate\Support\Facades\Auth;

class AdminStats extends BaseWidget
{

    protected static bool $isLazy = false;

    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 0;

    public $userCount, $allUserPoints, $allRewardsRedeemed;

    public function mount(): void{
        $this->userCount = User::query()->count();
        $this->allUserPoints = User::query()->sum('used_points');
        $this->allRewardsRedeemed = User::query()->sum('items_redeemed');
    }


    protected function getStats(): array
    {
        $user = Auth::user();
        if($user->hasAnyRole('Admin')){
            return [
                Stat::make('Total Users', $this->userCount)
                    ->icon('heroicon-o-user-circle'),
                Stat::make('Total Points used by all Users', $this->allUserPoints),
                Stat::make('Total Rewards Redeemed', $this->allRewardsRedeemed),
            ];
        }
        else{
            return [

            ];
        }
        
    }

    

}