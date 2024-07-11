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

            <!--div class="w-full text-center py-32">
                <h1 class="text-2xl md:text-3xl font-bold text-center lg:text-5xl text-gray-700">
                    Welcome to <span class="text-yellow-500">&lt;YELO&gt;</span> <span class="text-gray-900"> News</span>
                </h1>
                <p class="text-gray-500 text-lg mt-1">Best Blog in the universe</p>
                <a class="px-3 py-2 text-lg text-white bg-gray-800 rounded mt-5 inline-block"
                    href="http://127.0.0.1:8000/blog">Start
                    Reading</a>
            </div-->

            <main class="container mx-auto px-5 mt-20">
                {{ $slot }}
            </main>

            @include('layouts.partials.footer')

        @stack('modals')

        @livewireScripts
    </body>
</html>
