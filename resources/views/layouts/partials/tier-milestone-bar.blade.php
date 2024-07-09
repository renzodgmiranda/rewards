<div class="progress-bar w-full h-12 relative">
    <div class="grid gap-y-20 grid-cols-2 mb-4 bg-white">
        <div class="font-sans font-normal justify-self-start text-white text-regular mt-4 ml-9 p-1 bg-orange-950 rounded-lg w-44 h-10">
            Running Points:
        </div>
        <!--div class="font-sans font-bold justify-self-end text-tier text-bold mr-16 border-4 p-2 mt-4 border-orange-950 px-10 rounded-lg">
            TIER {{Auth::user()->tier}}
        </div-->
    </div>

    <div class="flex w-11/12 ml-10 bg-gray-200 rounded-full h-2.5 dark:bg-gray-700 relative">
        <div class="flex points-bar bg-blue-600 h-2.5 rounded-full z-50" style="width: {{ Auth::user()->pointBarPercent(auth()->user()->points) }}%">
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

<style>
    .circle {
        position: absolute;
        z-index: 100;
    }
</style>
