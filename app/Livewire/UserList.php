<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class UserList extends Component
{
    use WithPagination;

    #[Url()]
    public $search = '';

    #[On('search')]
    public function updateSearch($search)
    {
        $this->search = $search;
    }

    #[Computed()]
    public function userList()
    {
        return User::orderByRaw('RAND()')
        ->where('name', 'like', "%{$this->search}%")
        ->paginate(10);
    }

    public function render()
    {
        return view('livewire.user-list');
    }
}
