<?php

namespace App\Livewire;

use Livewire\Component;

class SearchboxRewards extends Component
{
    public $search = '';

    public $sort = '';

    public function updatedSearch()
    {
        $this->dispatch('search', search : $this->search);
    }

    public function render()
    {
        return view('livewire.searchbox-rewards');
    }
}
