<div id="default-carousel" class="relative w-full h-52 flex items-center justify-center" data-carousel="slide">

    <!-- Carousel wrapper -->
    <div id="badge-carousel" class="absolute inset-0 flex items-center justify-center overflow-hidden w-64">
        <div class="relative h-16 overflow-hidden rounded-lg grid transition-transform duration-700 ease-in-out w-64 ml-12 grid-cols-2">
            @foreach($availableBadges as $badges)
            <div class="w-16 h-16 ml-16" data-carousel-item>
                <div class="items-center justify-center w-full h-full border-2 border-orange-950 rounded-full">
                    <img class="rounded-full object-cover w-full h-full" src="storage/{{ $badges->badge_image }}" onerror="this.src='images/no-image.jpg';"/>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Slider indicators -->
    <div class="absolute z-30 flex -translate-x-1/2 bottom-8 left-1/2 space-x-3 rtl:space-x-reverse bg-gray-300 p-1">
        @php
            $counter = 0;

            $bool = true;

        @endphp

        @foreach($availableBadges as $badges)

        <button type="button" class="w-3 h-3 rounded-full " aria-current="{{$bool}}" aria-label="Slide {{$slide = $counter + 1}}" data-carousel-slide-to="{{$counter}}"></button>

        @php
            $counter++;

            $bool = false;
        @endphp

        @endforeach
    </div>

    <!-- Slider controls -->
    <button type="button" class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-1 cursor-pointer group focus:outline-none" data-carousel-prev>
        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-gray-400 dark:bg-gray-800/30 group-hover:bg-gray-300 dark:group-hover:bg-gray-800/60">
            <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
            </svg>
            <span class="sr-only">Previous</span>
        </span>
    </button>
    <button type="button" class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-3 cursor-pointer group focus:outline-none" data-carousel-next>
        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-gray-400 dark:bg-gray-800/30 group-hover:bg-gray-300 dark:group-hover:bg-gray-800/60">
            <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
            </svg>
            <span class="sr-only">Next</span>
        </span>
    </button>
</div>

