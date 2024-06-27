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

    @include('layouts.partials.help-modal-dashboard')

    @foreach ($announcmentPosts as $item)
    <div class="mb-10 mx-28 bg-white shadow rounded-lg">
        <div class="mb-16">
            <div class="w-full">
                <article class="col-span-4 md:col-span-3 mt-10 mx-auto py-5 w-full" style="max-width:700px">
                    <h1 class="text-4xl font-bold text-left text-gray-800 mb-5">
                        {{$item->post_title}}
                    </h1>

                    @if ($item->post_image)
                        <img class="w-full my-2 rounded-lg" src="storage/{{ $item->post_image }}">
                    @endif

                    <div class="mt-2 flex justify-between items-center">
                        <div class="flex py-5 text-base items-center">
                            <img class="w-10 h-10 rounded-full mr-3" src="storage/{{$item->post_owner_profile}}" onerror="">
                            <span class="mr-1">{{$item->post_owner}}</span>
                            <span class="text-gray-500 text-sm">| {{$item->getReadingTime()}} min read</span>
                        </div>
                        <div class="flex items-center">
                            <span class="text-gray-500 mr-2">{{$item->created_at->diffForHumans()}}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.3"
                                stroke="currentColor" class="w-5 h-5 text-gray-500">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>

                    <div class="article-content py-3 text-gray-800 text-lg text-justify">
                        {!! $item->post_body !!}
                    </div>

                </article>
            </div>
        </div>
    </div>
    @endforeach

    <!-- Right Panel -->
    @include('layouts.partials.side-panel-right')

</x-app-layout>
