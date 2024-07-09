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

        $size = [
            'size' => '250',
            'type' => 'svg',
            'margin' => '1',
            'color' => 'rgba(74, 74, 74, 1)',
            'back_color' => 'rgba(252, 252, 252, 1)',
            'style' => 'square',
            'hasGradient' => false,
            'gradient_form' => 'rgb(69, 179, 157)',
            'gradient_to' => 'rgb(241, 148, 138)',
            'gradient_type' => 'vertical',
            'hasEyeColor' => false,
            'eye_color_inner' => 'rgb(241, 148, 138)',
            'eye_color_outer' => 'rgb(69, 179, 157)',
            'eye_style' => 'square',
        ];

        $wishlist = json_decode($profile->wishlist, true) ?: [];

        return view(
            'user-profile.show',
            [
                'userProfile' => $profile,
                'claimedRewards' => RedeemHistory::take(5)->recentlyclaimed($profile)->latest()->get(),
                'qr' => UserResource::getUrl('addPts', ['record' => $profile]),
                'userBadges' => BadgeBoard::take(11)->owner($profile)->get(),
                'extraBadges' => $extraBadges,
                'pointLog' => $pointLog = PointHistory::findOrFail($profile->id),
                'size' => $size,
                'wishlist' => Rewards::whereIn('id', $wishlist)->get()
            ]
        );
    }

}
