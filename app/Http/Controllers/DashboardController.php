<?php

namespace App\Http\Controllers;

use App\Filament\Resources\UserResource;
use App\Models\BadgeBoard;
use App\Models\Badges;
use App\Models\Post;
use App\Models\RedeemHistory;
use App\Models\Rewards;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $count = Badges::count();
        $authId = auth()->user()->id;
        $hasBadges = Badgeboard::where('badge_owner', $authId)->pluck('badge_name');
        $badgeCount = Badgeboard::where('badge_owner', $authId)->count();
        $posts = Post::where('post_users', 'like', '%'. $authId .'%')->latest()->get();

        return view('dashboard', [
            'availableRewards' => Rewards::inRandomOrder()->limit(4)->whereNot('rewards_quantity', 0)->get(),
            'claimedRewards' => RedeemHistory::take(4)->where('redeemed_status', 'Redeemed')->where('redeemed_by', auth()->user()->name)->get(),
            'availableBadges' => Badges::take($count)->whereNotIn('badge_name', $hasBadges)->inRandomOrder()->get(),
            'claimedLabel' => 'Claimed Reward(s):',
            'availableLabel1' => 'Available Reward(s):',
            'availableLabel2' => 'Available Badge(s):',
            'qr' => UserResource::getUrl('addPts', ['record' => auth()->user()]),
            'userBadges' => BadgeBoard::take($badgeCount)->owner(auth()->user())->get(),
            'announcmentPosts' => $posts,
        ]);
    }
}
