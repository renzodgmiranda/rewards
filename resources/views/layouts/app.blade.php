<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="font-sans antialiased bg-mainbg">
        <x-banner />

            @include('layouts.partials.header')

            @yield('hero')

            <main class="container mx-auto px-5 mt-10 ">

                @auth
                <div class="sidebar">
                    @include('layouts.partials.sidebar')
                </div>

                @endauth

                {{ $slot }}
            </main>

            @include('layouts.partials.footer')

        @stack('modals')

        @livewireScripts
        @livewire('wire-elements-modal')
        <script src="../path/to/flowbite/dist/flowbite.min.js"></script>
        <script src="./node_modules/flowbite/dist/flowbite.js"></script>
    </body>
</html>
