@props(['users'])
<article class="[&:not(:last-child)]:border-b border-gray-100 w-full ml-16">
    <div class="article-body grid grid-cols-12 gap-3 mt-7 items-start bg-white dark:bg-gray-700 rounded-xl shadow-xl">
        <div class="article-thumbnail col-span-4 flex items-center ml-5 mt-5">
            <a wire:navigate href="{{ route('user-profile.show', $users->id)}}" >
                <img class="mx-auto rounded-xl size-28"
                    src="{{ $users->getProfileUrl() }}"
                    alt="thumbnail">
            </a>
        </div>
        <div class="col-span-8 mt-5">
            <h2 class="text-xl font-bold text-gray-900">
                <a wire:navigate href="{{ route('user-profile.show', $users->id)}}" >
                    {{ $users->name}}
                </a>
            </h2>
            <div class="article-meta flex py-1 text-sm items-center">
                <span class="text-gray-500 text-lg">{{$users->account}}</span>
            </div>

            <p class="mt-2 text-base text-gray-700 font-light">
                {{ $users->bio}}
            </p>
            <div class="article-actions-bar mt-6 flex items-center justify-between">
                <div class="flex">
                    <div class="mb-5 font-regular font-sans flex items-center text-sm">
                        @if ($users->tier >= 6)
                            <img class="rounded-full object-cover size-10 mr-3" src="{{URL::asset('/images/Plat.jpg')}}" onerror="this.src='{{URL::asset('/images/no-image.jpg')}}';"/>
                            <span>Platinum</span>
                        @endif

                        @if ($users->tier >= 4 && $users->tier < 6)
                            <img class="rounded-full object-cover size-10 mr-3" src="{{URL::asset('/images/Gold.jpg')}}" onerror="this.src='{{URL::asset('/images/no-image.jpg')}}';"/>
                            <span>Gold</span>
                        @endif

                        @if ($users->tier >= 2 && $users->tier < 4)
                            <img class="rounded-full object-cover size-10 mr-3" src="{{URL::asset('/images/Silver.jpg')}}" onerror="this.src='{{URL::asset('/images/no-image.jpg')}}';"/>
                            <span>Silver</span>
                        @endif

                        @if ($users->tier < 2)
                            <div class="rounded-full object-cover mr-3 size-6 border-2 border-gray-500 bg-gray-500"></div>
                            <div>Normal Account</div>
                        @endif

                    </div>
                </div>

            </div>
        </div>
    </div>
</article>
