<?php

namespace App\Livewire;

use App\Models\Rewards;
use App\Models\User;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class WishlistModal extends ModalComponent
{
    public Rewards $rewards;

    public $hidden = 'hidden';

    public function render()
    {
        return view('livewire.wishlist-modal');
    }

    public function addToWishlist(){
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

    public function afterAction(){
        $this->redirect('/rewards');
    }
}
