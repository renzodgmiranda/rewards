<?php

namespace App\Livewire;

use App\Models\Rewards;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class WishlistModal extends ModalComponent
{
    public Rewards $rewards;

    public function render()
    {
        return view('livewire.wishlist-modal');
    }
}
