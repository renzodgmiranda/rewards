
<x-app-layout :title="$userProfile->name">

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Profile') }}
        </h2>
    </x-slot>

        <div class="relative mt-20 ml-48 mr-5 z-40 w-9/12 h-auto px-2 py-5 transition-transform -translate-x-full sm:translate-x-0 bg-white rounded-lg shadow-lg" aria-label="UserPeg" aria-hidden="true">
            @include('user-profile.components.user-peg')
        </div>


        <div class="h-auto w-9/12 bg-white mt-5 ml-48 right-40 px-4 pt-5 pb-3 rounded-lg shadow-lg">
            <div class="top-0 justify-center bg-orange-950 flex w-36 mx-8 font-sans font-regular text-regular text-white rounded-lg">
                Badges:
            </div>

            <div class ="border-2 border-gray-300 rounded-lg shadow-lg w-full h-80 ml-2 mt-2 bg-white">
                <div class="grid grid-cols-6 gap-y-8 w-full ml-9 mt-8">
                    @foreach($userBadges as $badges)
                    <div class="md:col-span-1 col-span-3 justify-center">
                        <div class="flex text-sm border-2 border-orange-950 rounded-full size-16">
                            <img class="rounded-full object-cover" src="{{ $badges->getBadgeUrl() }}" onerror="this.src='{{URL::asset('/images/no-image.jpg')}}';"/>

                        </div>

                        <div class="font-regular text-sm font-sans mt-3 flex w-auto">
                            {{ $badges->badge_name}}
                        </div>

                    </div>
                    @endforeach

                    @if ($userBadges->isNotEmpty())
                    <div class="md:col-span-1 col-span-3 justify-center">
                        <a href="">
                            <div class="relative text-sm border-2 border-orange-950 bg-gray-400 rounded-full size-16">
                                @if ($extraBadges == 0)

                                @else
                                <div class="relative mx-4 mt-2 text-regular">
                                    {{$extraBadges}}+
                                </div>
                                <div class="mx-1.5 relative mt-1 text-xs">
                                    Show All
                                </div>

                                @endif
                            </div>
                        </a>
                    </div>

                    @endif


                </div>
            </div>



        </div>

    @include("user-profile.components.side-panel-right")

    <div class="h-auto w-9/12 bg-white mt-5 ml-48 right-40 px-4 pt-5 pb-3 rounded-lg shadow-lg">
        <div class="top-0 justify-center bg-orange-950 flex w-52 mx-8 font-sans font-regular text-regular text-white rounded-lg">
            Recently Claimed:
        </div>

        <div class ="border-2 border-gray-300 rounded-lg shadow-lg w-full h-80 ml-2 mt-2 bg-white">
            <div class="grid grid-cols-5 gap-y-8 w-full ml-9 mt-8">
                @foreach($claimedRewards as $claimed)
                    <div class="md:col-span-1 col-span-3 justify-center">
                        <div class="flex text-sm border-2 border-orange-950 rounded-lg h-36 w-36">
                            <img class="rounded-lg object-cover" src="{{ $claimed->getRedeemUrl() }}" onerror="this.src='{{URL::asset('/images/no-image.jpg')}}';"/>

                        </div>

                        <div class="font-regular text-regular font-sans mt-3 flex w-auto">
                            {{ $claimed->redeemed_name}}
                        </div>
                        <div class="font-regular text-regular font-sans mt-3 flex w-auto">
                            {{ $claimed->redeemed_points}} pts
                        </div>

                    </div>
                    @endforeach
            </div>
        </div>
    </div>

    <div class="w-9/12 bg-white mt-5 ml-48 right-40 px-4 pt-5 pb-3 rounded-lg shadow-lg" style="height: 1250px">
        <div class="top-0 justify-center bg-orange-950 flex w-52 mx-8 font-sans font-regular text-regular text-white rounded-lg">
            Point History
        </div>
        @include('user-profile.components.short-point-history')
    </div>



</x-app-layout>
