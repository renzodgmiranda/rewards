<?php

namespace App\Livewire;

use App\Models\Rewards;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;

class RewardsList extends Component
{
    public $counter;

    #[Url()]
    public $search = '';

    #[Url()]
    public $sort = '';

    #[On('search')]
    public function updateSearch($search)
    {
        $this->search = $search;
    }

    public function setSort($sort)
    {
        $this->sort = $sort;
    }

    public function isBronze()
    {
        if($this->sort == 1){
            return true;
        }
        else{
            return false;
        }
    }

    public function isSilver()
    {
        if($this->sort == 2){
            return true;
        }
        else{
            return false;
        }
    }

    public function isGold()
    {
        if($this->sort == 3){
            return true;
        }
        else{
            return false;
        }
    }


    public function isPlatinum()
    {
        if($this->sort == 4){
            return true;
        }
        else{
            return false;
        }
    }

    #[Computed()]
    public function rewardsList()
    {
        return Rewards::orderBy('rewards_points', 'desc')
        ->where('rewards_name', 'like', "%{$this->search}%")
        ->where('rewards_tier', 'like', "%{$this->sort}%")
        ->paginate(12);
    }

    public function render()
    {
        return view('livewire.rewards-list');
    }
}
