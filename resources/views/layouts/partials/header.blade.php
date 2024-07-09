<nav class="fixed top-0 h-16 z-50 w-full bg-gray-100 shadow-lg border-gray-200 dark:bg-gray-800 dark:border-gray-700">
<header class="flex h-16 items-center justify-between py-3 px-6 border-gray-100" >
    <div id="header-left" class="flex items-center">

        <!-- side bar button for mobile -->
        @auth()
        <button data-drawer-target="default-sidebar" data-drawer-toggle="default-sidebar" aria-controls="default-sidebar" type="button" class="inline-flex items-center p-2 mr-5 ms-1 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
            <span class="sr-only">Open sidebar</span>
            <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
            </svg>
         </button>
        @endauth

        <div class="text-gray-800 font-semibold">
            <img class="h-14 object-cover" src="{{URL::asset('/images/ts-logo-min.png')}}"/>
        </div>

        @auth()
        <div class="ml-6">
            @include('layouts.components.searchbar')
        </div>

        @endauth
    </div>


    <div id="header-right" class="flex items-center md:space-x-6">
        @guest

            @include('layouts.partials.header-right-guest')

        @endguest

        @auth()

            @include('layouts.partials.header-right-auth')

        @endauth

    </div>

</header>
</nav>
