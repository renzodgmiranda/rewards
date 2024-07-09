<div id="default-sidebar" class="absolute top-0 right-0 z-0 w-80 h-screen pl-0 sm:pl-5 pt-16 sm:pt-20 transition-transform -translate-x-full sm:translate-x-0" aria-label="Sidebar" aria-hidden="true">

    <div class="bg-white mb-12 rounded-lg pb-3 shadow-lg">
        <div class="top-0 justify-center flex mt-5 font-sans font-regular text-regular rounded-lg">
            Scan Here
        </div>

        @php
            $size = [
                'size' => '250',
                'type' => 'svg',
                'margin' => '1',
                'color' => 'rgba(74, 74, 74, 1)',
                'back_color' => 'rgba(252, 252, 252, 1)',
                'style' => 'square',
                'hasGradient' => false,
                'gradient_form' => 'rgb(69, 179, 157)',
                'gradient_to' => 'rgb(241, 148, 138)',
                'gradient_type' => 'vertical',
                'hasEyeColor' => false,
                'eye_color_inner' => 'rgb(241, 148, 138)',
                'eye_color_outer' => 'rgb(69, 179, 157)',
                'eye_style' => 'square',
            ];
        @endphp

        <div class="m-2">
            {{\LaraZeus\Qr\Facades\Qr::render(data: $qr, downloadable: false, options: $size)}}
        </div>
    </div>


    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-md h-3/5">
        <!-- Label -->
        <div class="font-sans font-regular justify-self-start text-white text-regular mt-5 ml-5 p-1 pl-2 bg-orange-950 rounded-lg w-48 h-10 absolute">
            {{$availableLabel2}}
        </div>

        @include('layouts.partials.carousel-badges')

        <!-- Divider-->
        <div class="flex w-64 bg-tier h-1 rounded-full mx-6"></div>

        <div class="font-sans font-regular justify-self-start text-white text-regular mt-4 ml-10 p-1 pl-2 bg-orange-950 rounded-lg w-40 h-10 absolute">
            @php
                $badge = "Badge(s):";
            @endphp
            {{$badge}}
        </div>

        <div class="grid grid-cols-2 w-full ml-9">
            @foreach($userBadges as $badges)
            <div class="md:col-span-1 col-span-3 size-16 mb-14">
                <div class="flex text-sm border-2 border-orange-950 rounded-full mt-20">
                    <img class="rounded-full object-cover" src="storage/{{ $badges->badge_image }}" onerror="this.src='images/no-image.jpg';"/>
                </div>

                <div class="mt-3 flex font-sans font-normal justify-center text-xs">
                    {{ $badges->badge_name}}
                </div>
            </div>
            @endforeach
        </div>



    </div>

</div>
