<div>
    <div class="py-4">
        @foreach ($this->userList as $item)
        <x-user-profile.search-item :users="$item"/>
        @endforeach
    </div>
    <div class="my-3">
        {{$this->userList->onEachSide(1)->links()}}
    </div>
</div>

