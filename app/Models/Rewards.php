<?php

namespace App\Models;

use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Rewards extends Model
{
    use HasFactory;

    protected $fillable = [
        'rewards_name',
        'rewards_image',
        'rewards_points',
        'rewards_quantity',
        'rewards_tier',
        'rewards_description',
    ];

    /**
     * Added img file dump for Rewards Image
     */
    protected static function boot()
    {
        parent::boot();

        /** @var Model $model */
        static::updating(function ($model) {
            if ($model->isDirty('rewards_image') && ($model->getOriginal('rewards_image') !== null)) {
                Storage::disk('public')->delete($model->getOriginal('rewards_image'));
            }
        });

        static::deleting(function ($model) {
            if ($model->rewards_image !== null) {
                Storage::disk('public')->delete($model->rewards_image);
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }

    public function getRewardsUrl()
    {
        $isUrl = str_contains($this->rewards_image, 'http');

        return ($isUrl) ? $this->rewards_image : Storage::disk('public')->url($this->rewards_image);
    }

    public function redeem($reward, $data){

        $user = Auth::user();

        $cost = $reward->rewards_points * $data['quantity'];
        $totalPts = $user->points;

        if($user->points >= $cost && $reward->rewards_quantity >= $data['quantity']){

            $user->update([
                'points' => $totalPts - $cost,
                'used_points' => $user->used_points + $cost,
            ]);

            $quantity = $reward->rewards_quantity;
            $value = $quantity - $data['quantity'];

            $reward->update([
                'rewards_quantity' => $value
            ]);

            RedeemHistory::create([
                'user_id' => $user->id,
                'rewards_id' => $reward->id,
                'redeemed_name' => $reward->rewards_name,
                'redeemed_image' => $reward->rewards_image,
                'redeemed_points' => $cost,
                'redeemed_quantity' => $data['quantity'],
                'redeemed_status' => 'Processing',
                'redeemed_by' => $user->name,
                'redeemed_user_note' => $data['note'],
                'expiry' => 1,
            ]);

            Notification::make()
                ->title(fn (Rewards $record): string => __("Successfully Redeemed {$record->rewards_name}"))
                ->success()
                ->send();

            //Mail::to($vendor->email)->send(new WorkorderAssigned($workorder));
        }

        elseif($user->points < $cost){
            Notification::make()
            ->title(fn (): string => __("Insuffcient Points"))
            ->danger()
            ->send();
        }

        elseif($reward->rewards_quantity < $data['quantity']){
            Notification::make()
            ->title(fn (): string => __("Quantity given is higher than Stock"))
            ->danger()
            ->send();
        }



    }

    public function addToWishlist($rewards){
        $user = auth()->user();
        $rewardId = $this->rewards->id;

        $wishlist = json_decode($user->wishlist, true) ?: [];



        if(\in_array($rewardId, $wishlist)){
            $this->hidden = '';
        }
        else{
            $wishlist[] = $rewardId;
            $user->wishlist = json_encode($wishlist);
            $user->save();

            return $this->afterAction();
        }
    }
}
