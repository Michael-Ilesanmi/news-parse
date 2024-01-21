<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>NEWS APP - @yield('title')</title>

        <!-- Styles -->
        @notifyCss
        @vite('resources/css/app.css')
    </head>
    <body class="h-full w-full">
        <nav class="px-8 py-4 border-b-2 flex justify-between items-center">
            <h1 class="font-bold text-xl">NEWS APP</h1>
            @if (Auth::check())
                <a href="{{ route('logout') }}" class="px-4 py-2 font-semibold rounded-md outline outline-1 outline-red-600 hover:bg-red-600 hover:text-white transition ease-linear duration-300">Logout</a>
            @endif
        </nav>
        <div class="w-full pt-12 container">
            @yield('content')
        </div>
        <x:notify-messages />
        @notifyJs
    </body>
</html>
