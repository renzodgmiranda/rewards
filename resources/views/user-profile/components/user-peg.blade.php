<div class="relative">
    <div class="ml-16 flex items-center">
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div class="flex text-sm border-2 border-gray-200 bg-gray-800 rounded-full size-16">
                    <div class="imageInn">
                        <img class="rounded-full object-cover" src="{{ $userProfile->profile_photo_url }}"
                        alt="{{ $userProfile->name }}" />
                    </div>
                </div>
        @else
            <span class="inline-flex rounded-md">
                <button type="button"
                    class="font-sans font-normal text-regular inline-flex items-center px-3 py-2 border border-transparent leading-4 rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                    {{ $userProfile->name }}

                    <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
            </span>
        @endif


        <div class="my-2 grid ml-8">
            <div class="font-sans font-normal text-regular dark:text-white"> {{ $userProfile->name }} </div>
            <div class="font-sans font-semibold text-regular dark:text-white">  {{ $userProfile->account }} </div>
        </div>

        <div class="relative left-2/4">
            <div class="mb-5 font-regular font-sans flex items-center text-sm">
                @if ($userProfile->tier == 4)
                    <img class="rounded-full object-cover size-10 mr-3" src="{{URL::asset('/images/Plat.jpg')}}" onerror="this.src='{{URL::asset('/images/no-image.jpg')}}';"/>
                    <span>Platinum</span>
                @endif

                @if ($userProfile->tier == 3)
                    <img class="rounded-full object-cover size-10 mr-3" src="{{URL::asset('/images/Gold.jpg')}}" onerror="this.src='{{URL::asset('/images/no-image.jpg')}}';"/>
                    <span>Gold</span>
                @endif

                @if ($userProfile->tier == 2)
                    <img class="rounded-full object-cover size-10 mr-3" src="{{URL::asset('/images/Silver.jpg')}}" onerror="this.src='{{URL::asset('/images/no-image.jpg')}}';"/>
                    <span>Silver</span>
                @endif

                @if ($userProfile->tier == 1)
                    <img class="rounded-full object-cover size-10 mr-3" src="{{URL::asset('/images/Bronze.jpg')}}" onerror="this.src='{{URL::asset('/images/no-image.jpg')}}';"/>
                    <div>Bronze</div>
                @endif

            </div>
        </div>
    </div>

    <div class="ml-10 flex items-center">
        <div class="relative font-sans font-semibold justify-self-start text-base my-4 mx-2 p-1 rounded-lg w-96 h-auto text-neutral-500">
            Bio:<span class="font-sans font-normal y-4">
                {{$userProfile->bio}}
            </span>
        </div>

        @include("user-profile.components.pointcounter")
    </div>

    <div class="font-sans font-normal justify-self-start text-white text-regular ml-9 p-1 bg-orange-950 rounded-lg w-44 h-10">
        <div class="ml-2">
            Running Points:
        </div>
    </div>
    <div class="flex w-11/12 ml-10 mt-3 mb-10 bg-gray-200 rounded-full h-2.5 dark:bg-gray-700 relative">
        <div class="flex points-bar bg-blue-600 h-2.5 rounded-full z-50" style="width: {{ $userProfile->pointBarPercent($userProfile->points) }}%">
            <div class="circles-container flex justify-between w-full absolute top-0 left-0">
                @foreach ([0, 16, 32.7, 49.5, 66, 83, 99] as $percentage)
                    <div id="tooltip-{{$percentage}}" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-3 text-xs font-extralight text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                        @if($percentage == 0)
                            Bronze
                        @endif
                        @if($percentage == 32.7)
                            Silver
                        @endif
                        @if($percentage == 66)
                            Gold
                        @endif
                        @if($percentage == 99)
                            Platinum
                        @endif
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                    <div data-tooltip-target="tooltip-{{$percentage}}" class="transition ease-in-out delay-50 circle bg-white border border-blue-800 hover:bg-blue-800 rounded-full hover:scale-110 duration-300 w-2.5 h-2.5" style="left: {{ $percentage }}%;"></div>
                @endforeach
                @foreach ([0, 15.2, 32, 48.8, 65, 82, 98] as $label)
                    <div class="mt-3 absolute font-sans font-normal" style="left: {{ $label }}%;">
                        @if($label == 0)
                            0
                        @endif
                        @if($label == 15.2)
                            300
                        @endif
                        @if($label == 32)
                            600
                        @endif
                        @if($label == 48.8)
                            900
                        @endif
                        @if($label == 65)
                            1200
                        @endif
                        @if($label == 82)
                            1500
                        @endif
                        @if($label == 98)
                            1800
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>


</div>
