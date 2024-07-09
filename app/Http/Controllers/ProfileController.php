<?php

namespace App\Http\Controllers;

use App\Filament\Resources\UserResource;
use App\Models\BadgeBoard;
use App\Models\Badges;
use App\Models\PointHistory;
use App\Models\Post;
use App\Models\RedeemHistory;
use App\Models\Rewards;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        return view('user-profile.index',
        [
            'userList' => User::take(5)->get(),
        ]);
    }

    public function show(User $profile)
    {
        $badgeCount = Badgeboard::where('badge_owner', $profile->id)->count();

        if($badgeCount > 11){
            $extraBadges = $badgeCount - 11;
        }

        else{
            $extraBadges = 0;
        }

        return view(
            'user-profile.show',
            [
                'userProfile' => $profile,
                'claimedRewards' => RedeemHistory::take(5)->recentlyclaimed($profile)->latest()->get(),
                'qr' => UserResource::getUrl('addPts', ['record' => $profile]),
                'userBadges' => BadgeBoard::take(11)->owner($profile)->get(),
                'extraBadges' => $extraBadges,
                'pointLog' => $pointLog = PointHistory::findOrFail($profile->id)
            ]
        );
    }

}
