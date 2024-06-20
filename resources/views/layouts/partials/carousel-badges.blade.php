<div id="default-carousel" class="relative w-full h-64 flex items-center justify-center" data-carousel="slide">

    <!-- Carousel wrapper -->
    <div class="absolute inset-0 flex items-center justify-center overflow-hidden w-64">
        <div class="relative h-16 overflow-hidden rounded-lg flex transition-transform duration-700 ease-in-out w-40 ml-12">
            @foreach($availableBadges as $badges)
            <div class="flex-shrink-0 w-16 h-16 mx-3" data-carousel-item>
                <div class="flex items-center justify-center w-full h-full border-2 border-orange-950 rounded-full mx-4">
                    <img class="rounded-full object-cover w-full h-full" src="storage/{{ $badges->badge_image }}" onerror="this.src='images/no-image.jpg';"/>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Slider indicators -->
    <div class="absolute z-30 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3 rtl:space-x-reverse">

        @php
            $counter = 0;

            $bool = true;

        @endphp

        @foreach($availableBadges as $badges)

        <button type="button" class="w-3 h-3 rounded-full bg-gray-500" aria-current="{{$bool}}" aria-label="Slide 1" data-carousel-slide-to="{{$counter}}"></button>

        @php
            $counter++;

            $bool = false;
        @endphp

        @endforeach

    </div>

    <!-- Slider controls -->
    <button type="button" class="ml-1 absolute top-1/2 -translate-y-1/2 start-0 z-30 flex items-center justify-center w-10 h-10 rounded-full bg-gray-300 cursor-pointer" data-carousel-prev>
        <svg class="w-4 h-4 text-black rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
        </svg>
    </button>
    <button type="button" class="mr-1 absolute top-1/2 -translate-y-1/2 end-0 z-30 flex items-center justify-center w-10 h-10 rounded-full bg-gray-300 cursor-pointer" data-carousel-next>
        <svg class="w-4 h-4 text-black rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
        </svg>
    </button>
</div>

<!-- Script for Carousel -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
    const carousel = document.getElementById('default-carousel');
    const container = carousel.querySelector('.flex.transition-transform');
    const items = carousel.querySelectorAll('[data-carousel-item]');
    const prevBtn = carousel.querySelector('[data-carousel-prev]');
    const nextBtn = carousel.querySelector('[data-carousel-next]');
    let currentIndex = 0;

    function showItems(index) {
        const offset = index * -80; // 64px (width) + 16px (total horizontal margin)
        container.style.transform = `translateX(${offset}px)`;
    }

    function nextSlide() {
        currentIndex = (currentIndex + 1) % items.length;
        showItems(currentIndex);
    }

    function prevSlide() {
        currentIndex = (currentIndex - 1 + items.length) % items.length;
        showItems(currentIndex);
    }

    nextBtn.addEventListener('click', nextSlide);
    prevBtn.addEventListener('click', prevSlide);

    // Initialize
    showItems(currentIndex);
});
</script>
