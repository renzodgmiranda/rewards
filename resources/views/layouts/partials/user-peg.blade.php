<div class="relative my-5">
    <div class="mx-16 relative my-5">
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <button class="flex text-sm border-2 border-gray-200 bg-gray-800 rounded-full">
                <a href="{{ route('profile.show') }}">
                    <div class="imageInn">
                        <div id="tooltip-profile" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-xs font-extralight text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                            Change Profile Picture
                            <div class="tooltip-arrow" data-popper-arrow></div>
                        </div>
                        <img data-tooltip-target="tooltip-profile" class="size-20 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}"
                        alt="{{ Auth::user()->name }}" />
                    </div>
                </a>
            </button>
        @else
            <span class="inline-flex rounded-md">
                <button type="button"
                    class="font-sans font-normal text-regular inline-flex items-center px-3 py-2 border border-transparent leading-4 rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                    {{ Auth::user()->name }}

                    <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
            </span>
        @endif
    </div>

    <div class="mx-8 mb-2">
        <div class="font-sans font-normal text-regular dark:text-white"> {{ Auth::user()->name }} </div>
        <div class="font-sans font-semibold text-regular dark:text-white">  {{ Auth::user()->account }} </div>
    </div>

    <div class="mx-8 mb-5 size-10 font-regular font-sans flex items-center text-sm">
        @if (Auth::user()->tier >= 6)
            <img class="rounded-full object-cover mr-3" src="{{URL::asset('/images/Plat.jpg')}}" onerror="this.src='{{URL::asset('/images/no-image.jpg')}}';"/>
            <span>Platinum</span>
        @endif

        @if (Auth::user()->tier >= 4 && Auth::user()->tier < 6)
            <img class="rounded-full object-cover mr-3" src="{{URL::asset('/images/Gold.jpg')}}" onerror="this.src='{{URL::asset('/images/no-image.jpg')}}';"/>
            <span>Gold</span>
        @endif

        @if (Auth::user()->tier >= 2 && Auth::user()->tier < 4)
            <img class="rounded-full object-cover mr-3" src="{{URL::asset('/images/Silver.jpg')}}" onerror="this.src='{{URL::asset('/images/no-image.jpg')}}';"/>
            <span>Silver</span>
        @endif

        @if (Auth::user()->tier < 2)
            <div>Normal Account</div>
        @endif

    </div>

    <div class="mx-8 mt-1 flex">
        <a class="flex space-x-2 items-center hover:text-yellow-900 text-xs text-yellow-500 underline underline-offset-1"
            href="{{ route('profile.show') }}">
            Manage Profile
        </a>
    </div>

    @include("layouts.components.pointcounter")

</div>

