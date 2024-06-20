<div class="mr-80 ml-2 mt-5 h-60 text-center shadow rounded-lg bg-white">
    <div class="grid grid-cols-2 bg-white">
        <div class="font-sans font-normal text-regular justify-self-start text-white mt-4 ml-9 p-1 bg-orange-950 rounded-lg w-48 h-10 absolute">
            {{$claimedLabel}}
        </div>
        <div class="font-sans font-bold text-bold absolute justify-self-end text-tier mr-16 border-4 mt-4 border-orange-950 rounded-lg pl-10 py-1 pr-2">
            {{Auth::user()->used_points}}<span class="text-regular pl-1">PTS</span>
        </div>
    </div>

    <div class="grid grid-cols-5 w-full ml-9">
        @foreach($claimedRewards as $rewards)
        <div class="md:col-span-1 col-span-3 size-20">
            <div class="flex text-sm border-2 border-orange-950 rounded-full mt-20">
                <img class="rounded-full object-cover" src="storage/{{ $rewards->redeemed_image }}" onerror="this.src='images/no-image.jpg';"/>
            </div>

            <div class="font-regular -font-sans mt-3 flex justify-center">
                {{ $rewards->redeemed_name}}
            </div>

        </div>
        @endforeach


    </div>

</div>
