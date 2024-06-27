<div class="ml-80 mr-2 mt-5 h-60 text-center shadow rounded-lg bg-white">
    <div class="font-sans font-regular justify-self-start text-white text-regular mt-4 ml-9 p-1 bg-orange-950 rounded-lg w-52 h-10 absolute">
        {{$availableLabel1}}
    </div>

    <div class="grid grid-cols-5 w-full ml-9">

        @php

        $counter = 1;

        @endphp

        @foreach($availableRewards as $rewards)
        <div class="md:col-span-1 col-span-3 size-20">
            <div class="flex text-sm border-2 border-orange-950 rounded-full mt-20">
                <div id="tooltip-rewards{{$counter}}" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-xs font-extralight text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                    {{$rewards->rewards_points}} Pts
                    <div class="tooltip-arrow" data-popper-arrow></div>
                </div>
                <img data-tooltip-target="tooltip-rewards{{$counter}}" class="rounded-full object-cover" src="storage/{{ $rewards->rewards_image }}" onerror="this.src='images/no-image.jpg';"/>
            </div>

            <div class="mt-3 flex font-sans font-normal justify-center">
                {{ $rewards->rewards_name}}
            </div>

        </div>

        @php
            $counter++ ;
        @endphp

        @endforeach

        <div class="h-6 w-6 pt-28">
            <button type="button" class="flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"><path d="M7.293 4.707 14.586 12l-7.293 7.293 1.414 1.414L17.414 12 8.707 3.293 7.293 4.707z"/></svg>
            </button>
        </div>
    </div>

</div>
