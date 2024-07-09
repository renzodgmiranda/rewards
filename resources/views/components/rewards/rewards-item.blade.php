@props(['rewards'])
<article class="w-72 h-auto place-content-center mr-5">
    <div class="grid gap-3 mt-7 items-center justify-items-center dark:bg-gray-700">
        <div class="bg-blue_cus1 text-center text-white font-sans font-semibold text-regular rounded-lg shadow-xl py-1 w-52">{{$rewards->rewards_name}}</div>
        <div class="border-orange-950 border-4 rounded-lg shadow-xl "><img class="object-cover" src="{{$rewards->getRewardsUrl()}}" onerror="this.src='{{URL::asset('/images/no-image.jpg')}}';"></div>
        <div class="grid justify-items-center items-center rounded-lg bg-gray-100 p-3 text-blue_cus1">
            <div class="font-sans font-bold text-pts20 ">
                {{$rewards->rewards_points}}<span class="text-regular"> pts</span>
            </div>
            <div class="font-sans font-bold text-regular w-44">
                Amount Left: <span class="text-pts20"> {{ $rewards->rewards_quantity > 0 ? $rewards->rewards_quantity : 'Out of Stock' }}</span>
            </div>
        </div>
        <div class="grid justify-items-center items-center text-white">
            @if ($rewards->rewards_quantity == 0)

            <button data-modal-target="wishlist" data-modal-toggle="wishlist" class="hover:p-5 transition-all p-3 w-56 font-sans font-semibold text-regular bg-orange_cus1 rounded-lg shadow-xl flex items-center justify-center space-x-2" type="button"
                onclick="Livewire.dispatch('openModal', { component: 'wishlist-modal', arguments: { rewards: {{ $rewards->id }} }})">
                <svg xmlns="http://www.w3.org/2000/svg" width="{{ $width ?? 24 }}" height="{{ $height ?? 24 }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ $strokeWidth ?? 2 }}" stroke-linecap="round" stroke-linejoin="round" {{ $attributes }}>
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="16"></line>
                    <line x1="8" y1="12" x2="16" y2="12"></line>
                </svg>
                <span>Add to wishlist</span>
            </button>

            @else
                @if (auth()->user()->tier < $rewards->rewards_tier)
                <div class="transition-all p-3 font-sans font-semibold text-base bg-red-600 rounded-lg shadow-xl">
                    Your Tier is too low
                </div>
                @endif
                @if (auth()->user()->points < $rewards->rewards_points)
                <div class="transition-all p-3 font-sans font-semibold text-base bg-red-600 rounded-lg shadow-xl">
                    Your Points are too low
                </div>
                @endif
                @if (auth()->user()->tier >= $rewards->rewards_tier && auth()->user()->points >= $rewards->rewards_points)
                <button class="hover:p-5 transition-all p-3 font-sans font-semibold text-regular bg-yellow_cus1 rounded-lg shadow-xl" onclick="Livewire.dispatch('openModal', { component: 'confirm-modal', arguments: { rewards: {{ $rewards->id }} }})">
                    Redeem
                </button>
                @endif
            @endif
        </div>
    </div>
</article>



