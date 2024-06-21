<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <!-- Fixed Top Section -->
    @section('hero')
    <div class="w-auto mx-80 mt-20 pb-20 text-center shadow rounded-lg bg-white">
        @include('layouts.partials.tier-milestone-bar')
    </div>

    <div class="grid grid-cols-2">
        <div>
            @include('layouts.partials.available-rewards')
        </div>

        <div>
            @include('layouts.partials.claimed-rewards')
        </div>
    </div>

    <div class="w-auto mx-80 mt-5 text-center rounded-lg">
        @include('layouts.partials.point-breakdown')
    </div>
    @endsection
    <!-- End of Section -->

    <div class="mb-10 mx-28 bg-white shadow rounded-lg">
        <div class="mb-16">

        </div>
        <hr>
    </div>

    <!-- Right Panel -->
    @include('layouts.partials.side-panel-right')

</x-app-layout>
