<div class="absolute top-0 right-5 z-0 w-80 h-screen pl-0 sm:pl-5 pt-16 sm:pt-8 transition-transform -translate-x-full sm:translate-x-0" aria-label="Sidebar" aria-hidden="true">

    <div class="bg-white mt-12 mb-12 rounded-lg pb-3 shadow-lg">
        <div class="top-0 justify-center flex mt-8 mx-8 font-sans font-regular text-regular rounded-lg">
            Scan Here to Add Points for {{$userProfile->name}}
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

    <!-- Wish List -->
    <div class="bg-white mt-12 mb-12 rounded-lg pb-3 shadow-lg">
        <div class="top-0 justify-center bg-orange-950 flex mt-8 mx-8 font-sans font-regular text-regular text-white rounded-lg">
            {{$userProfile->name}}'s Wish List
        </div>
        <div class="m-2">

        </div>
    </div>

</div>
