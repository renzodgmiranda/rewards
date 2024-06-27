@php

@endphp

<x-app-layout :title="$userProfile->name">

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Profile') }}
        </h2>
    </x-slot>

        <div class="relative mt-20 ml-48 mr-5 z-40 w-9/12 h-auto px-2 py-5 transition-transform -translate-x-full sm:translate-x-0 bg-white rounded-lg shadow" aria-label="UserPeg" aria-hidden="true">
            @include('user-profile.components.user-peg')
        </div>
        <div class="h-auto w-9/12 bg-white mt-5 ml-48 right-40 px-4 pt-5 pb-3 bg-white rounded-lg shadow">
            <div class="label mb-5 font-sans font-semibold text-xl">
                Badges:
            </div>

            <div class ="border-2 border-gray-300 w-full h-80 shadow ml-2 mt-2 bg-white">
                <div class="grid grid-cols-6 gap-y-8 w-full ml-9 mt-8">
                    @foreach($userBadges as $badges)
                    <div class="md:col-span-1 col-span-3 justify-center">
                        <div class="flex text-sm border-2 border-orange-950 rounded-full size-16">
                            <img class="rounded-full object-cover" src="{{ $badges->getBadgeUrl() }}" onerror="this.src='images/no-image.jpg';"/>

                        </div>

                        <div class="font-regular text-sm font-sans mt-3 flex w-auto">
                            {{ $badges->badge_name}}
                        </div>

                    </div>
                    @endforeach

                    <div class="md:col-span-1 col-span-3 justify-center">
                        <a href="">
                            <div class="relative text-sm border-2 border-orange-950 bg-gray-400 rounded-full size-16">
                                @if ($extraBadges == 0)
                                <div class="mx-1.5 relative mt-5 text-xs">
                                    Show All
                                </div>

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

                </div>
            </div>



        </div>

    @include("user-profile.components.side-panel-right")

</x-app-layout>
