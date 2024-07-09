<div class="absolute top-0 right-5 z-0 w-80 h-screen pl-0 sm:pl-5 pt-16 sm:pt-8 transition-transform -translate-x-full sm:translate-x-0" aria-label="Sidebar" aria-hidden="true">

    <div class="bg-white mt-12 mb-12 rounded-lg pb-3 shadow-lg">
        <div class="top-0 justify-center flex mt-8 mx-8 font-sans font-regular text-regular rounded-lg">
            Scan Here to Add Points for {{$userProfile->name}}
        </div>

        <div class="m-2">
            {{\LaraZeus\Qr\Facades\Qr::render(data: $qr, downloadable: false, options: $size)}}
        </div>
    </div>

    <!-- Wish List -->
    <div class="bg-white mt-12 mb-12 rounded-lg py-2 shadow-lg h-auto">
        <div class="bg-orange-950 flex mx-8 font-sans font-regular text-regular text-white rounded-lg p-2">
            {{$userProfile->name}}'s Wish List
        </div>
        <div class="m-2 rounded-lg border-gray-300 border">
            @foreach ($wishlist as $item)
            <div class="w-full p-1 border-b border-gray-300 p-2 text-regular font-semibold font-sans">
                {{$item->rewards_name}}
            </div>
            @endforeach
        </div>
    </div>

</div>
